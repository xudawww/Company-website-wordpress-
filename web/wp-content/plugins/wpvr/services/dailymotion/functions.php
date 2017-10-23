<?php
	require_once( 'functions.api.php' );
	
	/* Inject Service Styles */
	$vs['get_styles'] = function () use ( $vs, $pid_suffix ) {
		$vs_id    = $vs['id'];
		$vs_color = $vs['color'];
		$styles
		          = "
			.wpvr_service_icon.$vs_id{ background-color:$vs_color;}\n
			.wpvr_video_author.$vs_id{ background-color:$vs_color;}\n
            .wpvr_source_icon_right.$vs_id{ background-color:$vs_color;}\n
            .wpvrArgs[service=$vs_id] , .wpvr_source_icon[service=$vs_id]{ border-color:$vs_color;}\n
            
		";
		
		return $styles;
	};
	
	/* Embed Video */
	$vs['video_embed'] = function ( $videoID, $post_id = '', $autoPlay = true, $add_styles = false, $player_args = array(), $player_attributes = array() ) use ( $vs, $pid_suffix ) {
		global $wpvr_options, $wpvr_dynamics;
		
		$player_width  = '100%';
		$player_height = '459';
		$player_styles = '';
		
		if ( $add_styles === true ) {
			$player_styles = ' position:absolute !important;top:0 !important;left:0 !important;width:100% !important;height:100% !important; ';
		}
		
		
		if ( $wpvr_dynamics['player_tags']['force_autoplay_disable'] === true ) {
			$autoPlay = false;
		}
		
		$player_classes = implode( ' ', $wpvr_dynamics['player_classes'] );
		
		$player_base_args = array(
			'api'      => '1',
			'logo'     => '0',
			'title'    => '0',
			'related'  => '0',
			'autoplay' => ( $autoPlay === true ? 1 : 0 ),
		);
		
		$player_args = wpvr_extend( $player_args, array(
			'rel'            => 0,
			'enablejsapi'    => 1,
			'showinfo'       => 0,
			'cc_load_policy' => 0,
			'modestbranding' => 1,
			'iv_load_policy' => 3,
			'wmode'          => 'transparent',
			'version'        => 3,
			'autohide'       => 1,
			'controls'       => $wpvr_options['enableVideoControls'] === true ? 1 : 0,
			'autoplay'       => $autoPlay === true ? 1 : 0,
		) );
		
		$player_src = '//www.dailymotion.com/embed/video/' . $videoID . '?' . http_build_query( $player_args, '&amp;' );
		
		$player_attributes = wpvr_extend( $player_attributes, array(
			'video_id'              => $videoID,
			'style'                 => $player_styles,
			'class'                 => ' wpvr_iframe dailymotion ' . $player_classes,
			'id'                    => 'wpvr_iframe_' . $videoID,
			'width'                 => $player_width,
			'height'                => $player_height,
			'src'                   => $player_src,
			'frameborder'           => "0",
			'webkitallowfullscreen' => "",
			'mozallowfullscreen'    => "",
			'allowfullscreen'       => "",
		) );
		
		$player = '<iframe ' . wpvr_render_html_attributes( $player_attributes ) . ' ></iframe>';
		
		return $player;
	};
	
	/* GET DATA */
	$vs['get_trends_data'] = function ( $param = null ) use ( $vs, $pid_suffix ) {
		return 'TRENDS SUBHEADER';
	};
	
	/* GET YOUTUBE CHANNEL DATA */
	$vs['get_channel_data'] = function ( $param = null ) use ( $vs, $pid_suffix ) {
		
		$api_handle = $vs['api_auth']();
		if ( $api_handle === false ) {
			return false;
		}
		
		$api_endpoint = '/user/' . $param;
		$api_args     = array( 'fields' => 'avatar_720_url,avatar_80_url,username,description', );
		$api_response = wpvr_object_to_array( $api_handle->get( $api_endpoint, $api_args ) );
		
		return array(
			'name'        => $api_response['username'],
			'thumb'       => $api_response['avatar_80_url'],
			'thumbHQ'     => $api_response['avatar_720_url'],
			'description' => $api_response['description'],
		);
	};
	
	/* GET YOUTUBE PLAYLIST DATA */
	$vs['get_playlist_data'] = function ( $param = null ) use ( $vs, $pid_suffix ) {
		
		$api_handle = $vs['api_auth']();
		if ( $api_handle === false ) {
			return false;
		}
		
		$api_endpoint = '/playlist/' . $param;
		$api_args     = array( 'fields' => 'name,thumbnail_720_url,thumbnail_120_url', );
		$api_response = wpvr_object_to_array( $api_handle->get( $api_endpoint, $api_args ) );
		
		return array(
			'name'    => $api_response['name'],
			'thumb'   => $api_response['thumbnail_120_url'],
			'thumbHQ' => $api_response['thumbnail_720_url'],
		);
	};
	
	
	/* Render Subheader */
	$vs['render_subheader'] = function ( $source = null ) use ( $vs, $pid_suffix ) {
		$source_type = $source->type;
		$vs_type     = $vs['types'][ $source_type ];
		if ( $vs_type['subheader'] === false ) {
			return '';
		}
		if ( $vs_type['subdata_function'] === false ) {
			return '';
		}
		
		$sub_data = $vs[ $vs_type['subdata_function'] ]( $source->{$vs_type['param']} );
		if ( $sub_data === false ) {
			return '';
		}
		
		$output = '';
		
		if ( $vs_type['global_id'] == 'trends' ) {
			if ( $source->{$vs_type['param']} == '' ) {
				$worldwide       = '<i class="wpvr_worldwide fa fa-globe"></i>';
				$subheader_title = __( 'Trends Worldwide', WPVR_LANG );
			} else {
				$worldwide       = '';
				$subheader_title = __( 'Trends in', WPVR_LANG ) . ' ' . wpvr_get_country_name( $source->{$vs_type['param']} );
			}
			
			$output
				= '
				<div class="wpvr_subsource">
					<div class="wpvr_subsource_thumb wpvr_flags f32 ' . $vs_type['global_id'] . '">
						<span class="flag ' . strtolower( $source->{$vs_type['param']} ) . ' "></span>
						' . $worldwide . '
					</div>
					<div class="wpvr_subsource_name ' . $vs_type['global_id'] . '">
						' . $subheader_title . '
					</div>
					<div class="wpvr_clearfix"></div>
				</div>
			';
		} elseif ( $sub_data != false ) {
			$output
				= '
				<div class="wpvr_subsource">
					<div class="wpvr_subsource_thumb ' . $vs_type['global_id'] . '">
						<img src="' . $sub_data['thumb'] . '" alt="' . $sub_data['name'] . '" />
					</div>
					<div class="wpvr_subsource_name ' . $vs_type['global_id'] . '">
						' . $sub_data['name'] . '
					</div>
					<div class="wpvr_clearfix"></div>
				</div>
			';
		}
		
		return $output;
	};
	
	/* Get Video Tags */
	$vs['get_video_tags'] = function ( $videoId ) use ( $vs, $pid_suffix ) {
		return array();
	};
	
	/* GEt Video Stats */
	$vs['get_video_stats'] = function ( $videosFound, $options ) use ( $vs, $pid_suffix ) {
		return $videosFound;
	};
	
	/* Get Single Video Data */
	$vs['get_single_video_data'] = function ( $video_id ) use ( $vs, $pid_suffix ) {
		
		$api_handle = $vs['api_auth']();
		if ( $api_handle === false ) {
			wpvr_add_notice( array(
				'title'     => 'WP Video Robot ERROR :',
				'class'     => 'error', //updated or warning or error
				'content'   => $vs['msgs']['authentication_error'],
				'hidable'   => false,
				'is_dialog' => false,
				'show_once' => true,
			) );
			
			return false;
		}
		
		$api_endpoint = '/video/' . $video_id . '';
		$api_args     = array(
			'fields' => 'created_time,description,tags,thumbnail_120_url,thumbnail_720_url,title,url,views_total,duration,owner,owner.screenname,owner.url,owner.avatar_480_url',
		);
		$api_response = wpvr_object_to_array( $api_handle->get( $api_endpoint, $api_args ) );
		
		
		// No Items Found
		if ( $api_response == null ) {
			wpvr_add_notice( array(
				'title'     => 'WP Video Robot ERROR :',
				'class'     => 'error', //updated or warning or error
				'content'   => $vs['msgs']['video_not_found'],
				'hidable'   => false,
				'is_dialog' => false,
				'show_once' => true,
			) );
			
			return false;
		}
		
		if ( is_object( $api_response ) ) {
			$api_response = (array) $api_response;
		}
		$nDate            = $nDate = DateTime::createFromFormat( 'U', $api_response['created_time'] );
		$originalPostDate = $nDate->format( 'Y-m-d H:i:s' );
		
		$metas = array(
			'id'               => $video_id,
			'service'          => 'dailymotion',
			'url'              => $api_response['url'],
			'desc'             => $api_response['description'],
			'title'            => $api_response['title'],
			'duration'         => 'PT' . $api_response['duration'] . 'S',
			'views'            => $api_response['views_total'],
			'thumb'            => $api_response['thumbnail_720_url'],
			'hqthumb'          => $api_response['thumbnail_720_url'],
			'icon'             => $api_response['thumbnail_120_url'],
			'likes'            => 0,
			'dislikes'         => 0,
			'originalPostDate' => $originalPostDate,
			'tags'             => $api_response['tags'],
		);
		
		$metas['author'] = array(
			'id'        => $api_response['owner'],
			'title'     => $api_response['owner.screenname'],
			'title_cut' => $api_response['owner.screenname'],
			'thumbnail' => $api_response['owner.avatar_480_url'],
			'link'      => $api_response['owner.url'],
		);
		
		return $metas;
	};
	
	
	/* Fetch Videos */
	$vs_dm                 = $vs;
	$vs_dm['fetch_videos'] = function ( $videosFound, $options, $oldVideos ) use ( &$vs_dm, $pid_suffix ) {
		global $preDuplicates;
		global $default_videosFound, $default_fetching_options;
		
		//$default_videosFound[ 'nextPageToken' ] = '1';
		
		//Default variables
		$default_fetching_options = wpvr_prepare_sOptions_fields( $default_fetching_options, null, $default = true );
		$videosFound              = wpvr_extend( $videosFound, $default_videosFound );
		$options                  = wpvr_extend( $options, $default_fetching_options );
		
		
		if ( $videosFound['nextPageToken'] == '' ) {
			$videosFound['nextPageToken'] = '1';
		}
		
		
		$api_handle = $vs_dm['api_auth']();
		if ( $api_handle === false ) {
			return $videosFound;
		}
		
		
		if ( $options['how']['onlyNewVideos'] == 'on' ) {
			$options['how']['onlyNewVideos'] = true;
		} else {
			$options['how']['onlyNewVideos'] = false;
		}
		
		
		if ( $videosFound['execTime'] == '' ) {
			$videosFound['execTime'] = microtime( true );
		}
		
		$vs_type = $vs_dm['types'][ $options['what']['mode'] ];
		
		$api_endpoint = '/';
		$api_args     = array(
			'page'   => $videosFound['nextPageToken'],
			'limit'  => '100',
			'sort'   => 'visited',
			'fields' => implode( ',', array(
				'id',
				'created_time',
				'title',
				'url',
				'views_total',
				'description',
				'duration',
				'thumbnail_180_url',
				'thumbnail_720_url',
				'sprite_320x_url',
				'tags',
				'owner',
				'owner.screenname',
				'owner.url',
				'owner.avatar_480_url',
			) ),
		
		);
		
		
		if ( $options['what']['order'] == 'title' ) {
			$order = "recent";
		} elseif ( $options['what']['order'] == 'viewCount' ) {
			$order = "visited";
		} elseif ( $options['what']['order'] == 'date' ) {
			$order = "recent";
		} elseif ( $options['what']['order'] == 'relevance' ) {
			$order = "relevance";
		} else {
			$order = 'recent';
		}
		
		if ( $options['what']['mode'] == 'search' . $pid_suffix ) {
			
			/* Search */
			$api_endpoint       = '/videos';
			$api_args['search'] = ( $options['what'][ $vs_type['param'] ] != '' ) ? $options['what'][ $vs_type['param'] ] : ' ';
			$api_args['sort']   = $order;
			
			
		} elseif ( $options['what']['mode'] == 'trends' . $pid_suffix ) {
			
			/* Trends */
			$api_endpoint     = '/videos';
			$api_args['sort'] = 'trending';
			if ( $options['what'][ $vs_type['param'] ] == '' ) {
				$options['what'][ $vs_type['param'] ] = 'US';
			}
			$api_args['country'] = $options['what'][ $vs_type['param'] ];
			
			
		} elseif ( $options['what']['mode'] == 'playlist' . $pid_suffix ) {
			
			/* Playlist */
			if ( $order == "relevance" ) {
				$order = 'recent';
			}
			$api_endpoint = '/playlist/' . $options['what'][ $vs_type['param'] ] . '/videos';
			//$api_endpoint = '1';
			
		} elseif ( $options['what']['mode'] == 'channel' . $pid_suffix ) {
			
			/* Channel*/
			if ( $order == "relevance" ) {
				$order = 'recent';
			}
			$api_endpoint     = '/user/' . $options['what'][ $vs_type['param'] ] . '/videos';
			$api_args['sort'] = $order;
			
		} elseif ( $options['what']['mode'] == 'videos' . $pid_suffix ) {
			
			/* Videos */
			if ( $order == "relevance" ) {
				$order = 'recent';
			}
			$api_endpoint     = '/videos';
			$api_args['ids']  = $options['what'][ $vs_type['param'] ];
			$api_args['sort'] = 'recent';
			
		} else {
		}
		
		
		//d( $api_args);return $videosFound;
		
		/* Filtering by videoQuality */
		if ( $options['what']['videoQuality'] == 'high' ) {
			$api_args['flags'] = 'hd';
		}
		
		/* Filtering by duration */
		if ( $options['what']['videoDuration'] == 'short' ) {
			$api_args['shorter_than'] = '4';
		} elseif ( $options['what']['videoDuration'] == 'medium' ) {
			$api_args['shorter_than'] = '20';
			$api_args['longer_than']  = '4';
		} elseif ( $options['what']['videoDuration'] == 'long' ) {
			$api_args['longer_than'] = '20';
		}
		
		/* Filtering by date */
		if ( $options['what']['publishedBefore'] != '' ) {
			$before                     = DateTime::createFromFormat( 'm/d/Y', $options['what']['publishedBefore'] );
			$api_args['created_before'] = $before->format( 'U' );
		}
		if ( $options['what']['publishedAfter'] != '' ) {
			$after                     = DateTime::createFromFormat( 'm/d/Y', $options['what']['publishedAfter'] );
			$api_args['created_after'] = $after->format( 'U' );
		}
		
		if ( ! isset( $videosFound['recalls'] ) ) {
			$videosFound['recalls'] = 0;
		}
		$api_response = wpvr_object_to_array( $api_handle->get( $api_endpoint, $api_args ) );
		
		
		if ( WPVR_API_RESPONSE_DEBUG ) {
			d( $api_response );
		}
		
		//d( $api_response ); return $videosFound ;
		
		if ( ! isset( $api_response['list'] ) ) {
			wpvr_render_error_notice( $vs_dm['msgs']['api_error'] );
			
			return $videosFound;
		}
		
		if ( ! isset( $api_response['body']['paging']['next'] ) || $api_response['body']['paging']['next'] == null ) {
			$videosFound['nextPageToken'] = "end";
		} else {
			$videosFound['nextPageToken'] = $videosFound['nextPageToken'] + 1;
		}
		
		if ( isset( $api_response['total'] ) ) {
			$videosFound['totalResults'] = $api_response['total'];
		} else {
			$videosFound['totalResults'] = '500000';
		}
		$videosIds                = "";
		$videosFound['videosIds'] = "";
		
		
		$response_items           = $api_response['list'];
		$videosIds                = "";
		$videosFound['videosIds'] = "";
		
		foreach ( (array) $response_items as $item ) {
			$videosFound['absCount'] ++;
			
			//new dBug($item);
			$videoId = $item['id'];
			
			if ( $videosFound['absCount'] > $videosFound['totalResults'] || $videosFound['real_count'] >= $options['how']['wantedResults'] ) {
				//Getting Stats before ending
				$videosFound['execTime'] = round( microtime( true ) - $videosFound['execTime'], 2 );
				break;
			}
			if ( array_key_exists( $videoId, $oldVideos ) ) {
				if ( isset( $oldVideos[ $videoId ] ) && $oldVideos[ $videoId ] == 'unwanted' ) {
					$videosFound['unwantedCount'] ++;
				} else {
					$videosFound['dupCount'] ++;
				}
			}
			
			if ( ! $options['how']['onlyNewVideos'] || ! ( array_key_exists( $videoId, $oldVideos ) ) ) {
				
				if ( ! $options['how']['onlyNewVideos'] && array_key_exists( $videoId, $oldVideos ) ) {
					$isDuplicate = true;
					
				} else {
					$isDuplicate = false;
				}
				
				if ( ! ( array_key_exists( $videoId, $preDuplicates ) ) ) {
					$preDuplicates[ $videoId ] = 1;
					
					$videosIds                .= $videoId . ",";
					$videosFound['videosIds'] .= $videoId . ",";
					
					
					if (
						$options['how']['getVideoTags'] == 'off'
						|| $isDuplicate
						|| ! isset( $item['tags'] )
					) {
						$video_tags = array();
					} else {
						$video_tags = $item['tags'];
					}
					
					$nDate            = DateTime::createFromFormat( 'U', $item['created_time'] );
					$originalPostDate = $nDate->format( 'Y-m-d H:i:s' );
					//d( $item );
					$videoItem = array(
						'id'               => $videoId,
						'viewIcon'         => '<img style="" width="150" height="115" src="' . $item['thumbnail_180_url'] . '">',
						'title'            => $item['title'],
						'description'      => $item['description'],
						'hqthumb'          => $item['thumbnail_720_url'],
						'thumb'            => $item['thumbnail_720_url'],
						'service'          => 'dailymotion',
						'icon'             => $item['thumbnail_180_url'],
						'url'              => $item['url'],
						'originalPostDate' => $originalPostDate,
						'likes'            => 0,
						'dislikes'         => 0,
						'views'            => $item['views_total'],
						//'local_views' => $item['stats']['plays'],
						'duration'         => 'PT' . $item['duration'] . 'S',
						'source_tags'      => $options['how']['postTags'],
						'tags'             => $video_tags,
						'duplicate'        => $isDuplicate,
						'postDate'         => $options['how']['postDate'],
						'postCats'         => $options['how']['postCats'],
						'postAuthor'       => $options['how']['postAuthor'],
						'autoPublish'      => $options['how']['autoPublish'],
						'postStatus'      => $options['how']['postStatus'],
						'sourceName'       => $options['how']['sourceName'],
						'sourceId'         => $options['how']['sourceId'],
						'sourceType'       => $options['how']['sourceType'],
						'postAppend'       => $options['how']['postAppend'],
						'postContent'      => $options['how']['postContent'],
						'appendCustomText' => $options['how']['appendCustomText'],
						'appendSourceName' => $options['how']['appendSourceName'],
						'source'           => $videosFound['source'],
					);
					
					
					//d( $item );
					
					$videoItem = apply_filters(
						'wpvr_extend_found_item_author_data',
						$videoItem,
						$item['owner.screenname'],
						$item['owner'],
						$item['owner.avatar_480_url'],
						$item['owner.url']
					);
					
					$videoItem = apply_filters(
						'wpvr_extend_found_item',
						$videoItem,
						$item
					);
					//d( $videoItem );
					$videosFound['items'][ $videoId ] = $videoItem;
					$oldVideos[ $videoId ]            = "tmp";
					$videosFound['count'] ++;
					
					
				}
			}
			$videosFound['real_count'] = count( $videosFound['items'] );
		}
		
		
		/* Apply Filtering on Videos Found */
		$videosFound = wpvr_filter_videos_found( $videosFound, $options );
		
		
		// RECALL IF WANTED VIDEOS IS NOT REACHED
		if ( $videosFound['totalResults'] != 0 && $videosFound['real_count'] < $options['how']['wantedResults'] ) {
			if ( $videosFound['nextPageToken'] == 'end' ) {
				if ( $options['how']['debugMode'] ) {
					echo( '<br/> Found : ' . $videosFound['count'] . ' .... END SEARCH' );
				}
			} else {
				if ( $options['how']['debugMode'] ) {
					echo( '<br/> Found : ' . $videosFound['count'] . ' .... need to recall' );
				}
				$videosFound['recalls'] = $videosFound['recalls'] + 1;
				$videosFound            = $vs_dm['fetch_videos']( $videosFound, $options, $oldVideos );
			}
		} else {
			if ( $options['how']['debugMode'] ) {
				echo( '<br/> Found : ' . $videosFound['count'] . ' .... DONE !' );
			}
			$videosFound['execTime'] = round( microtime( true ) - $videosFound['execTime'], 2 );
		}
		
		return $videosFound;
	};
	$vs['fetch_videos']    = $vs_dm['fetch_videos'];
	/* Fetch Videos */
	
	
	/* Get Comments of a video */
	$vs_dmcm                 = $vs;
	$vs_dmcm['get_comments'] = function ( $video_id, $post_id, $cData ) use ( &$vs_dmcm, $pid_suffix ) {
		
		$cData = wpvr_extend( $cData, array(
			'ch'        => curl_init(),
			'pageToken' => 1,
			'wanted'    => 20,
			'count'     => 0,
			'recalls'   => 0,
			'do_import' => false,
			'comments'  => array(),
		) );
		
		//if( ! isset( $vs_dmcm ) ) return $cData;
		
		$api = $vs_dmcm['api_auth']();
		if ( $api === false ) {
			$cData['msg'] = 'Dailymotion API not authorized.';
			
			return $cData;
		}
		
		$dailymotion_endpoint = '/video/' . $video_id . '/comments';
		
		$dailymotion_args = array(
			'fields' => 'created_time,message,owner.screenname,owner.url',
			//'sort'   => 'recent',
			'page'   => $cData['pageToken'],
			'limit'  => 100,
		);
		// _d( $api );
		// _d( $dailymotion_endpoint );
		// _d( $dailymotion_args );
		// return $cData;
		
		$api_response = wpvr_object_to_array( $api->get( $dailymotion_endpoint, $dailymotion_args ) );
		//$api_response     = $api->get( $dailymotion_endpoint, $dailymotion_args );
		// _d( $api_response );
		// die();
		$max_pages = ( $api_response['total'] / $api_response['limit'] ) + 1;
		
		if ( ! isset( $api_response['list'] ) || ! is_array( $api_response['list'] ) || count( $api_response['list'] ) == 0 ) {
			return $cData;
		}
		
		foreach ( (array) $api_response['list'] as $item ) {
			if ( $cData['count'] >= $cData['wanted'] ) {
				return $cData;
			}
			
			//$comment = $item ;
			
			$nDate          = DateTime::createFromFormat( 'U', $item['created_time'] );
			$comment_date   = $nDate->format( 'Y-m-d H:i:s' );
			$comment_author = str_replace( '(Verified)', '', str_replace( '(Verified Contributor)', '', $item['owner.screenname'] ) );
			$cData['count'] ++;
			
			$comment = array(
				'comment_post_ID'      => $post_id,
				'comment_author'       => $comment_author,
				'comment_author_email' => '',
				'comment_author_url'   => $item['owner.url'],
				'comment_content'      => $item['message'],
				'comment_type'         => '',
				'comment_parent'       => 0,
				'comment_author_IP'    => '127.0.0.1',
				'comment_agent'        => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
				'comment_date'         => $comment_date,
				'comment_approved'     => 1,
			);
			if ( $cData['do_import'] === true ) {
				$comment_id            = wp_insert_comment( $comment );
				$comment['comment_id'] = $comment_id;
			} else {
				//new dBug( $comment );
			}
			$cData['comments'][] = $comment;
		}
		if ( $api_response['has_more'] === true && ( $cData['pageToken'] + 1 ) <= $max_pages && $cData['count'] <= $cData['wanted'] ) {
			$cData['recalls'] ++;
			$cData['pageToken'] = $cData['pageToken'] + 1;
			
			return $vs_dmcm['get_comments']( $video_id, $post_id, $cData );
		}
		
		return $cData;
		
	};
	$vs['get_comments']      = $vs_dmcm['get_comments'];