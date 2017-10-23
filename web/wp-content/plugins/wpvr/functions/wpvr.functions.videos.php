<?php
	
	
	/* Render Player with Dynamic Tags and options */
	if ( ! function_exists( 'wpvr_render_modified_player' ) ) {
		function wpvr_render_modified_player( $post_id = null, $second_call = false ) {
			global $wpvr_options, $wpvr_dynamics;
			// ob_start();
			
			if ( $post_id == null ) {
				global $post;
				$post_id = $post->ID;
			}
			
			$wpvr_video_id = get_post_meta( $post_id, 'wpvr_video_id', true );
			$wpvr_service  = get_post_meta( $post_id, 'wpvr_video_service', true );
			
			//$wpvr_player_tags = apply_filters( 'wpvr_extend_player_tags', $wpvr_dynamics['player_tags'] );
			
			$player_arguments  = apply_filters( 'wpvr_extend_video_player_arguments', array(), $post_id );
			$player_attributes = apply_filters( 'wpvr_extend_video_player_attributes', array(), $post_id );
			$player_classes    = apply_filters( 'wpvr_extend_video_player_classes', array(), $post_id );
			$player_autoplay   = is_single() ? $wpvr_options['playerAutoPlay'] : false;
			
			
			// if ( isset( $wpvr_dynamics['player_options'][ $wpvr_service ] ) ) {
			// 	$player_arguments = $wpvr_dynamics['player_options'][ $wpvr_service ];
			// }
			//d( $wpvr_dynamics );
			
			$player_html = '';
			$player_html .= '<div class="wpvr_embed wpvr_new ' . implode( ' ', $player_classes ) . '">';
			$player_html .= apply_filters( 'wpvr_extend_around_video_player_inner', '', 'before', $post_id );
			$player_html .= wpvr_video_embed(
				$wpvr_video_id,
				$post_id,
				$player_autoplay,
				$wpvr_service,
				false, //Add Style
				$player_arguments,
				$player_attributes
			);
			$player_html .= apply_filters( 'wpvr_extend_around_video_player_inner', '', 'after', $post_id );;
			$player_html .= '</div>';
			
			$player_wrap = '';
			$player_wrap .= apply_filters( 'wpvr_extend_around_video_player', '', 'before', $post_id );
			$player_wrap .= apply_filters( 'wpvr_extend_video_player', $player_html, $post_id );
			$player_wrap .= '<div>' . apply_filters( 'wpvr_extend_around_video_player', '', 'after', $post_id ) . '</div>';
			
			//d( 'using WPVR PLAYER' );
			return $player_wrap;
		}
	}
	
	/* Check if a video is valid */
	if ( ! function_exists( 'wpvr_is_valid_video' ) ) {
		function wpvr_is_valid_video( $video_id, $video_service ) {
			return true;
		}
	}
	
	/* Get a single youtube video data */
	if ( ! function_exists( 'wpvr_get_video_single_data' ) ) {
		function wpvr_get_video_single_data( $video_id, $service = '' ) {
			global $wpvr_vs;
			
			return $wpvr_vs[ $service ]['get_single_video_data']( $video_id );
		}
	}
	
	/* ADD A VIDEO OBJECT  */
	if ( ! function_exists( 'wpvr_add_video' ) ) {
		function wpvr_add_video( $videoItem, $_wpvr_imported = array(), $allowDuplicates = false ) {
			
			global
			$wpvr_imported,
			$wpvr_options,
			$wpvr_vs;
			
			global $wpvr_force_duplicates;
			
			$timer = wpvr_chrono_time();
			
			$videoItem = apply_filters( 'wpvr_extend_video_before_adding', $videoItem );
			//d( $videoItem );
			
			
			$return = array(
				'status'   => true,
				'errors'   => array(),
				'messages' => array(),
			);
			
			
			if ( isset( $videoItem['add_video_source_unwanted'] ) ) {
				$videoItem['origin'] = 'by RULE';
				$videoItem['owner']  = 0;
				wpvr_add_video_unwanted( $videoItem, $videoItem['source']->id );
			}
			
			if ( isset( $videoItem['add_video_global_unwanted'] ) ) {
				$videoItem['origin'] = 'by RULE';
				$videoItem['owner']  = 0;
				wpvr_add_video_unwanted( $videoItem, false );
			}
			
			if ( isset( $videoItem['skip_adding_this'] ) ) {
				return false;
			}
			
			
			if ( ! isset( $wpvr_force_duplicates ) ) {
				$wpvr_force_duplicates = false;
			}
			
			// Do not add if video already imported
			if ( $wpvr_force_duplicates === false && isset( $wpvr_imported[ $videoItem['service'] ][ $videoItem['id'] ] ) ) {
				return false;
			}
			
			/* If this video is already imported => Don't do anything */
			if ( $allowDuplicates === false ) {
				if ( $wpvr_force_duplicates === false && isset( $_wpvr_imported[ $videoItem['service'] ][ $videoItem['id'] ] ) ) {
					return false;
				}
			}
			//d( $videoItem );
			/* Checking if we use the original Posting Date or create a new one */
			if ( $videoItem['postDate'] == 'original' ) {
				$video_post_date = $videoItem['originalPostDate'];
			} else {
				if ( isset( $videoItem['importedPostDate'] ) ) {
					$obj_post_date = wpvr_make_postdate( $videoItem['importedPostDate'] );
				} else {
					$obj_post_date = wpvr_make_postdate();
				}
				$video_post_date = $obj_post_date->format( 'Y-m-d H:i:s' );
				//_d( $video_post_date );
			}
			
			// _d( $video_post_date );
			
            // _d( $videoItem['postStatus'] );
            
			/* Check if we publish the video or keep it on pending */
			if ( isset( $videoItem['postStatus'] ) && $videoItem['postStatus'] != '' ) {
				$video_status = $videoItem['postStatus'];
			}else{
				$video_status = $videoItem['autoPublish'] == 'on' ? 'publish' : 'pending';
			}
			
			// _d( $video_status );
			
			
			// Define Video Title
			if ( $videoItem['postAppend'] != 'off' && $videoItem['postAppendName'] != 'false' ) {
				if ( $videoItem['postAppend'] == 'before' || $videoItem['postAppend'] == 'customBefore' ) {
					$video_title = $videoItem['postAppendName'] . WPVR_APPEND_SEPARATOR . $videoItem['title'];
				} elseif ( $videoItem['postAppend'] == 'after' || $videoItem['postAppend'] == 'customAfter' ) {
					$video_title = $videoItem['title'] . WPVR_APPEND_SEPARATOR . $videoItem['postAppendName'];
				} else {
					$video_title = $videoItem['title'];
				}
			} else {
				$video_title = $videoItem['title'];
			}
			
			// Define Video Description
			if ( $videoItem['service'] == 'youtube' && $wpvr_options['getFullDesc'] === true ) {
				$video_meta               = wpvr_get_video_single_data( $videoItem['id'], $videoItem['service'] );
				$videoItem['description'] = $video_meta['desc'];
			} else {
				//$video_desc = $videoItem[ 'description' ];
			}
			
			//_d( $video_desc );
			
			// Essential Grid Fix
			if ( WPVR_EG_FIX === true ) {
				$iframe                   = '<iframe src="http://www.youtube.com/embed/' . $videoItem['id']
				                            . '?rel=0" width="560" height="315" frameborder="0" allowfullscreen="allowfullscreen"></iframe>';
				$videoItem['description'] = $iframe . $videoItem['description'];
			}
			
			// Correct Author Variable Type if not array
			if ( is_object( $videoItem['author'] ) ) {
				$videoItem['author'] = (array) $videoItem['author'];
			}
			
			// Define new WP Post
			$newPost = array(
				'post_title'  => $video_title,
				'post_date'   => $video_post_date,
				'post_status' => $video_status,
				'post_type'   => WPVR_VIDEO_TYPE,
				'post_author' => $videoItem['postAuthor'],
			);
			
			
			if ( ! isset( $videoItem['postContent'] ) || $videoItem['postContent'] == 'default' ) {
				$videoItem['postContent'] = $wpvr_options['getFullDesc'] ? 'on' : 'off';
			}
			
			// DEfine WP Post Content
			if ( isset( $videoItem['postContent'] ) && $videoItem['postContent'] == 'on' ) {
				$newPost['post_content'] = $videoItem['description'];
			}
			
			// Insert WP New Post
			$newPostId = @wp_insert_post( $newPost );
			//d( $newPostId );
			
			// Define Formats
			if ( WPVR_ENABLE_POST_FORMATS ) {
				if ( ! isset( $videoItem['postFormat'] ) ) {
					$videoItem['postFormat'] = $wpvr_options['postFormat'];
				}
				set_post_format( $newPostId, $videoItem['postFormat'] );
			}
			
			
			//Define Embed Code Meta
			$videoItem_embedCode = wpvr_video_embed(
				$videoItem['id'],
				$newPostId,
				false,
				$videoItem['service']
			);
			
			// DEfine Video Views
			if ( isset( $videoItem['local_views'] ) && is_numeric( $videoItem['local_views'] ) ) {
				$video_views = $videoItem['local_views'];
			} else {
				if ( $wpvr_options['startWithServiceViews'] === true ) {
					$video_views = $videoItem['views'];
				} else {
					$video_views = 0;
				}
			}
			
			if ( ! isset( $videoItem['author'] ) ) {
				$videoItem['author'] = array(
					'id'        => '',
					'title'     => '',
					'link'      => '',
					'thumbnail' => '',
				);
			}
			
			$now = new Datetime( 'now', new DateTimeZone( 'UTC' ) );
			
			$video_param_key = 'wpvr_video_' . $wpvr_vs[ $videoItem['service'] ]['pid'] . 'Id';
			
			$video_metas = array(
				
				// Video Service Param
				$video_param_key                      => $videoItem['id'],
				
				// Video Core Meta
				'wpvr_video_id'                       => $videoItem['id'],
				'wpvr_video_duration'                 => $videoItem['duration'],
				'wpvr_video_embed_code'               => $videoItem_embedCode,
				'wpvr_video_views'                    => $video_views,
				
				//Service Meta Info
				'wpvr_video_service'                  => $videoItem['service'],
				'wpvr_video_service_icon'             => $videoItem['icon'],
				'wpvr_video_service_hqthumb'          => $videoItem['hqthumb'],
				'wpvr_video_service_thumb'            => $videoItem['thumb'],
				'wpvr_video_service_url'              => $videoItem['url'],
				'wpvr_video_service_views'            => $videoItem['views'],
				'wpvr_video_service_date'             => $videoItem['originalPostDate'],
				'wpvr_video_service_desc'             => $videoItem['description'],
				
				// Video Author MEtas
				'wpvr_video_service_author_id'        => $videoItem['author']['id'],
				'wpvr_video_service_author_name'      => $videoItem['author']['title'],
				'wpvr_video_service_author_thumbnail' => $videoItem['author']['thumbnail'],
				'wpvr_video_service_author_link'      => $videoItem['author']['link'],
				
				//Source Meta Info
				'wpvr_video_sourceId'                 => $videoItem['sourceId'],
				'wpvr_video_sourceName'               => $videoItem['sourceName'],
				'wpvr_video_sourceType'               => $videoItem['sourceType'],
				'wpvr_video_importDate'               => $now->format( 'Y-m-d H:i:s' ),
				
				'wpvr_video_startTime'             => $videoItem['startTime'],
				'wpvr_video_endTime'               => $videoItem['endTime'],
				'wpvr_video_hidePlayerRelated'     => $videoItem['hidePlayerRelated'],
				'wpvr_video_hidePlayerTitle'       => $videoItem['hidePlayerTitle'],
				'wpvr_video_hidePlayerAnnotations' => $videoItem['hidePlayerAnnotations'],
			
			);
			if ( isset( $videoItem['post_meta'] ) ) {
				foreach ( (array) $videoItem['post_meta'] as $meta_key => $meta_value ) {
					$video_metas[ $meta_key ] = $meta_value;
				}
			}
			
			$video_metas = apply_filters( 'wpvr_extend_video_metas', $video_metas, $videoItem );
			//_d( $video_metas );
			$metas_report = wpvr_add_multiple_post_meta( $newPostId, $video_metas );
			
			//Define Tags from Title
			$title_tags = WPVR_TAGS_FROM_TITLE_ENABLE ? explode( '-', sanitize_file_name( $videoItem['title'] ) ) : array();
			
			//d( $videoItem[ 'tags' ]  );
			
			//Define Tags of Video
			$video_tags = array_merge(
				$title_tags,
				$videoItem['tags'],
				$videoItem['source_tags']
			);
			
			wp_set_post_tags( $newPostId, $video_tags, true );
			wp_set_post_categories( $newPostId, $videoItem['postCats'] );
			wp_set_post_terms( $newPostId, 'en', 'language' );
			
			
			//_d( $videoItem['downloadThumb'] );
			// die();
			
			if ( isset( $videoItem['thumb_id'] ) && $videoItem['thumb_id'] != '' ) {
				
				// Thumbnail is already on DB and SERVER, just assign it to the video
				set_post_thumbnail( $newPostId, $videoItem['thumb_id'] );
				
			} elseif ( $videoItem['thumb'] != '' ) {
				
				$thumb = wpvr_download_featured_image(
					$thumb = $videoItem['hqthumb'],
					$fallback_thumb = $videoItem['thumb'],
					$videoItem['title'],
					$videoItem['description'],
					$newPostId, '',
					$videoItem['downloadThumb']
				);
				if ( $thumb != false ) {
					do_action( 'wpvr_event_add_video_thumbnail', $videoItem, $newPostId, $thumb['file'] );
				}
				
			}
			
			wpvr_run_dataFillers( $newPostId );
			
			//update old videos
			$_wpvr_imported[ $videoItem['service'] ][ $videoItem['id'] ] = $newPostId;
			
			// wpvr_reset_debug();
			// wpvr_set_debug( $_wpvr_imported );
			
			update_option( 'wpvr_imported', $_wpvr_imported );
			$wpvr_imported = $_wpvr_imported;
			
			
			//$video_log_status = ( $videoItem['autoPublish'] == 'off' ) ? 'PENDING' : 'PUBLISHED';
			
			//UPDATE COUNTERS
			$videos_count = get_post_meta( $videoItem['sourceId'], 'wpvr_source_count_imported', true );
			if ( $videos_count == '' ) {
				$videos_count = 1;
			} else {
				$videos_count ++;
			}
			update_post_meta( $videoItem['sourceId'], 'wpvr_source_count_imported', $videos_count );
			
			// _d( $videoItem['postCats'] );
			
			$video_categories_ids = $videoItem['postCats'];
			$video_categories     = array();
			if ( $video_categories_ids != null && is_array( $video_categories_ids ) && count( $video_categories_ids ) != 0 ) {
				$video_categories = get_terms( array(
					'taxonomy' => 'category',
					'include'  => $videoItem['postCats'],
					'fields'   => 'names',
				) );
			}
			
			//d( $videoItem );
			
			wpvr_add_log_entry( array(
				'type'      => 'video',
				'action'    => ( isset( $videoItem['is_deferred'] ) && $videoItem['is_deferred'] === true ) ? 'defer_add' : 'add',
				'icon'      => $videoItem['thumb'],
				'owner'     => $videoItem['owner'],
				'async'     => $wpvr_options['enableAsync'] ? 1 : 0,
				'exec_time' => wpvr_chrono_time( $timer, 3 ),
				'data'      => apply_filters( 'wpvr_extend_log_entry_video_data', array(
					'video_id'            => $videoItem['id'],
					'video_title'         => $videoItem['title'],
					'video_service'       => $videoItem['service'],
					'post_id'             => $newPostId,
					'post_date'           => $video_post_date,
					'post_status'         => $video_status,
					'post_type'           => WPVR_VIDEO_TYPE,
					'post_author'         => $videoItem['postAuthor'],
					'post_thumbnail'      => $videoItem['downloadThumb'],
					'post_format'         => $videoItem['postFormat'],
					'post_categories_ids' => $video_categories_ids,
					'post_categories'     => $video_categories,
					'post_tags'           => $video_tags,
				), $videoItem ),
			) );
			
			
			$count_videos = 0;
			foreach ( (array) $wpvr_imported as $s => $service_videos ) {
				$count_videos += count( $service_videos );
			}
			
			//d( $videoItem );
			
			do_action( 'wpvr_event_add_video', $videoItem, $newPostId );
			do_action( 'wpvr_event_add_video_done', $count_videos );
			do_action( 'wpvr_event_run_dataFillers', $newPostId );
			
			//d( $videoItem );
			
			return $newPostId;
		}
	}
	
	/*Get Videos*/
	if ( ! function_exists( 'wpvr_get_videos' ) ) {
		function wpvr_get_videos( $args = array() ) {
			global $wpdb, $wpvr_options;
			$default_args = array(
				'ids'         => array(),
				'vids'        => array(),
				'meta_suffix' => false,
				'order'       => 'date', //date,  views , title
			);
			$args         = wpvr_extend( $args, $default_args );
			$ids_array    = "'" . implode( "','", $args['ids'] ) . "'";
			$vids_array   = "'" . implode( "','", $args['vids'] ) . "'";
			
			if ( $args['meta_suffix'] ) {
				$meta = "__";
			} else {
				$meta = "";
			}
			
			if ( $args['order'] == 'date' ) {
				$crit = "post_date";
			} elseif ( $args['order'] == 'views' ) {
				$crit = "post_date";
			} elseif ( $args['order'] == 'title' ) {
				$crit = "post_title";
			} else {
				echo "ERROR 'order' argument on wpvr_get_videos function !";
				
				return false;
			}
			
			$conds = array(
				'ids'  => '',
				'vids' => '',
			);
			
			if ( $args['ids'] != array() ) {
				$conds['ids'] = " AND P.ID IN (" . $ids_array . ") ";
			}
			if ( $args['vids'] != array() ) {
				$conds['vids'] = " AND " . $meta . "videoId IN (" . $vids_array . ") ";
			}
			
			
			$querystr
				= "
			SELECT 
				P.ID as ID, 
				P.ID as id, 
				P.post_author as post_author, 
				P.post_date as post_date, 
				P.post_date_gmt as post_date_gmt, 
				P.post_content as post_content, 
				P.post_title as post_title, 
				P.post_excerpt as post_excerpt, 
				P.post_status as post_status, 
				P.comment_status as comment_status, 
				P.ping_status as ping_status, 
				P.post_password as post_password, 
				P.post_name as post_name, 
				P.to_ping as to_ping, 
				P.pinged as pinged, 
				P.post_modified as post_modified, 
				P.post_modified_gmt as post_modified_gmt, 
				P.post_content_filtered as post_content_filtered, 
				P.post_parent as post_parent, 
				P.guid as guid, 
				P.menu_order as menu_order, 
				P.post_type as post_type, 
				P.post_mime_type as post_mime_type, 
				P.comment_count as comment_count, 
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_id' , M.meta_value , NULL ) SEPARATOR '') as " . $meta . "videoId,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_service' , M.meta_value , NULL ) SEPARATOR '') as " . $meta . "service,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_duration' , M.meta_value , NULL ) SEPARATOR '') as " . $meta . "duration,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_sourceName' , M.meta_value , NULL ) SEPARATOR '') as " . $meta . "sourceName,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_sourceId' , M.meta_value , NULL ) SEPARATOR '') as " . $meta . "sourceId,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_sourceType' , M.meta_value , NULL ) SEPARATOR '' ) as " . $meta . "sourceType,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_views' , M.meta_value , NULL ) SEPARATOR '' ) as " . $meta . "views,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_service_icon' , M.meta_value , NULL ) SEPARATOR '' ) as " . $meta . "youtubeIcon,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_service_thumb' , M.meta_value , NULL ) SEPARATOR '' ) as " . $meta . "youtubeThumb,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_service_url' , M.meta_value , NULL ) SEPARATOR '' ) as " . $meta . "youtubeUrl,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_service_views' , M.meta_value , NULL ) SEPARATOR '' ) as " . $meta . "youtubeViews,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_service_likes' , M.meta_value , NULL ) SEPARATOR '' ) as " . $meta . "youtubeDislikes,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_service_dislikes' , M.meta_value , NULL ) SEPARATOR '' ) as " . $meta . "youtubeLikes,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_enableManualAdding' , M.meta_value , NULL ) SEPARATOR '' ) as " . $meta . "enableManualAdding,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_getDesc' , M.meta_value , NULL ) SEPARATOR '' ) as " . $meta . "getDesc,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_getTitle' , M.meta_value , NULL ) SEPARATOR '' ) as " . $meta . "getTitle,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_getTags' , M.meta_value , NULL ) SEPARATOR '' ) as " . $meta . "getTags,
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_getThumb' , M.meta_value , NULL ) SEPARATOR '' ) as " . $meta . "getThumb,
				GROUP_CONCAT(DISTINCT if(WPTax.taxonomy = 'post_tag' , WPTerms.slug , NULL ) SEPARATOR ',' ) as slugTags,
				GROUP_CONCAT(DISTINCT if(WPTax.taxonomy = 'post_tag' , WPTerms.term_id , NULL ) SEPARATOR ',' ) as idTags,
				GROUP_CONCAT(DISTINCT if(WPTax.taxonomy = 'category' , WPTerms.slug , NULL ) SEPARATOR ',' ) as slugCats,
				GROUP_CONCAT(DISTINCT if(WPTax.taxonomy = 'category' , WPTerms.term_id , NULL ) SEPARATOR ',' ) as idCats,
				
				1 as end
			FROM 
				$wpdb->posts P 
				INNER JOIN $wpdb->postmeta M ON P.ID = M.post_id
				INNER JOIN $wpdb->term_relationships WPRelat on WPRelat.object_id = P.ID
				INNER JOIN $wpdb->term_taxonomy WPTax on WPTax.term_taxonomy_id = WPRelat.term_taxonomy_id
				INNER JOIN $wpdb->terms WPTerms on WPTerms.term_id = WPTax.term_id
			WHERE
				1
				AND P.post_type = '" . WPVR_VIDEO_TYPE . "'
				" . $conds['ids'] . "
			GROUP by
				P.ID
			HAVING
				1
				" . $conds['vids'] . "
			ORDER BY
				$crit DESC
		";
			//d( $querystr) ;
			$videos = $wpdb->get_results( $querystr, OBJECT );
			
			return $videos;
		}
	}
	
	/* UPDATE IMPORTED VIDEOS */
	if ( ! function_exists( 'wpvr_clear_imported_videos' ) ) {
		function wpvr_clear_imported_videos() {
			global $wpvr_vs;
			$wpvr_imported = array();
			foreach ( (array) $wpvr_vs as $vs_id => $vs ) {
				$wpvr_imported[ $vs_id ] = array();
			}
			update_option( 'wpvr_imported', $wpvr_imported );
		}
	}
	
	/* UPDATE IMPORTED VIDEOS */
	if ( ! function_exists( 'wpvr_update_imported_videos' ) ) {
		function wpvr_update_imported_videos() {
			global $wpdb, $wpvr_vs;
			if ( ! is_array( $wpvr_vs ) || count( $wpvr_vs ) == 0 ) {
				return get_option( 'wpvr_imported' );
			}
			
			$sql
				           = "
			select 
				P.ID as post_id, 
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_id' , M.meta_value , NULL ) SEPARATOR '') as video_id, 
				GROUP_CONCAT( DISTINCT if(M.meta_key = 'wpvr_video_service' , M.meta_value , NULL ) SEPARATOR '') as video_service
			FROM 
				$wpdb->posts P 
				INNER JOIN $wpdb->postmeta M ON P.ID = M.post_id
			WHERE 
				P.post_type = '" . WPVR_VIDEO_TYPE . "'
			GROUP BY 
				P.ID
			HAVING
			    video_id != ''
		";
			$videos        = $wpdb->get_results( $sql, OBJECT );
			$wpvr_imported = array();
			foreach ( (array) $wpvr_vs as $vs_id => $vs ) {
				$wpvr_imported[ $vs_id ] = array();
			}
			
			foreach ( (array) $videos as $video ) {
				if ( $video->video_service == '' ) {
					$video->video_service = 'youtube';
				}
				
				if ( $video->video_id != '' ) {
					$wpvr_imported[ $video->video_service ][ $video->video_id ] = $video->post_id;
				}
			}
			update_option( 'wpvr_imported', $wpvr_imported );
			
			//d( $wpvr_imported );
			return $wpvr_imported;
		}
	}
	
	/* GET POST ACTION LINKS */
	if ( ! function_exists( 'wpvr_get_post_links' ) ) {
		function wpvr_get_post_links( $post_id, $action ) {
			if ( ! $post_id || ! is_numeric( $post_id ) ) {
				return false;
			}
			if ( $action == 'untrash' ) {
				$a = 'untrash-post_';
				$b = 'untrash';
			} elseif ( $action == 'trash' ) {
				$a = 'trash-post_';
				$b = 'trash';
			} elseif ( $action == 'delete' ) {
				$a = 'delete-post_';
				$b = 'delete';
			} else {
				return false;
			}
			$_wpnonce = wp_create_nonce( $a . $post_id );
			
			return admin_url( 'post.php?post=' . $post_id . '&action=' . $b . '&_wpnonce=' . $_wpnonce );
		}
	}
	
	/* GENERATE VIDEO PLAYER EMBED CODE */
	if ( ! function_exists( 'wpvr_video_embed' ) ) {
		function wpvr_video_embed( $videoID, $post_id = '', $autoPlay = true, $service = 'youtube', $add_styles = false, $player_args = array(), $player_attributes = array() ) {
			global $wpvr_vs, $post;
			if ( $post_id == '' && isset( $post->ID ) ) {
				$post_id = $post->ID;
			}
			if ( $service == '' ) {
				$service = 'youtube';
			}
			// d( 'USING WPVR');
			if (
				! isset( $wpvr_vs[ $service ] )
				|| ! isset( $wpvr_vs[ $service ]['video_embed'] )
			) {
				//echo $service . " Service not enabled";
				return false;
			}
			
			return $wpvr_vs[ $service ]['video_embed'](
				$videoID,
				$post_id,
				$autoPlay,
				$add_styles,
				$player_args,
				$player_attributes
			);
		}
	}
	
	/* Get Videos Stats by Author*/
	if ( ! function_exists( 'wpvr_videos_stats_author' ) ) {
		function wpvr_videos_stats_author() {
			global $wpvr_options;
			global $wpdb;
			$qMeta
				= "
			SELECT 
				U.id as user_id,
				U.user_login as user_login,
				COUNT( distinct P.ID) as count
			FROM 
				$wpdb->users U
				LEFT JOIN $wpdb->posts P ON U.ID = P.post_author
			WHERE
				P.post_type = '" . WPVR_VIDEO_TYPE . "'
		";
			
			$rMeta = $wpdb->get_results( $qMeta, OBJECT );
			if ( ! isset( $rMeta[0] ) ) {
				return false;
			} else {
				$vStats = (array) $rMeta[0];
				
				return $vStats;
			}
		}
	}
	
	/* Get Videos Stats*/
	if ( ! function_exists( 'wpvr_videos_stats' ) ) {
		function wpvr_videos_stats() {
			global $wpdb;
			
			/* Getting by Cats */
			$qCat
				= "
			(
				select 
					WT.term_id as id,
					WT.slug as slug,
					WT.name as name,
					COUNT( DISTINCT P.ID ) as count
				FROM 
					$wpdb->posts P 
					LEFT JOIN $wpdb->term_relationships WTR on P.ID = WTR.object_id
					LEFT JOIN $wpdb->term_taxonomy WTT on WTR.term_taxonomy_id = WTT.term_taxonomy_id
					LEFT JOIN $wpdb->terms WT on WT.term_id = WTT.term_id
				WHERE 
					1
					and WTT.taxonomy= 'category'
					and P.post_type = '" . WPVR_VIDEO_TYPE . "'
					and P.post_status in ('trash','pending','publish','draft','invalid')				
				GROUP BY 
					WT.term_id
			)UNION(
				select 
					'nocat' as id,
					'NO CATS' as slug,
					'NO CATS' as name,
					COUNT( DISTINCT P.ID ) as count
				FROM 
					$wpdb->posts P 
				WHERE 
					1
					and P.post_type = '" . WPVR_VIDEO_TYPE . "'
					and P.post_status in ('trash','pending','publish','draft','invalid')				
				GROUP BY 
					1
			)
			
		";
			
			
			$sVideos = array(
				'byCat'    => array( 'total' => 0, 'items' => array() ),
				'byAuthor' => array( 'total' => 0, 'items' => array() ),
				'byStatus' => array( 'total' => 0, 'items' => array() ),
			);
			
			$sCat     = $wpdb->get_results( $qCat, OBJECT );
			$with_cat = $wk = 0;
			if ( count( $sCat ) == 0 ) {
				return false;
			}
			foreach ( (array) $sCat as $k => $cat ) {
				$sVideos['byCat']['items'][ $cat->name ] = $cat->count;
				if ( $cat->id != 'nocat' ) {
					$with_cat += $cat->count;
				} else {
					$wk = $k;
				}
				$sVideos['byCat']['total'] += $cat->count;
			}
			$sVideos['byCat']['items']['NO CATS'] = $sCat[ $wk ]->count - $with_cat;
			$sVideos['byCat']['total']            -= $with_cat;
			
			/*Get by Author*/
			$qAuthor
				     = "
			select 
				U.id as id,
				U.user_login as user_login,
				COUNT( DISTINCT P.ID ) as count
			FROM $wpdb->posts P 
				LEFT JOIN $wpdb->users U on U.ID = P.post_author
			WHERE 
				1
				and P.post_type = '" . WPVR_VIDEO_TYPE . "'
				and P.post_status in ('trash','pending','publish','draft','invalid')				
			GROUP BY 
				U.ID
				
		";
			$sAuthor = $wpdb->get_results( $qAuthor, OBJECT );
			foreach ( (array) $sAuthor as $k => $auth ) {
				$sVideos['byAuthor']['items'][ $auth->user_login ] = $auth->count;
				$sVideos['byAuthor']['total']                      += $auth->count;
			}
			/* Getting By Status */
			$qStatus
				= "
			SELECT 
				COUNT( distinct P.ID) as count,
				P.post_status as post_status
			FROM 
				$wpdb->posts P 
			WHERE
				1
				AND P.post_type = '" . WPVR_VIDEO_TYPE . "'
				and P.post_status in ('trash','pending','publish','draft','invalid')					
			GROUP BY P.post_status
				
		";
			
			$sStatus = $wpdb->get_results( $qStatus, OBJECT );
			foreach ( (array) $sStatus as $k => $item ) {
				$sVideos['byStatus']['items'][ $item->post_status ] = $item->count;
				$sVideos['byStatus']['total']                       += $item->count;
			}
			
			
			/* Getting By Service */
			$qService
				= "
			SELECT 
				COUNT( distinct P.ID) as total,
				COUNT( distinct if( 
					M.meta_key = 'wpvr_video_service' AND M.meta_value = 'vimeo' , P.ID , NULL 
				)) as vimeo,
				COUNT( distinct if( 
					M.meta_key = 'wpvr_video_service' AND M.meta_value = 'dailymotion' , P.ID , NULL 
				)) as dailymotion,
				COUNT( distinct if( 
					M.meta_key = 'wpvr_video_service' AND M.meta_value = 'youtube' , P.ID , NULL 
				)) as youtube,
				COUNT( distinct if( 
					M.meta_key = 'wpvr_video_service' AND (
						M.meta_value != 'youtube' AND M.meta_value != 'dailymotion' AND M.meta_value != 'vimeo'
					), P.ID , NULL 
				)) as unknown
				
			FROM 
				$wpdb->posts P 
				INNER JOIN $wpdb->postmeta M ON P.ID = M.post_id
			WHERE
				1
				AND P.post_type = '" . WPVR_VIDEO_TYPE . "'
				and P.post_status in ('trash','pending','publish','draft','invalid')
		";
			
			
			$sService = $wpdb->get_results( $qService, OBJECT );
			
			//new dBug( $sService );
			
			
			foreach ( (array) $sService as $k => $item ) {
				$sVideos['byService']['items']['youtube']     = $item->youtube;
				$sVideos['byService']['items']['vimeo']       = $item->vimeo;
				$sVideos['byService']['items']['dailymotion'] = $item->dailymotion;
				$sVideos['byService']['items']['unknown']     = $item->unknown;
				//$sVideos['byService']['items'][ 'total' ] = $item->total;
				//$sVideos['byStatus']['total'] += $item->count;
			}
			
			
			arsort( $sVideos['byAuthor']['items'] );
			arsort( $sVideos['byCat']['items'] );
			arsort( $sVideos['byStatus']['items'] );
			arsort( $sVideos['byService']['items'] );
			
			//new dBug($sVideos);
			return $sVideos;
			
		}
	}
	
	
	/*GET VIDEOS TO MANAGE THEM */
	if ( ! function_exists( 'wpvr_manage_videos' ) ) {
		function wpvr_manage_videos( $args = array(), $items = array() ) {
			global $wpdb, $wpvr_options;
			global $wpvr_vs_ids;
			
			if ( count( $wpvr_vs_ids ) != 0 ) {
				$wpvr_vs_ids_string          = " '" . implode( "', '", $wpvr_vs_ids['ids'] ) . "' ";
				$condition_active_services   = ' AND video_service IN ( ' . $wpvr_vs_ids_string . ' ) ';
				$condition_active_services_2 = ' HAVING service IN ( ' . $wpvr_vs_ids_string . ' ) ';
			} else {
				$condition_active_services   = '';
				$condition_active_services_2 = '';
				
			}
			
			//new dBug( $condition_active_services );
			
			if ( ! is_array( $args ) ) {
				echo "BAD ARGUMENT FOR wpvr_manage_videos";
				
				return false;
			}
			
			$default_args  = array(
				'perpage'  => '10',
				'page'     => '1',
				'search'   => '',
				'ids'      => array(),
				'status'   => array(),
				'service'  => array(),
				'author'   => array(),
				'date'     => array(),
				'category' => array(),
				'orderby'  => '',
				'order'    => 'desc',
				'dupsBy'   => '',
				'getCats'  => false,
				'nopaging' => false,
				//'getCoreFields' => false,
			);
			$args          = wpvr_extend( $args, $default_args );
			$fields_render = $limit_render = $conds_render = $joins_render = "";
			$fields        = $conds = $joins = array(
				'status'   => '', //
				'search'   => '', //
				'author'   => '', //
				'date'     => '', //
				'category' => '',
				'service'  => '', //
				'getCats'  => '', //
			);
			
			
			/* Get CATS */
			if ( $args['getCats'] === true ) {
				
				$joins['getCats'] = " LEFT JOIN $wpdb->term_relationships TR2 ON TR2.object_id = P.ID \n";
				$joins['getCats'] .= " LEFT JOIN $wpdb->term_taxonomy TT2 ON (TT2.taxonomy = 'category' AND TR2.term_taxonomy_id  = TT2.term_taxonomy_id) \n";
				$joins['getCats'] .= " LEFT JOIN $wpdb->terms T2 ON T2.term_id  = TT2.term_taxonomy_id \n";
				
				$fields['getCats'] .= " GROUP_CONCAT( DISTINCT T2.slug ORDER BY T2.slug ASC SEPARATOR ',') as cats_slugs, ";
				$fields['getCats'] .= " GROUP_CONCAT( DISTINCT T2.name ORDER BY T2.name ASC SEPARATOR ',') as cats_names, ";
			}
			
			/* APPLY ORDERS */
			if ( $args['orderby'] != '' ) {
				$order = $args['order'];
				
				if ( $args['orderby'] == "date" ) {
					$orderby = "P.post_date";
				} elseif ( $args['orderby'] == "title" ) {
					$orderby = "P.post_title";
				} elseif ( $args['orderby'] == "duration" ) {
					$orderby = "duration";
				} elseif ( $args['orderby'] == "views" ) {
					$orderby = "views";
				} elseif ( $args['orderby'] == "dupCount" ) {
					$orderby = "dupCount";
				}
				
				$order_render = " ORDER BY $orderby $order";
			} else {
				$order_render = " ORDER BY P.post_date DESC";
			}
			
			
			/* APPLY LIMIT */
			$actual_page = ( $args['page'] - 1 );
			$show_start  = $args['perpage'] * $actual_page;
			$length      = $args['perpage'];
			$show_end    = $show_start + $length;
			if ( $args['nopaging'] != true ) {
				$limit_render = " LIMIT $show_start,$length ";
			}
			
			/* Apply Search Filter */
			if ( $args['search'] != '' ) {
				$q               = $args['search'];
				$conds['search'] = " AND ( P.post_title LIKE '%" . $q . "%' OR P.post_title LIKE '%" . $q . "%' )";
			}
			
			
			/* Apply Date Filter */
			if ( count( $args['date'] ) != 0 ) {
				$months = $years = '';
				foreach ( (array) $args['date'] as $date ) {
					$x      = explode( '-', $date );
					$months .= "'" . $x[1] . "',";
					$years  .= "'" . $x[0] . "',";
				}
				$months        = substr( $months, 0, - 1 );
				$years         = substr( $years, 0, - 1 );
				$conds['date'] = " AND ( YEAR(P.post_date) IN ($years) AND MONTH(P.post_date) IN ($months) ) ";
			}
			
			/* Apply author Filter */
			if ( count( $args['author'] ) != 0 ) {
				$authors         = " '" . implode( "', '", $args['author'] ) . "' ";
				$conds['author'] = " AND ( P.post_author IN ($authors)  ) ";
			}
			
			/* Apply Status Filter */
			if ( count( $args['status'] ) != 0 ) {
				$statuses        = " '" . implode( "', '", $args['status'] ) . "' ";
				$conds['status'] = " AND ( P.post_status IN ($statuses)  ) ";
			}
			
			/* Apply Cat Filter */
			if ( count( $args['category'] ) != 0 ) {
				$category          = " '" . implode( "', '", $args['category'] ) . "' ";
				$joins['category'] = " INNER JOIN $wpdb->term_relationships  TR ON TR.object_id = P.ID ";
				$joins['category'] .= " INNER JOIN $wpdb->term_taxonomy TT ON TR.term_taxonomy_id  = TT.term_taxonomy_id ";
				$conds['category'] = " AND ( TT.taxonomy = 'category' AND TT.term_id IN ( $category )	) ";
			}
			
			/* Apply Service Filter */
			if ( count( $args['service'] ) != 0 ) {
				$services         = " '" . implode( "', '", $args['service'] ) . "' ";
				$joins['service'] = " INNER JOIN $wpdb->postmeta M_SERVICE ON P.ID = M_SERVICE.post_id	";
				$conds['service'] = " AND (M_SERVICE.meta_key = 'wpvr_video_service' AND M_SERVICE.meta_value IN ($services) ) ";
			}
			
			
			/* Rendering JOINS AND CONDS */
			foreach ( (array) $joins as $join ) {
				$joins_render .= $join;
			}
			
			foreach ( (array) $conds as $cond ) {
				$conds_render .= $cond;
			}
			
			foreach ( (array) $fields as $field ) {
				$fields_render .= $field;
			}
			
			
			/* Is It DupToolBox ? */
			/********  HANDLE RESULTS ********/
			if ( $args['dupsBy'] != '' ) {
				
				$dupsBy = $args['dupsBy'];
				
				$sql_all = wpvr_get_duplicate_videos( array(), false, false, true );
				//_d( $sql_all );
				
				$sql           = " $sql_all $limit_render	";
				$all           = $wpdb->get_results( $sql_all, OBJECT );
				$total_results = count( $all );
				$items         = $wpdb->get_results( $sql, OBJECT );
				$items_type    = "duplicates";
				$no_results_msg
				               = '
				<div class="wpvr_manage_noResults">
					<i class="fa fa-smile-o"></i><br />
					' . __( 'There are no duplicates.', WPVR_LANG ) . '
				</div>
			';
			} else {
				$sql_all
					= "
						SELECT
							count( distinct P.ID)
						FROM
							$wpdb->posts P
							INNER JOIN $wpdb->postmeta M ON P.ID = M.post_id
							$joins_render
						WHERE
							1
							AND P.post_type = '" . WPVR_VIDEO_TYPE . "'
							AND P.post_status IN( 'publish','trash' ,'draft' , 'invalid' , 'pending' )
							$conds_render
						$order_render
				";
				
				$sql
					= "
						SELECT
							P.ID as post_id,
							P.post_title as title,
							P.guid as guid,
							P.post_content as description,
							P.post_status as status,
							P.post_date as date,
							P.post_author as author,
							$fields_render
							GROUP_CONCAT(DISTINCT if(M.meta_key = 'wpvr_video_duration' , M.meta_value , NULL ) SEPARATOR '') as duration,
							GROUP_CONCAT(DISTINCT if(M.meta_key = 'wpvr_video_service' , M.meta_value , NULL ) SEPARATOR '') as service,
							GROUP_CONCAT(DISTINCT if(M.meta_key = 'wpvr_video_service_url' , M.meta_value , NULL ) SEPARATOR '') as service_url,
							GROUP_CONCAT(DISTINCT if(M.meta_key = 'wpvr_video_service_views' , M.meta_value , NULL ) SEPARATOR '') as service_views,
							GROUP_CONCAT(DISTINCT if(M.meta_key = 'wpvr_video_views' , M.meta_value , NULL ) SEPARATOR '') as views,
							GROUP_CONCAT(DISTINCT if(M.meta_key = 'wpvr_video_id' , M.meta_value , NULL ) SEPARATOR '') as id
						FROM
							$wpdb->posts P
							INNER JOIN $wpdb->postmeta M ON P.ID = M.post_id
							$joins_render
						WHERE
							1
							AND P.post_type = '" . WPVR_VIDEO_TYPE . "'
							AND P.post_status IN( 'publish','trash' ,'draft' , 'invalid' , 'pending' )
							$conds_render
						GROUP by P.ID
						$condition_active_services_2
						$order_render
						$limit_render
				";
				
				$total_results = $wpdb->get_var( $sql_all );
				$items         = $wpdb->get_results( $sql, OBJECT );
				$items_type    = "videos";
				$no_results_msg
				               = '
					<div class="wpvr_manage_noResults">
						<i class="fa fa-frown-o"></i><br />
						' . __( 'There is no result to show.', WPVR_LANG ) . '
					</div>
				';
			}
			
			//echo nl2br( $sql );new dBug( $args );
			//echo ( $total_results );
			
			$last_page = ceil( $total_results / $args['perpage'] );
			
			$return = array(
				'actual_page'    => $actual_page + 1,
				'last_page'      => $last_page,
				'total_results'  => $total_results,
				'show_start'     => $show_start + 1,
				'show_end'       => min( $show_end, $total_results ),
				'items'          => $items,
				'html'           => '',
				'sql_error'      => $wpdb->last_error,
				'sql'            => nl2br( $sql ),
				'no_results_msg' => $no_results_msg,
				'items_type'     => $items_type,
			);
			
			return $return;
		}
	}
	
	/* UNWANT VIDEOS */
	if ( ! function_exists( 'wpvr_unwant_videos' ) ) {
		function wpvr_unwant_videos( $post_ids ) {
			global $wpvr_unwanted, $wpvr_unwanted_ids;
			foreach ( (array) $post_ids as $post_id ) {
				$metas = get_post_meta( $post_id );
				$video = array(
					'id'      => $metas['wpvr_video_id'][0],
					'title'   => get_the_title( $post_id ),
					'thumb'   => $metas['wpvr_video_service_thumb'][0],
					'service' => $metas['wpvr_video_service'][0],
				);
				if ( ! isset( $wpvr_unwanted_ids[ $video['service'] ][ $video['id'] ] ) ) {
					$wpvr_unwanted[]                                        = $video;
					$wpvr_unwanted_ids[ $video['service'] ][ $video['id'] ] = 'unwanted';
				}
				
			}
			update_option( 'wpvr_unwanted', $wpvr_unwanted );
			update_option( 'wpvr_unwanted_ids', $wpvr_unwanted_ids );
			
			return true;
		}
	}
	
	/* UNDO UNWANT VIDEOS */
	if ( ! function_exists( 'wpvr_undo_unwant_videos' ) ) {
		function wpvr_undo_unwant_videos( $post_ids ) {
			global $wpvr_unwanted, $wpvr_unwanted_ids;
			foreach ( (array) $post_ids as $post_id ) {
				$metas    = get_post_meta( $post_id );
				$video_id = $metas['wpvr_video_id'][0];
				$service  = $metas['wpvr_video_service'][0];
				unset( $wpvr_unwanted_ids[ $service ][ $video_id ] );
				foreach ( (array) $wpvr_unwanted as $k => $unwanted ) {
					if ( $unwanted['id'] == $metas['wpvr_video_id'][0] ) {
						unset( $wpvr_unwanted[ $k ] );
					}
				}
				
			}
			update_option( 'wpvr_unwanted', $wpvr_unwanted );
			update_option( 'wpvr_unwanted_ids', $wpvr_unwanted_ids );
			
			return true;
		}
	}
	
	/* Convert a post to a videoItem */
	if ( ! function_exists( 'wpvr_convert_post_to_videoItem' ) ) {
		function wpvr_convert_post_to_videoItem( $post_id, $service = null ) {
			$post      = get_post( $post_id );
			$postmeta  = get_post_meta( $post_id );
			$thumbnail = get_the_post_thumbnail_url( $post_id, 'full' );
			//$thumb_meta = wp_get_attachment_metadata( get_post_thumbnail_id( $post_id ) , 'full' );
			//if( $thumb_meta != FALSE ) $thumb_file = WPVRWMT_UPLOAD_DIR . '/' . $thumb_meta[ 'file' ];
			//else $thumb_file = FALSE;
			
			$thumbs = wpvr_get_post_thumbnail_files( $post_id );
			if ( ! isset( $postmeta['wpvr_video_service_date'] ) ) {
				$service_date = '';
			} else {
				$service_date = $postmeta['wpvr_video_service_date'][0];
			}
			//_d( $thumbs );
			
			if ( $service != null && ! isset( $postmeta['wpvr_video_service'] ) ) {
				$video_service = $service;
			} else {
				$video_service = $postmeta['wpvr_video_service'][0];
			}
			$now = new Datetime( 'now' );
			
			$videoItem = array(
				'id'               => $postmeta['wpvr_video_id'][0],
				'viewIcon'         => '<img style="" width="150" height="115" src="' . $thumbnail . '">',
				'title'            => $post->post_title,
				'description'      => $post->post_content,
				'desc'             => $post->post_content,
				'thumb'            => $thumbnail,
				'hqthumb'          => $thumbnail,
				'service'          => $video_service,
				'icon'             => $thumbnail,
				'url'              => $postmeta['wpvr_video_service_url'][0],
				'originalPostDate' => $service_date,
				'localImportDate'  => $now->format( 'Y-m-d H:i:s' ),
				'likes'            => 0,
				'dislikes'         => 0,
				'views'            => 0,
				'duration'         => $postmeta['wpvr_video_duration'][0],
				'source_tags'      => array(),
				'tags'             => array(),
				'duplicate'        => false,
				'thumb_small'      => $thumbs['wpvr_wmt_thumb_small'],
				'thumb_big'        => $thumbs['wpvr_wmt_thumb_big'],
				'thumb_full'       => $thumbs['full'],
			);
			
			return $videoItem;
		}
	}
	
	/* REgenerate Thumbnails Files */
	if ( ! function_exists( 'wpvr_regenerate_thumbs' ) ) {
		function wpvr_regenerate_thumbs( $post_ids ) {
			$done = array();
			if ( ! is_array( $post_ids ) ) {
				$post_ids = array( $post_ids );
			}
			foreach ( (array) $post_ids as $post_id ) {
				$thumb_id     = get_post_thumbnail_id( $post_id );
				$fullsizepath = get_attached_file( $thumb_id );
				
				$images = wpvr_get_post_thumbnail_files( $post_id );
				
				//_d( $images );
				
				$done[ $thumb_id ] = array();
				if ( ! isset( $images['wpvr_wmt_thumb_small'] ) || $images['wpvr_wmt_thumb_small'] === false ) {
					$done[ $thumb_id ]['wpvr_wmt_thumb_small'] = wp_update_attachment_metadata(
						$thumb_id,
						wp_generate_attachment_metadata( $thumb_id, $fullsizepath )
					);
				}
				if ( ! isset( $images['wpvr_wmt_thumb_big'] ) || $images['wpvr_wmt_thumb_big'] === false ) {
					$done[ $thumb_id ]['wpvr_wmt_thumb_big'] = wp_update_attachment_metadata(
						$thumb_id,
						wp_generate_attachment_metadata( $thumb_id, $fullsizepath )
					);
				}
				
				return $done;
			}
		}
	}
	
	
	if ( ! function_exists( 'wpvr_async_add_videos_callback' ) ) {
		function wpvr_async_add_videos_callback( $response, $url, $request_info, $user_data, $time ) {
			
			$token    = $user_data['token'];
			$group_id = $user_data['group_id'];
			$json     = (array) wpvr_json_decode( $response );
			$tmp_done = 'wpvr_tmp_added_' . $token;
			$done     = get_option( $tmp_done );
			//async_add_debug
			//wpvr_debug_echo( $response );
			
			foreach ( (array) $json as $post_id ) {
				if ( $post_id === false ) {
					$done['count_error'] ++;
				} else {
					$done['count_done'] ++;
				}
			}
			$done['adding'][]         = $json;
			$done['raw'][ $group_id ] = array(
				'time'         => $time / 1000,
				'request_info' => $request_info,
				'response'     => $response,
				'json'         => $json,
				//'debug'        => get_option( 'async_debug' ) ,
			);
			update_option( $tmp_done, $done );
		}
	}
	
	if ( ! function_exists( 'wpvr_async_add_videos' ) ) {
		function wpvr_async_add_videos( $videos, $buffer ) {
			
			$taskers    = ( $buffer != 0 ) ? count( $videos ) / $buffer : 10;
			$RCX        = new RollingCurlX( $taskers );
			$token      = bin2hex( openssl_random_pseudo_bytes( 5 ) );
			$tmp_added  = 'wpvr_tmp_added_' . $token;
			$tmp_videos = 'wpvr_tmp_videos_' . $token;
			$timer      = wpvr_chrono_time();
			
			
			update_option( $tmp_added, array(
				'exec_time'   => 0,
				'count_done'  => 0,
				'count_error' => 0,
				'adding'      => array(),
				'raw'         => array(),
			) );
			
			$videos_balanced = wpvr_async_balance_items( $videos, $buffer );
			//d( $videos_balanced );
			
			foreach ( (array) $videos_balanced as $group_id => $video ) {
				$async_json_url = wpvr_capi_build_query( WPVR_ACTIONS_URL, array(
					'wpvr_wpload'      => 1,
					'add_group_videos' => 1,
					'group_id'         => $group_id,
					'token'            => $token,
				) );
				//d( $async_json_url );
				//d( $group_id );
				$RCX->addRequest(
					$async_json_url,
					null,
					'wpvr_async_add_videos_callback',
					array(
						'token'    => $token,
						'group_id' => $group_id,
					),
					array(
						CURLOPT_FOLLOWLOCATION => false,
					)
				);
			}
			
			update_option( $tmp_videos, $videos_balanced );
			
			$RCX->execute();
			$done              = get_option( $tmp_added );
			$done['exec_time'] = wpvr_chrono_time( $timer );
			
			delete_option( $tmp_added );
			delete_option( $tmp_videos );
			
			//d( $done );
			return ( $done );
			
		}
	}
	
	if ( ! function_exists( 'wpvr_add_videos' ) ) {
		function wpvr_add_videos( $videos ) {
			global $wpvr_imported;
			
			$done = array();
			$i    = 0;
			foreach ( (array) $videos as $id => $video ) {
				$i ++;
				//wpvr_set_debug( $wpvr_imported , true );
				$done[ $id ] = wpvr_add_video( $video, $wpvr_imported, false );
				//d( $wpvr_imported );
			}
			
			//d( $done );
			
			return $done;
		}
	}
	
	
	function wpvr_render_wizzard_form() {
		ob_start();
		global $wpvr_vs, $wpvr_video_import_choices;
		$wpvr_video_import_choices = apply_filters( 'wpvr_extend_manual_video_adding_choices', $wpvr_video_import_choices );
		
		?>
        <style>

        </style>
        <div class="wpvr_wizzard_form step_1">

            <input type="hidden" id="wpvr_wizzard_service" value=""/>
            <input type="hidden" id="wpvr_wizzard_pid" value=""/>

            <div class="wpvr_wizzard_nav">

                <button class="wpvr_button disabled wpvr_wizzard_run pull-right">
                    <i class="fa fa-bolt"></i> Import Video

                </button>

                <button class="wpvr_button disabled wpvr_wizzard_next_step pull-right">
                    Next Step <i class="fa fa-chevron-right"></i>
                </button>
                <button class="wpvr_button wpvr_wizzard_prev_step pull-left">
                    <i class="fa fa-chevron-left"></i> Back
                </button>
                <div class="wpvr_clearfix"></div>
            </div>

            <div class="wpvr_wizzard_form_step form_step_1">
                <h3>1. <?php echo __( 'Pick a video service', WPVR_LANG ); ?></h3>
                <div class="wpvr_wizzard_form_step_content">
					<?php foreach ( (array) $wpvr_vs as $vs ) { ?>
                        <div class="wpvr_wizzard_service" service="<?php echo $vs['id']; ?>"
                             pid="<?php echo $vs['pid']; ?>">
                            <div class="wpvr_item_cover">
                                <span class="wpvr_item_check"><i class="fa fa-check"></i></span>
                            </div>
                            <img src="<?php echo WPVR_URL . 'assets/images/services/' . $vs['id'] . '.png'; ?>"
                                 alt="<?php echo $vs['label']; ?>"/>
							<?php //echo $vs[ 'label' ]; ?>
                        </div>
					<?php } ?>
                    <div class="wpvr_clearfix"></div>
                </div>
            </div>


            <div class="wpvr_wizzard_form_step form_step_2">
                <h3>2. <?php echo __( 'Enter your video URL or video ID', WPVR_LANG ); ?></h3>
                <div class="wpvr_wizzard_form_step_content">
                    <input
                            type="text"
                            class="wpvr_wizzard_form_param"
                            id="wpvr_wizzard_param"
                            placeholder="<?php echo __( 'Video URL or ID ...', WPVR_LANG ); ?>"
                            value=""
                    />
                </div>
            </div>
			<?php //d( $wpvr_video_import_choices ); ?>
            <div class="wpvr_wizzard_form_step form_step_3">
                <h3>3. <?php echo __( 'Select the video data you want to import', WPVR_LANG ); ?></h3>
                <div class="wpvr_wizzard_form_step_content">
					<?php foreach ( (array) $wpvr_video_import_choices as $choice_id => $choice ) { ?>
                        <div class="wpvr_wizzard_choice inactive" choice_id="<?php echo $choice_id; ?>">

                            <input
                                    class="wpvr_wizzard_choice_value"
                                    target_id="<?php echo $choice['target']; ?>"
                                    type="hidden"
                                    value="off"
                            />

                            <div class="wpvr_wizzard_choice_icon pull-left">
                                <i class="fa fa-check-circle on"></i>
                                <i class="fa fa-ban off"></i>
                            </div>

                            <div class="wpvr_wizzard_choice_content">
								<span class="wpvr_wizzard_choice_title">
									<?php echo $choice['label']; ?>
								</span><br/>
                                <span class="wpvr_wizzard_choice_desc">
									<?php echo $choice['desc']; ?>
								</span>
                            </div>
                            <div class="wpvr_clearfix"></div>
                        </div>
					<?php } ?>
                    <div class="wpvr_clearfix"></div>
                </div>
            </div>

        </div>
		
		
		<?php
		$form = ob_get_contents();
		ob_get_clean();
		
		return $form;
		
		
	}
	
	function wpvr_get_video_information( $post_id ) {
		global $wpvr_unwanted_ids, $wpvr_status, $wpvr_vs;
		
		
		if (
			isset( $_SESSION['video_admin_tmp'] )
			&& isset( $_SESSION['video_admin_tmp']['post_id'] )
			&& $_SESSION['video_admin_tmp']['post_id'] == $post_id
		) {
			return $_SESSION['video_admin_tmp'];
		}
		
		// wpvr_o( 'Getting NEw Video Info ...' );
		
		$post_types = wpvr_get_available_post_types();
		$meta       = get_post_meta( $post_id );
		$comments   = wp_count_comments( $post_id );
		$video_cats = wp_get_post_categories( $post_id );
		
		$import_date = get_post_meta( $post_id, 'wpvr_video_importDate', true );
		//d( $import_date );
		if ( $import_date == '' ) {
			$import_date_zoned = '';
		} else {
			$import_date_zoned = wpvr_get_zoned_formatted_time( $import_date ) . ' <br/> (' . wpvr_get_timezone_name( wpvr_get_timezone() ) . ')';
			$import_date       = wpvr_datetime_human_diff( $import_date );
		}
		
		//wpvr_ooo( $import_date_zoned );
		
		// $post_date = get_the_date('Y-m-d H:i:s' , $post_id );
		// $post_date_zoned = wpvr_get_time( get_the_date( 'Y-m-d H:i:s', $post_id ), false, true, true, true );
		//d( $post_date_zoned );
		$video_info              = array(
			'post_id'         => $post_id,
			'author_name'     => get_the_author(),
			'post_date'       => wpvr_human_time_diff( $post_id ),
			'post_date_zoned' => wpvr_get_zoned_formatted_time( get_the_date( 'Y-m-d H:i:s', $post_id ) ) .
			                     ' <br/> (' . wpvr_get_timezone_name( wpvr_get_timezone() ) . ')',
			
			'import_date'       => $import_date,
			'import_date_zoned' => $import_date_zoned,
			
			'post_cats'        => array(),
			'post_status'      => get_post_status( $post_id ),
			'video_id'         => isset( $meta['wpvr_video_id'][0] ) ? $meta['wpvr_video_id'][0] : '',
			'service'          => isset( $meta['wpvr_video_service'][0] ) ? $meta['wpvr_video_service'][0] : '',
			'post_type'        => get_post_type( $post_id ),
			'post_type_label'  => $post_types[ get_post_type( $post_id ) ],
			'duration'         => wpvr_get_duration_string(
				isset( $meta['wpvr_video_duration'][0] ) ? $meta['wpvr_video_duration'][0] : ''
			),
			'views'            => isset( $meta['wpvr_video_views'][0] ) ? $meta['wpvr_video_views'][0] : 0,
			'source_name'      => isset( $meta['wpvr_video_sourceName'][0] ) ? $meta['wpvr_video_sourceName'][0] : '',
			'disableAutoembed' => isset( $meta['wpvr_video_disableAutoEmbed'][0] ) ? $meta['wpvr_video_disableAutoEmbed'][0] : 'off',
			'edit_link'        => get_edit_post_link( $post_id ),
			'view_link'        => get_the_permalink( $post_id ),
			'thumb_url'        => wpvr_get_video_thumbnail( $post_id, 'wpvr_hard_thumb' ),
			'comment_count'    => $comments->total_comments,
		);
		$video_info['views']     = $video_info['views'] == '' ? 0 : $video_info['views'];
		$video_info['thumb_url'] = $video_info['thumb_url'] === false ? WPVR_NO_THUMB : $video_info['thumb_url'];
		
		$video_info['is_unwanted'] = isset( $wpvr_unwanted_ids[ $video_info['service'] ][ $video_info['video_id'] ] ) ? true : false;
		
		if ( count( $video_cats ) != 0 && $video_cats != false ) {
			foreach ( (array) $video_cats as $c ) {
				$cat                       = get_category( $c );
				$video_info['post_cats'][] = "<strong>" . $cat->slug . "</strong>";
			}
		}
		
		$_SESSION['video_admin_tmp'] = $video_info;
		
		return $video_info;
	}
	
	function wpvr_bulk_update_thumbs( $post_ids ) {
		$count = array(
			'done'   => 0,
			'errors' => 0,
		);
		foreach ( (array) $post_ids as $post_id ) {
			$metas = get_post_meta( $post_id );
			if ( $metas['wpvr_video_id'][0] == 'youtube' ) {
				
				$thumbs = wpvr_youtube_get_best_thumbnails( $metas['wpvr_video_id'][0] );
				$done   = wpvr_download_featured_image(
					$thumbs['hqthumb'],
					$thumbs['thumb'],
					get_the_title( $post_id ),
					$metas['wpvr_video_service_desc'][0],
					$post_id
				);
				
			} else {
				$done = wpvr_download_featured_image(
					$metas['wpvr_video_service_hqthumb'][0],
					$metas['wpvr_video_service_thumb'][0],
					get_the_title( $post_id ),
					$metas['wpvr_video_service_desc'][0],
					$post_id
				);
			}
			
			if ( $done === false ) {
				$count['errors'] ++;
			} else {
				$count['done'] ++;
			}
			
		}
		
		return $count;
	}
	
	function wpvr_add_video_to_unwanted( $video, $origin, $owner ) {
		$video['origin'] = $origin;
		$video['owner']  = $owner;
		
		global $wpvr_unwanted, $wpvr_unwanted_ids;
		
		if ( ! isset( $wpvr_unwanted_ids[ $video['service'] ][ $video['id'] ] ) ) {
			$wpvr_unwanted[] = $video;
			
			$wpvr_unwanted_ids[ $video['service'] ][ $video['id'] ] = 'unwanted';
		}
		
		
		update_option( 'wpvr_unwanted', $wpvr_unwanted );
		update_option( 'wpvr_unwanted_ids', $wpvr_unwanted_ids );
	}