<?php

	if( ! function_exists( 'wpvr_async_progressively_merge' ) ) {
		function wpvr_async_progressively_merge( $duplicates , $buffer ) {
			$r = $tmp = array();
			$i = $j = 0;
			foreach ( (array) $duplicates as $duplicate ) {
				$i ++;
				$j ++;
				if( $i >= $buffer ) {
					//d( $tmp );
					$r[] = wpvr_async_merge_dups( $tmp );

					$tmp = array();
					$i   = 0;
				} elseif( $j >= count( $duplicates ) - 1 ) {
					$tmp[] = $duplicate;
					$r[]   = wpvr_async_merge_dups( $tmp );
				} else {
					$tmp[] = $duplicate;
				}
			}


			return $r;
		}
	}

	if( ! function_exists( 'wpvr_get_all_duplicates' ) ) {
		function wpvr_get_all_duplicates( $max = FALSE ) {
			$r = wpvr_manage_videos( array(
				'dupsBy'   => 'video_id' ,
				'nopaging' => TRUE ,
			) );

			if( $r[ 'total_results' ] == 0 ) {
				return FALSE;
			}
			$ids = array();
			$i   = 0;

			//d( $r[ 'total_results' ] );

			foreach ( (array) $r[ 'items' ] as $item ) {
				if( $max != FALSE && $i >= $max ) break;
				$i ++;
				$duplicate_ids    = explode( ',' , $item->ids );
				$ids[ $item->id ] = array(
					'video_id'         => $item->id ,
					'video_views'      => $item->views ,
					'video_service'    => $item->service ,
					'master_title'     => $item->post_title ,
					'master_id'        => $duplicate_ids[ 0 ] ,
					'count_duplicates' => count( $duplicate_ids ) ,
					'duplicate_ids'    => $duplicate_ids ,
				);
			}

			return $ids;
		}
	}

	if( ! function_exists( 'wpvr_async_merge_dups' ) ) {
		function wpvr_async_merge_dups( $dups ) {
			$dups = (array) $dups;

			//d( $dups );

			$RCX      = new RollingCurlX( count( $dups ) );
			$token    = bin2hex( openssl_random_pseudo_bytes( 5 ) );
			$tmp_done = 'wpvr_tmp_done_' . $token;
			$timer    = wpvr_chrono_time();

			update_option( $tmp_done , array(
				'exec_time' => 0 ,
				'items'     => array() ,
				'raw'       => array() ,
			) );

			foreach ( (array) $dups as $dup ) {
				if( $dup === FALSE ) continue;
				$RCX->addRequest(
					wpvr_capi_build_query( WPVR_ACTIONS_URL , array(
						'wpvr_wpload'            => 1 ,
						'async_merge_single_dup' => 1 ,
						'token'                  => $token ,
						'video_views'            => $dup[ 'video_views' ] ,
						'video_service'          => $dup[ 'video_service' ] ,
						'master_id'              => $dup[ 'master_id' ] ,
						'duplicates_id'          => $dup[ 'duplicate_ids' ] ,
					) ) ,
					null ,
					'wpvr_async_merge_dups_callback' ,
					array(
						'token'         => $token ,
						'video_id'      => $dup[ 'video_id' ] ,
						'duplicates_id' => $dup[ 'duplicate_ids' ] ,
						'title'         => $dup[ 'master_title' ] ,
					) ,
					array(
						CURLOPT_FOLLOWLOCATION => FALSE ,
					)
				);
			}

			$RCX->execute();
			$done                = get_option( $tmp_done );
			$done[ 'exec_time' ] = wpvr_chrono_time( $timer );
			delete_option( $tmp_done );

			return $done;

		}
	}

	if( ! function_exists( 'wpvr_async_merge_dups_callback' ) ) {
		function wpvr_async_merge_dups_callback( $response , $url , $request_info , $user_data , $time ) {

			$token    = $user_data[ 'token' ];
			$video_id = $user_data[ 'video_id' ];

			$json     = (array) wpvr_json_decode( $response );
			$tmp_done = 'wpvr_tmp_done_' . $token;
			//$tmp_debug = 'wpvr_debug_sources_' . $token;
			$done = get_option( $tmp_done );
			if( ! isset( $json[ 'status' ] ) ) $status = 'ERROR';
			else $status = $json[ 'status' ];
			$done[ 'exec_time' ] += $time / 1000;
			$done[ 'items' ][ $video_id ] = array(
				'time'   => $time / 1000 ,
				'status' => $status ,
			);
			$done[ 'raw' ][ $video_id ]   = array(
				'time'         => $time / 1000 ,
				'request_info' => $request_info ,
				'response'     => $response ,
				'json'         => $json ,
				'title'        => $user_data[ 'title' ] ,
				//'debug'        => get_option( 'async_debug' ) ,
			);

			update_option( $tmp_done , $done );


		}
	}
	
	if( ! function_exists( 'wpvr_async_merge_all_dups' ) ) {
		function wpvr_async_merge_all_dups( $debug = FALSE ) {
			global $wpvr_imported;
			$duplicates = wpvr_get_all_duplicates();

			//d( $duplicates );

			if( $debug ) {
				d( $duplicates );

				return FALSE;
			}

			$done = wpvr_async_progressively_merge( $duplicates , 5 );

			update_option( 'wpvr_deferred' , array() );
			update_option( 'wpvr_deferred_ids' , array() );
			update_option( 'wpvr_imported' , array() );
			$imported      = wpvr_update_imported_videos();
			$wpvr_imported = get_option( 'wpvr_imported' );

			return $done;
		}
	}
	
	
	function wpvr_better_merge_all_duplicates(){
		
		global $wpvr_imported;
		
		$duplicates = wpvr_get_duplicate_videos(
			$items = array(),
			$limit = false,
			$debug = false
		);
		
		// d( $duplicates );
		
		$cleaner    = wpvr_prepare_duplicate_videos( $duplicates, true );
		
		// d( $cleaner );
		
		$done       = wpvr_process_duplicate_videos( $cleaner, WPVR_CLEAN_DUPS_THUMBS );
		// d( $done );
		update_option( 'wpvr_deferred', array() );
		update_option( 'wpvr_deferred_ids', array() );
		update_option( 'wpvr_imported', array() );
		
		$imported      = wpvr_update_imported_videos();
		$wpvr_imported = get_option( 'wpvr_imported' );
		
		return $done ;
	}