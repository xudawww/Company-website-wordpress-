<?php
	function wpvr_adapt_v19() {
		
		// Reload Addons List
		$addons_obj = wpvr_get_addons( array() , TRUE );
		
		//DELETE ALL OLD WPVR TMP FILES
		global $wpdb;
		$wpdb->get_results( "DELETE FROM $wpdb->options WHERE option_name like 'wpvr_tmp%'" , OBJECT );
		
		// Clear all WPVR Notices
		update_option('wpvr_notices' , array() );
		
		//Delete wpvr_logs old table
		$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}wpvr_log" );
		
		
		//Reset Video Tables
		global $wpvr_imported;
		
		update_site_option( 'wpvr_deferred', array() );
		update_site_option( 'wpvr_deferred_ids', array() );
		update_site_option( 'wpvr_imported', array() );
		
		$imported      = wpvr_update_imported_videos();
		$wpvr_imported = get_site_option( 'wpvr_imported' );
		
	}
	function wpvr_adapt_v188() {
		
		// Reload Addons List
		$addons_obj = wpvr_get_addons( array() , TRUE );
		
		//DELETE ALL OLD WPVR TMP FILES
		global $wpdb;
		$wpdb->get_results( "DELETE FROM $wpdb->options WHERE option_name like 'wpvr_tmp%'" , OBJECT );
		
		// Clear all WPVR Notices
		update_option('wpvr_notices' , array() );
		
	}
	
	function wpvr_adapt_v1847() {
		
		// Reload Addons List
		$addons_obj = wpvr_get_addons( array() , TRUE );
		
		//DELETE ALL OLD WPVR TMP FILES
		global $wpdb;
		$wpdb->get_results( "DELETE FROM $wpdb->options WHERE option_name like 'wpvr_tmp%'" , OBJECT );
		
		// Clear all WPVR Notices
		update_option('wpvr_notices' , array() );
		
	}
	function wpvr_adapt_v184() {

		// Reload Addons List
		$addons_obj = wpvr_get_addons( array() , TRUE );

		//DELETE ALL OLD WPVR TMP FILES
		global $wpdb;
		$wpdb->get_results( "DELETE FROM $wpdb->options WHERE option_name like 'wpvr_tmp%'" , OBJECT );
		
		// Clear all WPVR Notices
		update_option('wpvr_notices' , array() );

	}

	function wpvr_adapt_v183() {
		//$addons_obj = wpvr_get_addons( array() , TRUE );
	}

	function wpvr_adapt_v182() {
		global $wpdb;
		//DELETE ALL OLD WPVR TMP FILES
		$wpdb->get_results( "DELETE FROM $wpdb->options WHERE option_name like 'wpvr_tmp%'" , OBJECT );
		update_option( 'wpvr_notices' , array() );

		return '';
	}

	function wpvr_adapt_v181() {
		global $wpdb;
		//DELETE ALL OLD WPVR TMP FILES
		$wpdb->get_results( "DELETE FROM $wpdb->options WHERE option_name like 'wpvr_tmp%'" , OBJECT );

		return '';
	}

	function wpvr_adapt_170_fields( $source_id , $new_type , $todos = array() ) {

		if( $new_type == 'search_yt' ) {
			
			$todos[] = array(
				'id'    => $source_id ,
				'key'   => 'wpvr_source_searchTerm_yt' ,
				'value' => get_post_meta( $source_id , 'wpvr_source_searchTerm' , TRUE ) ,
			);
			
		} elseif( $new_type == 'videos_yt' ) {
			
			$todos[] = array(
				'id'    => $source_id ,
				'key'   => 'wpvr_source_videoIds_yt' ,
				'value' => get_post_meta( $source_id , 'wpvr_source_videoIds' , TRUE ) ,
			);
			
		} elseif( $new_type == 'channel_yt' ) {
			
			$todos[] = array(
				'id'    => $source_id ,
				'key'   => 'wpvr_source_channelIds_yt' ,
				'value' => get_post_meta( $source_id , 'wpvr_source_channelIds' , TRUE ) ,
			);
			$todos[] = array(
				'id'    => $source_id ,
				'key'   => 'wpvr_source_channelId_yt' ,
				'value' => get_post_meta( $source_id , 'wpvr_source_channelId' , TRUE ) ,
			);
			
		} elseif( $new_type == 'playlist_yt' ) {
			
			$todos[] = array(
				'id'    => $source_id ,
				'key'   => 'wpvr_source_playlistIds_yt' ,
				'value' => get_post_meta( $source_id , 'wpvr_source_playlistIds' , TRUE ) ,
			);
			$todos[] = array(
				'id'    => $source_id ,
				'key'   => 'wpvr_source_playlistId_yt' ,
				'value' => get_post_meta( $source_id , 'wpvr_source_playlistId' , TRUE ) ,
			);
			
		} elseif( $new_type == 'trends_yt' ) {
			
			$todos[] = array(
				'id'    => $source_id ,
				'key'   => 'wpvr_source_regionCode_yt' ,
				'value' => get_post_meta( $source_id , 'wpvr_source_regionCode' , TRUE ) ,
			);
			
		}
		
		return $todos;
		
		
	}

	function wpvr_adapt_v170() {
		$x            = array();
		$x[ 'count' ] = 0;
		$x[ 'items' ] = array();
		$sources      = wpvr_get_sources();
		$todos        = array();
		if( count( $sources ) != 0 && is_array( $sources ) ) {
			foreach ( (array) $sources as $source ) {


				$metas = get_post_meta( $source->id , '' , TRUE );
				//d( $metas );
				$service  = $metas[ 'wpvr_source_service' ][ 0 ];
				$type     = $metas[ 'wpvr_source_type' ][ 0 ];
				$new_type = $type;

				$x[ 'count' ] ++;

				if( $service == 'dailymotion' ) {

					if( isset( $metas[ 'wpvr_source_playlistId_dm' ] ) && $metas[ 'wpvr_source_playlistId_dm' ][ 0 ] != '' ) $new_type = 'playlist_dm';
					elseif( isset( $metas[ 'wpvr_source_groupId_dm' ] ) && $metas[ 'wpvr_source_groupId_dm' ][ 0 ] != '' ) $new_type = 'group_dm';
					elseif( isset( $metas[ 'wpvr_source_channelId_dm' ] ) && $metas[ 'wpvr_source_channelId_dm' ][ 0 ] != '' ) $new_type = 'channel_dm';
					elseif( isset( $metas[ 'wpvr_source_videoId_dm' ] ) && $metas[ 'wpvr_source_videoId_dm' ][ 0 ] != '' ) $new_type = 'videos_dm';
					elseif( isset( $metas[ 'wpvr_source_videoIds_dm' ] ) && $metas[ 'wpvr_source_videoIds_dm' ][ 0 ] != '' ) $new_type = 'videos_dm';
					elseif( isset( $metas[ 'wpvr_source_regionCode_dm' ] ) && $metas[ 'wpvr_source_regionCode_dm' ][ 0 ] != '' ) $new_type = 'trends_dm';
					elseif( isset( $metas[ 'wpvr_source_searchTerm_dm' ] ) && $metas[ 'wpvr_source_searchTerm_dm' ][ 0 ] != '' ) $new_type = 'search_dm';

				} elseif( $service == 'youtube' ) {


					//Playlists
					if( isset( $metas[ 'wpvr_source_playlistId' ] ) && $metas[ 'wpvr_source_playlistId' ][ 0 ] != '' ) $new_type = 'playlist_yt';
					elseif( isset( $metas[ 'wpvr_source_playlistIds' ] ) && $metas[ 'wpvr_source_playlistIds' ][ 0 ] != '' ) $new_type = 'playlist_yt';
					elseif( isset( $metas[ 'wpvr_source_playlistIds_yt' ] ) && $metas[ 'wpvr_source_playlistIds_yt' ][ 0 ] != '' ) $new_type = 'playlist_yt';
					elseif( isset( $metas[ 'wpvr_source_playlistId_yt' ] ) && $metas[ 'wpvr_source_playlistId_yt' ][ 0 ] != '' ) $new_type = 'playlist_yt';


					//Playlists
					elseif( isset( $metas[ 'wpvr_source_channelId' ] ) && $metas[ 'wpvr_source_channelId' ][ 0 ] != '' ) $new_type = 'channel_yt';
					elseif( isset( $metas[ 'wpvr_source_channelIds' ] ) && $metas[ 'wpvr_source_channelIds' ][ 0 ] != '' ) $new_type = 'channel_yt';
					elseif( isset( $metas[ 'wpvr_source_channelIds_yt' ] ) && $metas[ 'wpvr_source_channelIds_yt' ][ 0 ] != '' ) $new_type = 'channel_yt';
					elseif( isset( $metas[ 'wpvr_source_channelId_yt' ] ) && $metas[ 'wpvr_source_channelId_yt' ][ 0 ] != '' ) $new_type = 'channel_yt';


					//Videos
					elseif( isset( $metas[ 'wpvr_source_videoId' ] ) && $metas[ 'wpvr_source_videoId' ][ 0 ] != '' ) $new_type = 'videos_yt';
					elseif( isset( $metas[ 'wpvr_source_videoIds' ] ) && $metas[ 'wpvr_source_videoIds' ][ 0 ] != '' ) $new_type = 'videos_yt';
					elseif( isset( $metas[ 'wpvr_source_videoIds_yt' ] ) && $metas[ 'wpvr_source_videoIds_yt' ][ 0 ] != '' ) $new_type = 'videos_yt';
					elseif( isset( $metas[ 'wpvr_source_videoId_yt' ] ) && $metas[ 'wpvr_source_videoId_yt' ][ 0 ] != '' ) $new_type = 'videos_yt';


					//Trends
					elseif( isset( $metas[ 'wpvr_source_regionCode_yt' ] ) && $metas[ 'wpvr_source_regionCode_yt' ][ 0 ] != '' ) $new_type = 'trends_yt';
					elseif( isset( $metas[ 'wpvr_source_regionCode' ] ) && $metas[ 'wpvr_source_regionCode' ][ 0 ] != '' ) $new_type = 'trends_yt';


					//Search
					if( isset( $metas[ 'wpvr_source_searchTerm' ] ) && $metas[ 'wpvr_source_searchTerm' ][ 0 ] != '' ) $new_type = 'search_yt';
					elseif( isset( $metas[ 'wpvr_source_searchTerm_yt' ] ) && $metas[ 'wpvr_source_searchTerm_yt' ][ 0 ] != '' ) $new_type = 'search_yt';
				}


				$x[ 'items' ][ $source->id ] = array(
					'id'       => $source->id ,
					'name'     => $metas[ 'wpvr_source_name' ][ 0 ] ,
					'service'  => $metas[ 'wpvr_source_service' ][ 0 ] ,
					'old_type' => $type ,
					'new_type' => $new_type ,
					//'metas' => $metas ,
				);
				
				$todos = wpvr_adapt_170_fields( $source->id , $new_type , $todos );
				
				
				//d( $x );
				//return false;

			}
		}
		
		$log = array();
		//d( $x['items'] );
		if( $x[ 'count' ] != 0 ) {
			foreach ( (array) $x[ 'items' ] as $item ) {
				if( $item[ 'new_type' ] == $item[ 'old_type' ] ) {
					$log[] = ' - ' . $item[ 'name' ] . '(' . $item[ 'id' ] . ' ) : Unchanged ... ';
				} else {
					$log[] = ' - ' . $item[ 'name' ] . '(' . $item[ 'id' ] . ' ) : Changed type from ' . $item[ 'old_type' ] . ' to  ' . $item[ 'new_type' ];
					update_post_meta( $item[ 'id' ] , 'wpvr_source_type' , $item[ 'new_type' ] );
				}

			}
		}
		
		//d( $todos );
		foreach ( (array) $todos as $todo ) {
			//d( $todo );
			update_post_meta( $todo[ 'id' ] , $todo[ 'key' ] , $todo[ 'value' ] );
		}
		
		
		update_option( 'wpvr_17_fix' , array( 'x' => $x , 'log' => $log ) );
		//d( $log );
	}

	function wpvr_adapt_v17() {

		//Adapat old sources
		$count     = 0;
		$count_all = 0;
		$sources   = wpvr_get_sources();
		if( count( $sources ) != 0 && is_array( $sources ) ) {

			foreach ( (array) $sources as $source ) {
				$count_all ++;
				if( $source->service == 'youtube' ) {
					if( $source->type == 'trendy' || $source->type == 'trendy_yt' ) $source->type = 'trends';
					$x = explode( '_yt' , $source->type );
					if( $x[ 0 ] == $x ) $new_type = $source->type . '_yt';
					else $new_type = $x[ 0 ] . '_yt';
					$count ++;
					update_post_meta( $source->id , 'wpvr_source_type' , $new_type );
				}
				if( $source->service == 'dailymotion' ) {
					if( $source->type == 'trendy_dm' ) {
						$new_type = 'trends_dm';
						$count ++;
						update_post_meta( $source->id , 'wpvr_source_type' , $new_type );
					}
				}
			}
		}
		//REload Addons List
		update_option( 'wpvr_addons_list' , '' );

		//Reset Notices
		update_option( 'wpvr_notices' , '' );

		wpvr_add_notice( array(
			'slug'               => '' ,
			'title'              => 'Welcome to WPVR v1.7' ,
			'class'              => 'updated' , //updated or warning or error
			'content'            => "Thanks for updating WP Video Robot ! <br/><br/>What's new in this version ? <br/>Many bugs corrections, a brand new userinterface. The flagship feature is the coming of new video services.Check the version changelog for more information."
			                        .
			                        "<br/><br/>" .
			                        "<br/><br/><br/><a class='wpvr_button' style='text-align: center;display: inherit;text-decoration: none;' target='_blank' href='https://store.wpvideorobot.com'><i class='fa fa-shopping-cart'></i> -- SAVE 70% ON ADDONS ! -- <i class='fa fa-shopping-cart'></i></a>"
			                        .
			                        "<br/><br/><a class='wpvr_button' style='background:#37BC9B;text-align: center;display: inherit;text-decoration: none;' target='_blank' href='http://codecanyon.net/downloads#item-8619739'><i class='fa fa-heart'></i> -- RATE WP VIDEO ROBOT -- <i class='fa fa-heart'></i></a>"
			                        .
			                        "<br/><br/><strong>Cheers !</strong><br/>pressaholic" ,
			'hidable'            => TRUE ,
			'is_dialog'          => TRUE ,
			'dialog_modal'       => FALSE ,
			'dialog_delay'       => 2500 ,
			'dialog_ok_button'   => FALSE ,
			'dialog_hide_button' => '<i class="fa fa-close"></i> DISMISS THIS NOTICE' ,
		) );

		return "$count / $count_all source(s) has been adapted.";

	}

	function wpvr_adapt_v1665() {
		update_option( 'wpvr_addons_list' , '' );
		update_option( 'wpvr_notices' , '' );
		wpvr_add_notice( array(
			'slug'               => '' ,
			'title'              => 'Welcome to WPVR v1.6.65' ,
			'class'              => 'updated' , //updated or warning or error
			'content'            => "Thanks for updating WP Video Robot ! <br/><br/>What's new in this version ? <br/>Many bugs corrected and some new videos filtering features are now available. Check this version changelog for more infos."
			                        .
			                        "<br/><br/>" .
			                        "<br/><br/><br/><a class='wpvr_button' style='text-align: center;display: inherit;text-decoration: none;' target='_blank' href='https://store.wpvideorobot.com'><i class='fa fa-shopping-cart'></i> -- SAVE 70% ON ADDONS ! -- <i class='fa fa-shopping-cart'></i></a>"
			                        .
			                        "<br/><br/><a class='wpvr_button' style='background:#37BC9B;text-align: center;display: inherit;text-decoration: none;' target='_blank' href='http://codecanyon.net/downloads#item-8619739'><i class='fa fa-heart'></i> -- RATE WP VIDEO ROBOT -- <i class='fa fa-heart'></i></a>"
			                        .
			                        "<br/><br/><strong>Cheers !</strong><br/>pressaholic" ,
			'hidable'            => TRUE ,
			'is_dialog'          => TRUE ,
			'dialog_modal'       => FALSE ,
			'dialog_delay'       => 2500 ,
			'dialog_ok_button'   => FALSE ,
			'dialog_hide_button' => '<i class="fa fa-close"></i> DISMISS THIS NOTICE' ,
		) );
		
	}

	/* Adapting data to version 1.6.4 */
	function wpvr_adapt_v164() {
		update_option( 'wpvr_addons_list' , '' );
		/*wpvr_add_notice( array(
			'slug' => '',
			'title' => 'Welcome to WPVR v1.6.4',
			'class' => 'updated', //updated or warning or error
			'content' => "Thanks for updating WP Video Robot ! <br/><br/>What's new in this version ? <br/>Many bugs corrected and some new videos filtering features are now available. Check this version changelog for more infos.".
				"<br/><br/>".
				"What about enhancing WP Video Robot functionalities with our brand new addons ?<br/>".
				"To celebrate its opening, we offer a <strong>70% discount on our starter bundle</strong>, by using <u>LAUNCHING50PERCENT</u> coupon code until June 30th 2015.".
				"<br/><br/><br/><a class='wpvr_button' style='text-align: center;display: inherit;text-decoration: none;' target='_blank' href='https://store.wpvideorobot.com'>CHECK OUT OUR ADDONS STORE</a>".
				"<br/><br/><strong>Cheers !</strong><br/>pressaholic",
			'hidable' => true,
			'is_dialog' => true,
			'dialog_modal' => false,
			'dialog_delay' => 2500,
			'dialog_ok_button' => ' <i class="fa fa-check"></i> Got It !',
			'dialog_hide_button' => '<i class="fa fa-close"></i> DISMISS ',
		));
		*/
		
	}

	/* Adapting data to version 1.6 */
	function wpvr_adapt_v16() {
		global $wpdb , $wpvr_options , $wpvr_default_options;
		$querystr
			     = "
			SELECT 
				P.ID as id,
				GROUP_CONCAT(if(M.meta_key = 'wpvr_source_postCats' , M.meta_value , NULL ) SEPARATOR '' ) as postCats
			FROM 
				$wpdb->posts P 
				INNER JOIN $wpdb->postmeta M ON P.ID = M.post_id
			WHERE
				P.post_status IN ('publish','draft')
				AND P.post_type = '" . WPVR_SOURCE_TYPE . "'
			GROUP by 
				P.ID
			ORDER BY 
				P.post_date DESC
		";
		$sources = $wpdb->get_results( $querystr , OBJECT );
		foreach ( (array) $sources as $source ) {
			$source       = (array) $source;
			$old_postCats = $source[ 'postCats' ];
			
			if( $old_postCats == 'false' ) $new_postCats = wpvr_json_encode( array() );
			else $new_postCats = wpvr_json_encode( unserialize( $old_postCats ) );
			update_post_meta( $source[ 'id' ] , 'wpvr_source_postCats' , $new_postCats );
		}
		
		
		// Adapting Options
		$new_wpvr_options = $wpvr_options;
		if( ! isset( $new_wpvr_options ) || ! is_array( $new_wpvr_options ) ) {
			$new_wpvr_options = $wpvr_default_options;
			
		} else {
			foreach ( (array) $wpvr_default_options as $name => $value ) {
				if( ! isset( $new_wpvr_options[ $name ] ) ) $new_wpvr_options[ $name ] = $value;
			}
		}
		update_option( 'wpvr_options' , $new_wpvr_options );
		
	}
	
	/* Adapting data to version 1.5 */
	function wpvr_adapt_v15() {
		global $wpdb;
		$sql_sources
			   = "
			(
				SELECT 
					'video' as type,
					P.ID as id,
					GROUP_CONCAT(if(M.meta_key = 'wpvr_video_service' , M.meta_value , NULL ) SEPARATOR '') as service,
					GROUP_CONCAT(if(M.meta_key = 'wpvr_video_id' , M.meta_value , NULL ) SEPARATOR '') as video_id
				FROM 
					$wpdb->posts P 
					INNER JOIN $wpdb->postmeta M ON P.ID = M.post_id
					
				WHERE
					1
					AND P.post_type = '" . WPVR_VIDEO_TYPE . "'
				GROUP by P.ID
				ORDER BY P.post_date DESC
			)UNION(
				SELECT 
					
					'source' as type,
					
					P.ID as id,
					GROUP_CONCAT(if(M.meta_key = 'wpvr_source_service' , M.meta_value , NULL ) SEPARATOR '') as service,
					null as video_id
				FROM 
					$wpdb->posts P 
					INNER JOIN $wpdb->postmeta M ON P.ID = M.post_id
					
				WHERE
					1
					AND P.post_type = '" . WPVR_SOURCE_TYPE . "'
				GROUP by P.ID
				ORDER BY P.post_date DESC
			)
		";
		$items = $wpdb->get_results( $sql_sources , OBJECT );
		
		//new dBug( $items );

		if( count( $items ) != 0 ) {
			
			foreach ( (array) $items as $item ) {
				
				if( empty( $item->service ) ) {

					if( $item->type == 'video' ) {
						add_post_meta( $item->id , 'wpvr_video_ytId' , $item->video_id );
						add_post_meta( $item->id , 'wpvr_video_service' , 'youtube' );
					} elseif( $item->type == 'source' ) {
						add_post_meta( $item->id , 'wpvr_source_service' , 'youtube' );
						add_post_meta( $item->id , 'wpvr_source_postDate' , 'default' );
					}
					
				}
			}
		}

	}