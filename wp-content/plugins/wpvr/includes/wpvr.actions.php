<?php
	
	/* Require Ajax WP load */
	if ( isset( $_GET['wpvr_wpload'] ) || isset( $_POST['wpvr_wpload'] ) ) {
		define( 'DOING_AJAX', true );
		//define('WP_ADMIN', true );
		$wpload = 'wp-load.php';
		while ( ! is_file( $wpload ) ) {
			if ( is_dir( '..' ) ) {
				chdir( '..' );
			} else {
				die( 'EN: Could not find WordPress! FR : Impossible de trouver WordPress !' );
			}
		}
		require_once( $wpload );
	}
	
	if ( isset( $_GET['adapt_old_data'] ) ) {
		
		if ( ! isset( $_GET['hard_adapt_from_version'] ) ) {
			$current_version = get_option( 'wpvr_is_adapted' );
		} else {
			$current_version = $_GET['hard_adapt_from_version'];
		}
		//$current_version = '1.6.65';
		//d( $current_version );
		
		$msg = '';
		if ( version_compare( $current_version, '1.5.0', '<' ) ) {
			// If current version is older than 1.5.0
			wpvr_adapt_v15();
			$msg .= '<br/> Adapted to version 1.5';
		}
		
		if ( version_compare( $current_version, '1.6', '<' ) ) {
			// If current version is older than 1.5.0
			wpvr_adapt_v16();
			$msg .= '<br/> Adapted to version 1.6';
		}
		
		if ( version_compare( $current_version, '1.6.35', '<' ) ) {
			// If current version is older than 1.5.0
			wpvr_adapt_v164();
			$msg .= '<br/> Adapted to version 1.6.35';
		}
		
		if ( version_compare( $current_version, '1.6.65', '<' ) ) {
			
			$msg .= " <br/> <strong> Adapted to version 1.6.65 </strong> <div> ";
			$msg .= wpvr_adapt_v1665();
			$msg .= "</div>";
		}
		if ( version_compare( $current_version, '1.7', '<' ) ) {
			// If current version is older than x
			
			$msg .= " <br/><strong> Adapted to version 1.7 </strong> <div>";
			$msg .= wpvr_adapt_v17();
			$msg .= "</div>";
			
		}
		if ( version_compare( $current_version, '1.7.0', '<' ) ) {
			$msg .= " <br/> <strong> Adapted to version 1.7.0 </strong> <div> ";
			$msg .= wpvr_adapt_v170();
			$msg .= "</div>";
		}
		if ( version_compare( $current_version, '1.8.1', '<' ) ) {
			$msg .= " <br/> <strong> Adapted to version 1.8.1 </strong> <div> ";
			$msg .= wpvr_adapt_v181();
			$msg .= "</div>";
		}
		
		if ( version_compare( $current_version, '1.8.2', '<' ) ) {
			$msg .= " <br/> <strong> Adapted to version 1.8.2 </strong> <div> ";
			$msg .= wpvr_adapt_v182();
			$msg .= "</div>";
		}
		
		if ( version_compare( $current_version, '1.8.4', '<' ) ) {
			$msg .= " <br/> <strong> Adapted to version 1.8.4 </strong> <div> ";
			$msg .= wpvr_adapt_v184();
			$msg .= "</div>";
		}
		
		if ( version_compare( $current_version, '1.8.4.7', '<' ) ) {
			$msg .= " <br/> <strong> Adapted to version 1.8.4.7 </strong> <div> ";
			$msg .= wpvr_adapt_v1847();
			$msg .= "</div>";
		}
		
		if ( version_compare( $current_version, '1.9', '<' ) ) {
			$msg .= " <br/> <strong> Adapted to version 1.9 </strong> <div> ";
			$msg .= wpvr_adapt_v19();
			$msg .= "</div>";
		}
		
		update_option( 'wpvr_is_adapted', WPVR_VERSION );
		
		// Reload Addons List
		$addons_obj = wpvr_get_addons( array(), true );
		
		// Clear all WPVR Notices
		update_option( 'wpvr_notices', array() );
		
		?>
        <div class="wrap">
            <h2 class="wpvr_title">
				<?php wpvr_show_logo(); ?>
                <i class="wpvr_title_icon fa fa-magic"></i>
				<?php echo __( 'WP Video Robot', WPVR_LANG ) . ' - ' . __( 'Adapting Old Data', WPVR_LANG ); ?>
            </h2>

            <p>

                <div class="updated">
            <p><?php echo __( 'All your videos and sources have been successfully adapted !', WPVR_LANG ); ?> </p>

            <p><?php echo $msg; ?></p>
        </div>
        <br/>
        <a href="<?php echo WPVR_DASHBOARD_URL; ?>">
			<?php echo __( 'Go Back', WPVR_LANG ); ?>
        </a>
        </p>
        </div>
		<?php
		return false;
	}
	if ( isset( $_GET['clone_source'] ) ) {
		
		$new_post_id  = wpvr_duplicate_source( $_GET['clone_source'], false );
		$redirect_url = admin_url( 'post.php?post=' . $new_post_id . '&action=edit', 'http' );
		echo "LOADING ...";
		?>
        <script>
            window.location.href = '<?php echo $redirect_url; ?>';
        </script>
		<?php
		exit;
		
	}
	if ( isset( $_GET['fake_activation'] ) ) {
		$wpvr_activation = array(
			'status'        => true,
			'date'          => '2015-04-12',
			'purchase_code' => '00:00:00:00:00',
			'id'            => 0,
			'email'         => 'pressaholic@gmail.com',
		);
		update_option( 'wpvr_activation', $wpvr_activation );
		
		return false;
		
	}
	if ( isset( $_GET['async_merge_single_dup'] ) ) {
		$master_id   = $_GET['master_id'];
		$ids         = $_GET['duplicates_id'];
		$video_views = isset( $_GET['video_views'] ) ? $_GET['video_views'] : 0;
		
		$json = array(
			'ids'              => $ids,
			'status'           => array(),
			'count_duplicates' => 0,
			'count_deleted'    => 0,
		);
		update_post_meta( $master_id, 'wpvr_video_views', $video_views );
		
		foreach ( (array) $ids as $id ) {
			if ( $master_id == $id ) {
				$json['status'][ $id ] = 'Master. Skip deleting.';
				continue;
			}
			
			$json['count_duplicates'] ++;
			$json['status'][ $id ] = wp_delete_post( $id, true ) ? 'Duplicate deleted.' : 'Error deleting this duplicate.';
			$json['count_deleted'] ++;
		}
		
		echo wpvr_json_encode( $json );
		
		return false;
	}
	if ( isset( $_GET['run_single_source_before'] ) ) {
	    $token       = $_GET['token'];
		$is_autorun  = $_GET['is_autorun'] == 1 ? true : false;
		$tmp_sources = 'wpvr_tmp_sources_' . $token;
		$tmp_done    = 'wpvr_tmp_done_' . $token;
		$sources     = get_option( $tmp_sources );
		$done        = get_option( $tmp_done );
		
		
		if ( $sources == '' || $done == '' ) {
			return false;
		}
		$source = $sources[ $_GET['source_id'] ];
		global $current_user_id ;
		$current_user_id = $_GET['user_id'];
		
		$run_res = wpvr_run_sources_without_adding( array( $source ), $is_autorun, false );
		
		//d( $run_res );
		
		$data = array(
			'name'    => $source->name,
			'service' => $source->service,
			'id'      => $source->id,
			'sub_id'  => $source->sub_id,
			'data'    => $run_res,
		);
		
		echo( WPVR_JS . wpvr_json_encode( $data, true ) . WPVR_JS );
		
		return false;
	}
	if ( isset( $_GET['run_single_source'] ) ) {
		$token       = $_GET['token'];
		$is_autorun  = $_GET['is_autorun'] == 1 ? true : false;
		$tmp_sources = 'wpvr_tmp_sources_' . $token;
		$tmp_done    = 'wpvr_tmp_done_' . $token;
		$sources     = get_option( $tmp_sources );
		$done        = get_option( $tmp_done );
		if ( $sources == '' || $done == '' ) {
			return false;
		}
		$source = $sources[ $_GET['source_id'] ];
		//d( $source );
		
		$data = wpvr_run_sources( array( $source ), $is_autorun, false );
		//d( $data );
		$data['name']    = $source->name;
		$data['service'] = $source->service;
		$data['id']      = $source->id;
		
		echo wpvr_json_encode( $data );
		
		return false;
	}
	if ( isset( $_GET['add_group_videos'] ) ) {
		
		global $wpvr_deferred_ids, $wpvr_unwanted_ids, $preDuplicates, $wpvr_vs;
		
		
		$token      = $_GET['token'];
		$j          = $_GET['group_id'];
		$tmp_videos = 'wpvr_tmp_videos_' . $token;
		$tmp_done   = 'wpvr_tmp_added_' . $token;
		$tmp_res    = 'wpvr_tmp_res_' . $token;
		$videos     = get_option( $tmp_videos );
		$done       = get_option( $tmp_done );
		
		if ( $done == '' || $done === false ) {
			return false;
		}
		if ( $videos == '' || $videos === false ) {
			return false;
		}
		
		//d( $videos[ $j ] );
		$added_group = wpvr_add_videos( $videos[ $j ] );
		//d( $added_group);
		echo wpvr_json_encode( $added_group );
		
		return false;
	}
	if ( isset( $_GET['fetch_single_source'] ) ) {
		global $wpvr_deferred_ids, $wpvr_unwanted_ids, $preDuplicates, $wpvr_vs;
		
		$preDuplicates = array();
		
		$token       = $_GET['token'];
		$tmp_sources = 'wpvr_tmp_sources_' . $token;
		$tmp_done    = 'wpvr_tmp_done_' . $token;
		$tmp_res     = 'wpvr_tmp_res_' . $token;
		$sources     = get_option( $tmp_sources );
		$done        = get_option( $tmp_done );
		
		if ( $sources == '' ) {
			// echo "### SOURCES EMPTY !";
			
			$error_notice_slug = wpvr_add_notice( array(
				'title'     => 'WP Video Robot : ',
				'class'     => 'error', //updated or warning or error
				'content'   => __( 'Asynchronous Execution is not supported by your server configuration.',WPVR_LANG).' <br/>'.
				               __("Please turn it OFF on WPVR Options > Fetching Options.", WPVR_LANG ),
				'hidable'   => false,
				'is_dialog' => false,
				'show_once' => true,
				'color'     => '#e4503c',
				'icon'      => 'fa-exclamation-circle',
			) );
			wpvr_render_notice( $error_notice_slug );
			wpvr_remove_notice( $error_notice_slug );
   
			return false;
		}
		
		$source = $sources[ $_GET['source_id'] ];
		
		//d( $source );
		
		
		// FETChSource
		if ( $source->postAppend == 'after' || $source->postAppend == 'before' ) {
			$vs      = $wpvr_vs[ $source->service ];
			$vs_type = $vs['types'][ $source->type ];
			if ( isset ( $vs[ 'get_' . $vs_type['global_id'] . '_data' ] ) ) {
				$source_data = $vs[ 'get_' . $vs_type['global_id'] . '_data' ]( $source->{$vs_type['param']} );
			} else {
				$source_data = '';
			}
			if ( $source_data != '' && isset( $source_data['name'] ) ) {
				$appendSourceName = $source_data['name'];
			} else {
				$appendSourceName = '';
			}
		} else {
			$appendSourceName = '';
		}
		
		/* SEARCH CONTEXT */
		$searchContext      = false;
		$searchContextValue = false;
		if ( $source->type == 'search_yt' ) {
			$metas = get_post_meta( $source->id );
			//d( $metas );
			$scType        = isset( $metas['wpvr_source_searchContextType_yt'] ) ? $metas['wpvr_source_searchContextType_yt'][0] : false;
			$searchContext = $scType;
			if ( $scType == 'byRegion' ) {
				$searchContext = $scType;
				if ( isset( $metas['wpvr_source_searchContextRegion_yt'] ) ) {
					$searchContextValue = $metas['wpvr_source_searchContextRegion_yt'][0];
				}
			} elseif ( $scType == 'byChannel' ) {
				$searchContext = $scType;
				if ( isset( $metas['wpvr_source_searchContextChannel_yt'] ) ) {
					$searchContextValue = $metas['wpvr_source_searchContextChannel_yt'][0];
				}
			}
		}
		/**********************/
		
		
		$sOptions = array(
			'how'  => array(
				'wantedResults'    => $source->wantedVideos,
				'onlyNewVideos'    => $source->onlyNewVideos,
				'getVideosStats'   => $source->getVideoStats,
				'getVideoTags'     => $source->getVideoTags,
				'debugMode'        => false,
				'postDate'         => $source->postDate,
				'postTags'         => $source->postTags,
				'postCats'         => $source->postCats,
				'postAuthor'       => $source->postAuthor,
				'autoPublish'      => $source->autoPublish,
				'sourceName'       => $source->name,
				'sourceId'         => $source->id,
				'sourceType'       => $source->type,
				'postAppend'       => $source->postAppend,
				'postContent'      => $source->postContent,
				'appendCustomText' => $source->appendCustomText,
				'appendSourceName' => $appendSourceName,
			),
			'what' => array(
				'era'                => $source->era,
				'mode'               => $source->type,
				'service'            => $source->service,
				'order'              => $source->orderVideos,
				'videoQuality'       => $source->videoQuality,
				'publishedAfter'     => $source->publishedAfter,
				'publishedBefore'    => $source->publishedBefore,
				'havingViews'        => $source->havingViews,
				'havingLikes'        => $source->havingLikes,
				'videoDuration'      => $source->videoDuration,
				'searchContext'      => $searchContext,
				'searchContextValue' => $searchContextValue,
			),
		);
		wpvr_set_debug( $sOptions );
		$sOptions = wpvr_prepare_sOptions_fields( $sOptions, $source );
		
		$tables = wpvr_prepare_tables_for_video_services(
			$wpvr_imported,
			$wpvr_deferred_ids,
			$wpvr_unwanted_ids
		);
		//d( $tables );
		if ( isset( $tables[ $source->service ] ) ) {
			$tables_merged = $tables[ $source->service ]['merged'];
		} else {
			$tables_merged = array();
		}
		
		
		if ( ! isset( $wpvr_vs[ $source->service ] ) ) {
			echo "### SERVICE UNDEFINED OR DISABLED !";
			
			return false;
		}
		$videosFound                  = array();
		$videosFound['source']        = $source;
		$videosFound['nextPageToken'] = '';
		
		$timer       = wpvr_chrono_time();
		$videosFound = $wpvr_vs[ $source->service ]['fetch_videos'](
			$videosFound,
			$sOptions,
			$tables_merged
		);
		
		$exec_time = wpvr_chrono_time( $timer );
		
		$videosFound['exec_time'] = $exec_time;
		$videosFound['source']    = $source;
		$videosFound['ch']        = 'curl Resource';
		
		
		$videosFound['done'] = 1;
		
		$videosFound['source_info'] = array(
			'name'    => $source->name,
			'service' => $source->service,
			'id'      => $source->id,
		);
		
		
		$wpvr_json_encoded = wpvr_json_encode( wpvr_utf8_converter( $videosFound ) );
		//d( $wpvr_json_encoded );
		//d( $videosFound );
		//d( json_last_error() );
		//echo wpvr_json_encode( $videosFound );
		
		echo WPVR_JS . $wpvr_json_encoded . WPVR_JS;
		
		
		return false;
	}
	if ( isset( $_GET['update_imported'] ) ) {
		global $wpvr_imported;
		
		$imported      = wpvr_update_imported_videos();
		$wpvr_imported = get_option( 'wpvr_imported' );
		//new dBug($wpvr_imported);
		//new dBug($imported );
		?>
        <div class="wrap">
            <h2 class="wpvr_title">
				<?php wpvr_show_logo(); ?>
                <i class="wpvr_title_icon fa fa-magic"></i>
				<?php echo __( 'WP Video Robot', WPVR_LANG ) . ' - ' . __( 'ANTI DUPLICATES FILTER', WPVR_LANG ); ?>
            </h2>

            <p>

                <div class="updated">
            <p><?php echo __( 'The anti duplicates filter is now ON.', WPVR_LANG ); ?> </p>
        </div>
        <br/>
        <a href="#" id="backBtn">
			<?php echo __( 'Go Back', WPVR_LANG ); ?>
        </a>
        </p>
        </div>
		<?php
		return false;
	}
	if ( isset( $_GET['export_videos'] ) ) {
		if ( isset( $_GET['ids'] ) ) {
			$ids = explode( ',', $_GET['ids'] );
		} else {
			return false;
		}
		
		wpvr_remove_tmp_files();
		
		$videos = wpvr_get_videos( array(
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
		?>
        <div class="wrap">

            <h2 class="wpvr_title">
				<?php wpvr_show_logo(); ?>
                <i class="wpvr_title_icon fa fa-upload"></i>
				<?php echo __( 'WP Video Robot', WPVR_LANG ) . ' - ' . __( 'Exporting Videos', WPVR_LANG ); ?>
            </h2>
            <iframe id="wpvr_iframe" src="" style="display:none; visibility:hidden;"></iframe>
            <p>

                <div class="updated">
            <p><?php echo __( 'Videos were successfully exported !', WPVR_LANG ); ?> </p>
        </div>
        <br/><br/>
		<?php echo __( 'Please wait, your download will shortly begin.', WPVR_LANG ); ?> <br/><br/>
        <a href="#" id="backBtn">
			<?php echo __( 'Go Back', WPVR_LANG ); ?>
        </a>
        </p>
        </div>
        <script>
            jQuery('#wpvr_iframe').attr('src', "<?php echo $export_url; ?>");
            jQuery('#backBtn').click(function (e) {
                window.history.go(-1);
                e.preventDefault();
                return false;
            });
        </script>
		<?php
		return false;
	}
	if ( isset( $_GET['export_sources'] ) ) {
		if ( isset( $_GET['ids'] ) ) {
			$source_ids = explode( ',', $_GET['ids'] );
			$sources    = wpvr_get_sources( array(
				'ids'         => $source_ids,
				'get_folders' => true,
			) );
			$message    = __( 'Could not find any source with the given IDs.', WPVR_LANG );
		} elseif ( isset( $_GET['folders'] ) ) {
			$source_folders = explode( ',', $_GET['folders'] );
			$sources        = wpvr_get_sources( array(
				'folders'     => $source_folders,
				'get_folders' => true,
			) );
			$message        = __( 'Could not find any source with the given folder.', WPVR_LANG );
		} else {
			echo "Invalid Testing Params";
			
			return false;
		}
		
		wpvr_remove_tmp_files();
		
		if ( count( $sources ) == 0 ) {
			?>
            <div class="wrap">
                <h2 class="wpvr_title">
					<?php wpvr_show_logo(); ?>
                    <i class="wpvr_title_icon fa fa-upload"></i>
					<?php echo __( 'WP Video Robot', WPVR_LANG ) . ' - ' . __( 'Exporting sources', WPVR_LANG ); ?>
                </h2>
                <div class="wpvr_manage_noResults">
                    <i class="fa fa-frown-o"></i><br/>
					<?php echo $message; ?>
                </div>
            </div>
			
			<?php
			return false;
		}
		
		//d($sources);
		//return false;
		
		$json_sources = wpvr_json_encode( array(
			'data'    => $sources,
			'version' => WPVR_VERSION,
			'type'    => 'sources',
		) );
		$file         = "tmp_export_" . mt_rand( 0, 1000 ) . '_@_sources';
		file_put_contents( WPVR_TMP_PATH . $file, $json_sources );
		
		$site_url   = is_multisite() ? network_site_url() : site_url();
		$export_url = $site_url . "/wpvr_export/" . $file;
		
		?>
        <div class="wrap">
            <h2 class="wpvr_title">
				<?php wpvr_show_logo(); ?>
                <i class="wpvr_title_icon fa fa-upload"></i>
				<?php echo __( 'WP Video Robot', WPVR_LANG ) . ' - ' . __( 'Exporting sources', WPVR_LANG ); ?>
            </h2>
            <iframe id="wpvr_iframe" src="" style="display:none; visibility:hidden;"></iframe>
            <p>

                <div class="updated">
            <p><?php echo __( 'Sources were successfully exported !', WPVR_LANG ); ?> </p>
        </div>
        <br/><br/>
		<?php echo __( 'Please wait, your download will shortly begin.', WPVR_LANG ); ?> <br/><br/>
        <a href="#" id="backBtn">
			<?php echo __( 'Go Back', WPVR_LANG ); ?>
        </a>
        </p>
        </div>
        <script>
            jQuery('#wpvr_iframe').attr('src', "<?php echo $export_url; ?>");
            jQuery('#backBtn').click(function (e) {
                window.history.go(-1);
                e.preventDefault();
                return false;
            });
        </script>
		<?php
		return false;
	}
	if ( isset( $_GET['run_sources'] ) ) {
		global $wpvr_options;
		
		if ( isset( $_GET['ids'] ) ) {
			$source_ids = explode( ',', $_GET['ids'] );
			$sources    = wpvr_get_sources( array(
				'ids' => $source_ids,
			) );
			$message    = __( 'Could not find any source with the given IDs.', WPVR_LANG );
		} elseif ( isset( $_GET['folders'] ) ) {
			$source_folders = explode( ',', $_GET['folders'] );
			$sources        = wpvr_get_sources( array(
				'folders' => $source_folders,
			) );
			$message        = __( 'Could not find any source with the given folder.', WPVR_LANG );
		} else {
			echo "Invalid Testing Params";
			
			return false;
		}
		//
		// global $wpvr_imported;
		// d( $wpvr_imported );
		// d( get_option( 'wpvr_imported' ) );
		
		
		?>
		<?php if ( count( $sources ) != 0 ) { ?>
			<?php if ( $wpvr_options['enableAsync'] ) { ?>
				<?php $async = wpvr_async_run_sources( $sources, false, true ); ?>
			<?php } else { ?>
				<?php $return = wpvr_run_sources( $sources ); ?>
			<?php } ?>
		<?php } else { ?>
            <div class="wpvr_manage_noResults">
                <i class="fa fa-frown-o"></i><br/>
				<?php echo $message; ?>
            </div>
		<?php } ?>
		
		<?php
		return false;
	}
	if ( isset( $_GET['test_sources'] ) ) {
		global $wpvr_imported;
		// d( $wpvr_imported );
		if ( isset( $_GET['ids'] ) ) {
			$source_ids = explode( ',', $_GET['ids'] );
			$sources    = wpvr_get_sources( array(
				'ids' => $source_ids,
			) );
			$message    = __( 'Could not find any source with the given IDs.', WPVR_LANG );
		} elseif ( isset( $_GET['folders'] ) ) {
			$source_folders = explode( ',', $_GET['folders'] );
			$sources        = wpvr_get_sources( array(
				'folders' => $source_folders,
			) );
			$message        = __( 'Could not find any source with the given folder.', WPVR_LANG );
		} else {
			echo "Invalid Testing Params";
			
			return false;
		}
		
		// d( $sources );
		// return false;
		//$sources = array();
		
		
		?>

        <div class="wrap wpvr_wrap" style="display:none;">

            <h2 class="wpvr_title">
				<?php wpvr_show_logo(); ?>
                <i class="wpvr_title_icon fa fa-eye"></i>
				<?php echo __( 'Testing Sources', WPVR_LANG ); ?>
            </h2>
	
	        <?php do_action( 'wpvr_print_before_test_sources' , $sources ); ?>
            <?php //d( $sources ); ?>
            <div>
				<?php if ( count( $sources ) != 0 ) { ?>
					<?php wpvr_test_sources( $sources ); ?>
				<?php } else { ?>
                    <div class="wpvr_manage_noResults">
                        <i class="fa fa-frown-o"></i><br/>
						<?php echo $message; ?>
                    </div>
				<?php } ?>
            </div>
	
	        <?php do_action( 'wpvr_print_after_test_sources' , $sources ); ?>


        </div>
		<?php
		return false;
	}
	
	
	if ( isset( $_GET['set_api_token'] ) ) {
		if (
			! isset( $_GET['service'] )
			|| ! isset( $_GET['access_token'] )
		
		) {
			echo "invlaid get parameters. EXIT.";
			die();
		}
		$token = array(
			'access_token'  => $_GET['access_token'],
			'refresh_token' => $_GET['refresh_token'],
		);
		
		$tokens = get_option( 'wpvr_tokens' );
		
		$tokens[ $_GET['service'] ] = $token;
		update_option( 'wpvr_tokens', $tokens );
		
		?>
        Closing ...
        <script> window.close(); </script><?php
		
		return false;
	}
	
	/* SHOW DASHBOARD if no action requested */
	include( WPVR_DASH_PATH );