<?php
	
	
	add_action( 'wp_ajax_nopriv_get_video_preview', 'wpvr_get_video_preview_ajax_function' );
	add_action( 'wp_ajax_get_video_preview', 'wpvr_get_video_preview_ajax_function' );
	function wpvr_get_video_preview_ajax_function() {
		$player_code = wpvr_video_embed(
			$_POST['video_id'],
			$_POST['post_id'],
			$autoPlay = true,
			$_POST['service'],
			'preview',
			array(),
			array()
		);
		echo wpvr_get_json_response( $player_code );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_refresh_manage_videos', 'wpvr_refresh_manage_videos_ajax_function' );
	add_action( 'wp_ajax_refresh_manage_videos', 'wpvr_refresh_manage_videos_ajax_function' );
	function wpvr_refresh_manage_videos_ajax_function() {
		global $wpvr_status, $wpvr_vs, $wpvr_is_admin, $wpvr_options;
		
		$wpvr_is_admin = true;
		
		
		if ( isset( $_POST['manage_layout'] ) ) {
			$layout = $_POST['manage_layout'];
		} else {
			$layout = WPVR_MANAGE_LAYOUT;
		}
		
		if ( isset( $_POST['get_filter_page'] ) ) {
			$filter_page = $_POST['get_filter_page'];
		}
		if ( isset( $_POST['filter_page'] ) ) {
			$filter_page = $_POST['filter_page'];
		}
		
		if ( ! isset( $_POST['filter_page'] ) && ! isset( $_POST['get_filter_page'] ) ) {
			$filter_page = 1;
		}
		
		// d( $filter_page );
		$args = array(
			'page'    => $filter_page,
			'perpage' => $wpvr_options['videosPerPage'],
		);
		
		
		if ( isset( $_POST['filter_dates'] ) ) {
			$args['date'] = $_POST['filter_dates'];
		}
		if ( isset( $_POST['filter_services'] ) ) {
			$args['service'] = $_POST['filter_services'];
		}
		if ( isset( $_POST['filter_statuses'] ) ) {
			$args['status'] = $_POST['filter_statuses'];
		}
		if ( isset( $_POST['filter_search'] ) ) {
			$args['search'] = $_POST['filter_search'];
		}
		if ( isset( $_POST['filter_authors'] ) ) {
			$args['author'] = $_POST['filter_authors'];
		}
		if ( isset( $_POST['filter_order'] ) ) {
			$args['order'] = $_POST['filter_order'];
		}
		if ( isset( $_POST['filter_orderby'] ) ) {
			$args['orderby'] = $_POST['filter_orderby'];
		}
		if ( isset( $_POST['filter_categories'] ) ) {
			$args['category'] = $_POST['filter_categories'];
		}
		
		if ( isset( $_POST['dupsBy'] ) ) {
			$args['dupsBy'] = $_POST['dupsBy'];
		}
		
		//$args['dupsBy'] = 'video_id';
		
		//echo "YASSINE";
		//_d( $args );
		$return = wpvr_manage_videos( $args );
		
		//_d( $return );
		
		if ( $return['items_type'] == 'duplicates' ) {
			$dups = true;
		} else {
			$dups = false;
		}
		
		
		if ( $return['total_results'] == 0 || count( $return['items'] ) == 0 ) {
			//$return['html'] = ' NO RES !';
			echo wpvr_get_json_response( $return );
			
			return false;
		}
		
		$return['html'] = '';
		
		// #wpvr_manage_videos
		$return['html'] .= '<div class="' . $layout . '" id="wpvr_manage_videos" url="' . WPVR_MANAGE_URL . '" url_export="' . WPVR_MANAGE_URL . '">';
		
		// .wpvr_manage_bulk_form
		$return['html'] .= '<div class="wpvr_manage_bulk_form" action="">';
		
		foreach ( (array) $return['items'] as $item ) {
			
			//$showMe = $return['items_type'];
			
			if ( $dups ) {
				$x              = explode( ',', $item->ids );
				$thumb_post_id = $x[0];
			} else {
				$thumb_post_id = $item->post_id ;
			}
			$item_thumb_url = wpvr_get_video_thumbnail( $thumb_post_id, 'wpvr_hard_thumb' );
			$item_thumb_url = $item_thumb_url === false ? WPVR_NO_THUMB : $item_thumb_url ;
			$item_thumb_img = '<img class="wpvr_video_thumb_img" src="' . $item_thumb_url . '" />';
			
			$item_author = $item_categories = $item_postdate = '';
			
			if ( $item_thumb_img == '' ) {
				$item_thumb_img = '<img src="' . WPVR_NO_THUMB . '" />';
			}
			
			//new dBug( $item );
			
			$item_duration   = wpvr_get_duration_string( $item->duration );
			$item_embed_code = wpvr_video_embed( $item->id, $autoPlay = true, $item->service );
			$hideIt          = array();
			if ( $item->duration == '' ) {
				$hide['duration'] = 'hideIt';
			} else {
				$hide['duration'] = '';
			}
			
			if ( $item->status == '' ) {
				$hide['status'] = 'hideIt';
			} else {
				$hide['status'] = '';
			}
			
			if ( $item->views == '' ) {
				$hide['views'] = 'hideIt';
			} else {
				$hide['views'] = '';
			}
			
			if ( $item->service == '' ) {
				$hide['service'] = 'hideIt';
			} else {
				$hide['service'] = '';
			}
			
			/*
			if( strlen($item->description) > 500 )
				$item_description = substr(  strip_tags($item->description ) , 0 , min(500,strlen($item->description)) ) . ' <b>[...]</b>' ;
			else
				$item_description =   ($item->description ) ;
			*/
			$item_description = ( $item->description );
			if ( $item->title == '' ) {
				$item->title = '# ' . __( 'Untitled', WPVR_LANG ) . ' #';
			}
			if ( $item->service == '' ) {
				$item->service = 'unknown';
			}
			
			// .wpvr_video
			$return['html'] .= '<div class="wpvr_video pull-left ' . $item->status . ' " id="video_' . $item->post_id . '" >';
			
			// .wpvr_video_cb
			$return['html'] .= '<input type="checkbox" class="wpvr_video_cb" name="bulk_ids[]" value ="' . $item->post_id . '" />';
			
			// .wpvr_video_head
			$return['html'] .= '<div class="wpvr_video_head">';
			
			$return['html']
				.= '
				<div class = "wpvr_video_checked"><i class = "fa fa-check"></i></div>
			';
			
			
			// .wpvr_video_buttons
			$return['html'] .= '<div class="wpvr_video_buttons">';
			
			if ( $dups ) {
				// .wpvr_video_merge
				$return['html'] .= '<div class="wpvr_video_merge pull-left noMargin" url="' . WPVR_MANAGE_URL . '" ids="' . $item->ids . '" views="' . $item->views . '">';
				$return['html'] .= '<i class="fa fa-magic" ></i><br/>' . __( 'Merge', WPVR_LANG );
				$return['html'] .= '</div>'; // .wpvr_video_merge
			} else {
				// .wpvr_video_edit
				$return['html'] .= '<div class="wpvr_video_edit pull-left noMargin" link="' . get_edit_post_link( $item->post_id ) . '">';
				$return['html'] .= '<i class="fa fa-pencil" ></i><br/>' . __( 'Edit', WPVR_LANG );
				$return['html'] .= '</div>'; // .wpvr_video_edit
			}
			
			// .wpvr_video_view
			$return['html'] .= '<div class="wpvr_video_view pull-right noMargin" url="' . WPVR_MANAGE_URL . '" post_id = "' . $item->post_id . '" service="' . $item->service . '" video_id="'
			                   . $item->id
			                   . '">';
			$return['html'] .= '<i class="fa fa-eye" ></i><br/>' . __( 'Preview', WPVR_LANG );
			$return['html'] .= '</div>'; // .wpvr_video_view
			
			$return['html'] .= '<div class="wpvr_clearfix"></div>';
			
			$return['html'] .= '</div>';// .wpvr_video_buttons
			
			$return['html'] .= '<div class="wpvr_service_icon ' . $item->service . ' wpvr_video_service ' . $hide['service'] . '">';
			$return['html'] .= $wpvr_vs[ $item->service ]['label'];
			$return['html'] .= '</div>'; // .wpvr_service_icon
			
			
			// .wpvr_video_views
			$return['html'] .= '<div class="wpvr_video_views ' . $hide['views'] . '">' . wpvr_numberK( $item->views ) . ' ' . __( 'views', WPVR_LANG ) . '</div>';
			
			if ( $dups ) {
				// .wpvr_video_dupCount
				$return['html'] .= '<div class="wpvr_video_duration ' . $item->dupCount . '">' . wpvr_numberK( $item->dupCount ) . ' ' . __( 'dups', WPVR_LANG ) . '</div>';
			} else {
				// .wpvr_video_duration
				$return['html'] .= '<div class="wpvr_video_duration ' . $hide['duration'] . '">' . $item_duration . '</div>';
			}
			
			// .wpvr_video_status.
			$return['html'] .= '<div class="wpvr_video_status ' . $hide['status'] . ' ' . $item->status . '">';
			$return['html'] .= '<i class="fa wpvr_video_status_icon ' . $wpvr_status[ $item->status ]['icon'] . ' "></i>' . $wpvr_status[ $item->status ]['label'];
			$return['html'] .= '</div>'; // .wpvr_video_status
			
			// .wpvr_video_thumb
			$return['html'] .= '<div class="wpvr_video_thumb ' . $item->service . '"> ' . $item_thumb_img . ' </div>';
			
			$return['html'] .= '</div>';  // .wpvr_video_head
			
			// .wpvr_video_title
			$return['html'] .= '<div class="wpvr_video_title">' . $item->title . '</div>';
			
			//$return['html'] .= '<div>'.$showMe.'</div>';
			
			if ( ! $dups ) {
				
				// .wpvr_video_meta
				$return['html'] .= '<div class="wpvr_video_meta">';
				$return['html'] .= '<b>Posted by :</b> ' . get_the_author_meta( 'user_login', $item->author );
				$return['html'] .= '<b>On : </b>' . ( $item->date );
				$return['html'] .= '</div>'; // .wpvr_video_meta
				
				//.wpvr_video_description
				$return['html'] .= '<div class="wpvr_video_description">' . $item_description . '</div>';
				
			}
			
			$return['html'] .= '</div>'; // .wpvr_video_head
			
			
		}
		
		$return['html'] .= '<div class="wpvr_clearfix"></div>';
		
		$return['html'] .= '</div>'; // #wpvr_manage_videos
		$return['html'] .= '</div>'; // .wpvr_manage_bulk_form
		
		
		$return['debug'] = '';
		echo wpvr_get_json_response( $return );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_export_all_videos', 'wpvr_export_all_videos_ajax_function' );
	add_action( 'wp_ajax_export_all_videos', 'wpvr_export_all_videos_ajax_function' );
	function wpvr_export_all_videos_ajax_function() {
		$videos = wpvr_get_videos( array(
			'meta_suffix' => true,
		) );
		
		
		$json_videos = wpvr_json_encode( array(
			'data'    => $videos,
			'version' => WPVR_VERSION,
			'type'    => 'videos',
		) );
		$file        = "tmp_export_" . mt_rand( 0, 1000 ) . '_@_videos';
		file_put_contents( WPVR_TMP_PATH . $file, $json_videos );
		$site_url   = is_multisite() ? network_site_url() : site_url();
		$export_url = $site_url . "/wpvr_export/" . $file;
		echo wpvr_get_json_response( $export_url, 1, 'export file generated.' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_merge_items', 'wpvr_merge_items_ajax_function' );
	add_action( 'wp_ajax_merge_items', 'wpvr_merge_items_ajax_function' );
	function wpvr_merge_items_ajax_function() {
		global $wpvr_imported;
		
		$items = $_POST['items'];
		if ( $items == 'all' ) {
			$items = array();
		}
		$duplicates = wpvr_get_duplicate_videos(
			$items,
			$limit = false,
			$debug = false
		);
		$cleaner    = wpvr_prepare_duplicate_videos( $duplicates, true );
		$done       = wpvr_process_duplicate_videos( $cleaner, WPVR_CLEAN_DUPS_THUMBS );
		
		update_option( 'wpvr_deferred', array() );
		update_option( 'wpvr_deferred_ids', array() );
		update_option( 'wpvr_imported', array() );
		
		$imported      = wpvr_update_imported_videos();
		$wpvr_imported = get_option( 'wpvr_imported' );
		
		echo wpvr_get_json_response( $done );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_wpvr_import_videos', 'wpvr_wpvr_import_videos_ajax_function' );
	add_action( 'wp_ajax_wpvr_import_videos', 'wpvr_wpvr_import_videos_ajax_function' );
	function wpvr_wpvr_import_videos_ajax_function() {
		
		global $wpvr_imported;
		$r = array(
			'status'   => '',
			'count'    => 0,
			'countDup' => 0,
			'items'    => '',
			'version'  => '',
			'type'     => '',
		);
		
		$imported_file_name = "tmp_import_" . mt_rand( 0, 1000 );
		$imported_file      = WPVR_TMP_PATH . $imported_file_name;
		
		if ( move_uploaded_file( $_FILES['uploadedfile']['tmp_name'], $imported_file ) ) {
			//echo "The file ".  $_FILES['uploadedfile']['name']. " has been uploaded";
		} else {
			_e( "There was an error uploading the file, please try again!", WPVR_LANG );
			
			return false;
		}
		
		$json_data = file_get_contents( $imported_file );
		$json      = (array) wpvr_json_decode( $json_data );
		unlink( $imported_file );
		
		
		if ( ! isset( $json['version'] ) || ! isset( $json['data'] ) || ! isset( $json['type'] ) || $json['type'] != 'videos' ) {
			$r['status'] = 'invalid';
			echo wpvr_json_encode( $r );
			
			return false;
		}
		
		$ids       = array();
		$tmp       = array();
		$count_dup = 0;
		//new dBug( $json['data'] );
		foreach ( (array) $json['data'] as $k => $v ) {
			$service  = $json['data']['k']->__service;
			$video_id = $json['data']['k']->__video_id;
			
			
			if ( $_POST['skipDup'] != 'yes' || ( $_POST['skipDup'] == 'yes' && ! isset( $wpvr_imported[ $service ][ $video_id ] ) ) ) {
				
				$json['data'][ $k ]->skipDup     = $_POST['skipDup'];
				$json['data'][ $k ]->publishDate = $_POST['publishDate'];
				$json['data'][ $k ]->resetViews  = $_POST['resetViews'];
				
				$ids[]     = $k;
				$tmp[ $k ] = $json['data'][ $k ];
			} else {
				$count_dup ++;
			}
		}
		
		
		$r['status']   = 'ok';
		$r['version']  = $json['version'];
		$r['type']     = $json['type'];
		$r['items']    = $ids;
		$r['count']    = count( $json['data'] );
		$r['countDup'] = $count_dup;
		
		
		$_SESSION['wpvr_tmp_import'] = $tmp;
		
		//new dBug( $r['items'] );return false;
		echo wpvr_get_json_response( $r );
		
		die();
	}
	
	add_action( 'wp_ajax_nopriv_export_videos', 'wpvr_export_videos_ajax_function' );
	add_action( 'wp_ajax_export_videos', 'wpvr_export_videos_ajax_function' );
	function wpvr_export_videos_ajax_function() {
		$ids         = $_POST['bulk_ids'];
		$videos      = wpvr_get_videos( array(
			'ids'         => $ids,
			'order'       => 'views',
			'meta_suffix' => true,
		) );
		$json_videos = wpvr_json_encode( array(
			'data'    => $videos,
			'version' => WPVR_VERSION,
			'type'    => 'videos',
		) );
		$file        = "tmp_export_" . mt_rand( 0, 1000 ) . '_@_videos';
		file_put_contents( WPVR_TMP_PATH . $file, $json_videos );
		$site_url   = is_multisite() ? network_site_url() : site_url();
		$export_url = $site_url . "/wpvr_export/" . $file;
		
		// echo $export_url;
		echo wpvr_get_json_response( $export_url, 1, 'export file generated.' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_bulk_single_action', 'wpvr_bulk_single_action_ajax_function' );
	add_action( 'wp_ajax_bulk_single_action', 'wpvr_bulk_single_action_ajax_function' );
	function wpvr_bulk_single_action_ajax_function() {
		global $wpvr_imported;
		$id     = $_POST['video_id'];
		$action = $_POST['bulk_action'];
		
		
		switch ( $action ) {
			case 'delete' :
				$video_id      = get_post_meta( $id, 'wpvr_video_id', true );
				$video_service = get_post_meta( $id, 'wpvr_video_service', true );
				$r             = wp_delete_post( $id, true );
				unset( $wpvr_imported[ $video_service ][ $video_id ] );
				
				if ( $r === false ) {
					$r = 'error';
				} else {
					$r = 'ok';
				}
				break;
			case 'publish' :
				$status = get_post_status( $id );
				if ( $status != 'publish' ) {
					$r = wp_update_post( array( 'ID' => $id, 'post_status' => 'publish' ) );
				} else {
					$r = 'skipped';
				}
				if ( $r == 0 ) {
					$r = 'error';
				}
				break;
			case 'trash' :
				$status = get_post_status( $id );
				if ( $status != 'trash' ) {
					$r = wp_update_post( array( 'ID' => $id, 'post_status' => 'trash' ) );
				} else {
					$r = 'skipped';
				}
				if ( $r == 0 ) {
					$r = 'error';
				}
				break;
			case 'draft' :
				$status = get_post_status( $id );
				if ( $status != 'draft' ) {
					$r = wp_update_post( array( 'ID' => $id, 'post_status' => 'draft' ) );
				} else {
					$r = 'skipped';
				}
				if ( $r == 0 ) {
					$r = 'error';
				}
				break;
			case 'untrash' :
				$status = get_post_status( $id );
				if ( $status != 'publish' ) {
					$r = wp_update_post( array( 'ID' => $id, 'post_status' => 'publish' ) );
				} else {
					$r = 'skipped';
				}
				if ( $r == 0 ) {
					$r = 'error';
				}
				break;
			case 'pending' :
				$status = get_post_status( $id );
				if ( $status != 'pending' ) {
					$r = wp_update_post( array( 'ID' => $id, 'post_status' => 'pending' ) );
				} else {
					$r = 'skipped';
				}
				if ( $r == 0 ) {
					$r = 'error';
				}
				break;
			default:
				$r = 'noaction';
				break;
		}
		echo wpvr_get_json_response( $r, 1, 'Bulk Action processed' );
		die();
	}
	
	//add_action( 'wp_ajax_nopriv_@@@', 'wpvr_@@@_ajax_function' );
	//add_action( 'wp_ajax_@@@', 'wpvr_@@@_ajax_function' );
	//function wpvr_@@@_ajax_function() {
	//
	//	die();
	//}