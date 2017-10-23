<?php
	
	/* Load JS scripts(minified or normal) in admin area only */
	add_action( 'admin_head', 'wpvr_load_scripts' );
	function wpvr_load_scripts() {
		global $wpvr_options;
		if ( WPVR_DEV_MODE === false && WPVR_USE_MIN_JS === true ) {
			$js_functions_file = WPVR_URL . 'assets/js/wpvr.functions.min.js';
		} else {
			$js_functions_file = WPVR_URL . 'assets/js/wpvr.functions.js';
		}
		//wpvr_globals.ajax_url
		$js_globals_array  = array(
			'functions_js' => $js_functions_file,
			'api_auth_url' => WPVR_AUTH_URL,
			'wpvr_js'      => WPVR_JS,
			'ajax_url'     => admin_url( 'admin-ajax.php' ),
			'locale'       => get_locale(),
		
		);
		$js_localize_array = array(
			'add_to_unwanted'      => __( 'Add to Unwanted', WPVR_LANG ),
			'add_to_unwanted_msg'  => __( 'Choose whether to add the selected videos to the source unwanted list or to the global unwanted list.', WPVR_LANG ),
			'source_unwanted'      => __( 'Source Unwanted', WPVR_LANG ),
			'global_unwanted'      => __( 'Global Unwanted', WPVR_LANG ),
			'want_remove_unwanted' => __( 'Do you really want to remove the selected items from Unwanted?', WPVR_LANG ),
			'want_remove_deferred' => __( 'Do you really want to remove the selected items from Deferred?', WPVR_LANG ),
			
			
			'existing_videos_updated'              => __( 'Existing videos have been updated.', WPVR_LANG ),
			'close_wizard'                         => __( 'Close this wizard', WPVR_LANG ),
			'confirm_import_sample_sources'        => __( 'Do you really want to import demo sources ?', WPVR_LANG ),
			'save_source_first'                    => __( 'Your source has changed. Please save it before testing it.', WPVR_LANG ),
			'save_source'                          => '<i class="fa fa-save"></i> ' . __( 'Save Source', WPVR_LANG ),
			'group_info'                           => __( 'Grouped Testing Info', WPVR_LANG ),
			'add_to_unwanted'                      => __( 'Add to Unwanted', WPVR_LANG ),
			'remove_from_unwanted'                 => __( 'Remove from Unwanted', WPVR_LANG ),
			'license_cancelled'                    => __( 'Activation cancelled.', WPVR_LANG ) . ' <br/>' .
			                                          __( 'You can now use your purchase code on your new domain.', WPVR_LANG ) . '<br/>',
			'license_reset'                        => __( 'License reset.', WPVR_LANG ),
			'activation_cancel_confirm'            => __( 'Do you really want to cancel your activation ?', WPVR_LANG ),
			'licence_reset_confirm'                => __( 'Do you really want to reset this addon license ?', WPVR_LANG ),
			'action_done'                          => __( 'Action done successfully.', WPVR_LANG ),
			'select_preset'                        => __( 'Please select a dataFiller Preset.', WPVR_LANG ),
			'correct_entry'                        => __( 'Please enter both Data to Add and the custom field name where to add.', WPVR_LANG ),
			'confirm_add_from_preset'              => __( 'Do you really want to add all this preset fillers ?', WPVR_LANG ),
			'fillers_deleted'                      => __( 'All the data fillers have been deleted successfully.', WPVR_LANG ),
			'confirm_delete_fillers'               => __( 'Do you really want to delete all the data fillers ?', WPVR_LANG ),
			'confirm_run_sources'                  => __( 'Do you really want to run this source ?', WPVR_LANG ),
			'confirm_merge_items'                  => __( 'Do you really want to merge the selected items ?', WPVR_LANG ),
			'confirm_merge_all_items'              => __( 'Do you really want to merge all the duplicates ? This make take some time.', WPVR_LANG ),
			'confirm_merge_dups'                   => __( 'Do you really want to merge those duplicates ?', WPVR_LANG ),
			'is_now_connected'                     => __( 'is now connected !', WPVR_LANG ),
			'confirm_cancel_access'                => __( 'Do you really want to cancel this access ?', WPVR_LANG ),
			'import_videos'                        => __( 'Import Videos', WPVR_LANG ),
			'wp_video_robot'                       => __( 'WP Video Robot', WPVR_LANG ),
			'source_with_no_name'                  => __( 'Do you really want to add this source without a name.', WPVR_LANG ),
			'source_with_no_type'                  => __( 'Please choose a source type to continue.', WPVR_LANG ),
			'source_with_big_wanted'               => __( 'Wanted Videos are limited to', WPVR_LANG ) . ' : ' . WPVR_MAX_WANTED_VIDEOS,
			'video_preview'                        => __( 'Video Preview', WPVR_LANG ),
			'work_completed'                       => __( 'Work Completed !', WPVR_LANG ),
			'videos_unanted_successfully'          => __( 'videos added to unwanted successfuly', WPVR_LANG ),
			'videos_source_unwanted_successfully'          => __( 'videos added to this source unwanted list successfuly', WPVR_LANG ),
			'videos_global_unwanted_successfully'          => __( 'videos added to global unwanted list successfuly', WPVR_LANG ),
			'videos_added_successfully'            => __( 'videos added successfuly', WPVR_LANG ),
			'videos_added_successfully_additional' => apply_filters( 'wpvr_extend_import_success_message', '' ),
			'cancel_anyway'                        => ' <i class="fa fa-remove"></i> ' . __( 'Cancel anyway', WPVR_LANG ),
			'back_to_work'                         => __( 'Continue the work in progress', WPVR_LANG ),
			'reset_yes'                            => ' <i class="fa fa-check"></i> ' . __( 'Confirm Reset', WPVR_LANG ),
			'reset_no'                             => ' <i class="fa fa-remove"></i> ' . __( 'Cancel', WPVR_LANG ),
			'yes'                                  => ' <i class="fa fa-check"></i> ' . __( 'Yes', WPVR_LANG ),
			'no'                                   => ' <i class="fa fa-remove"></i> ' . __( 'No', WPVR_LANG ),
			'import_btn'                           => ' <i class="fa fa-download"></i> ' . __( 'Import', WPVR_LANG ),
			'are_you_sure'                         => __( 'Are you sure ?', WPVR_LANG ),
			'really_want_cancel'                   => __( 'Do you really want to cancel the work in progress ?', WPVR_LANG ),
			'continue_only'                        => ' <i class="fa fa-check"></i> ' . __( 'Continue', WPVR_LANG ),
			'continue_button'                      => ' <i class="fa fa-play"></i> ' . __( 'Continue', WPVR_LANG ),
			'cancel_button'                        => ' <i class="fa fa-remove"></i> ' . __( 'Cancel', WPVR_LANG ),
			'ok_button'                            => ' <i class="fa fa-check"></i> ' . __( 'OK', WPVR_LANG ),
			'export_button'                        => ' <i class="fa fa-download"></i> ' . __( 'Export', WPVR_LANG ),
			'dismiss_button'                       => ' <i class="fa fa-close"></i> ' . __( 'DISMISS', WPVR_LANG ),
			'close_button'                         => ' <i class="fa fa-close"></i> ' . __( 'Close', WPVR_LANG ),
			'pause_button'                         => ' <i class="fa fa-pause"></i> ' . __( 'Pause', WPVR_LANG ),
			'options_set_to_default'               => __( 'WPVR Options set to default !', WPVR_LANG ),
			'options_reset_confirm'                => __( 'Do you really want to reset options to default ?', WPVR_LANG ),
			'options_saved'                        => __( 'Options successfully saved', WPVR_LANG ),
			'options_saved_icon'                   => '<div class="wpvr_saved_options_icon"><i class="fa fa-check-circle"></i></div>',
			'addon_options_saved'                  => __( 'Addon options successfully saved', WPVR_LANG ),
			'licences_saved'                       => __( 'Licences successfully saved', WPVR_LANG ),
			'options_reset_confirm'                => __( 'Do you really want to reset options to default ?', WPVR_LANG ),
			'adding_selected_videos'               => __( ' Adding selected videos', WPVR_LANG ),
			'adding_selected_videos_unwanted'               => __( ' Adding selected videos to unwanted', WPVR_LANG ),
			'work_in_progress'                     => __( 'Work in progress', WPVR_LANG ),
			'loading'                              => __( 'Loading', WPVR_LANG ) . ' <i class="wpvr_spinning_icon fa fa-cog fa-spin"></i> ',
			'loadingCenter'                        => '<div class="wpvr_loading_center"><br /><br />' . __( 'Please Wait ...', WPVR_LANG )
			                                          . ' <br/><br/><i class="wpvr_spinning_icon fa fa-cog fa-spin"></i></div>',
			'please_wait'                          => __( 'Please wait', WPVR_LANG ),
			'confirm_clear_logs'                   => __( 'Do you really want to clear all the logs?', WPVR_LANG ),
			'system_infos'                         => __( 'System Information', WPVR_LANG ),
			'item'                                 => __( 'item', WPVR_LANG ),
			'items'                                => __( 'items', WPVR_LANG ),
			'confirm_delete_permanently'           => __( 'Do you really want to delete permanently the selected items ?', WPVR_LANG ),
			'want_remove_items'                    => __( 'Do you really want to remove permanently the selected items ?', WPVR_LANG ),
			'videos_removed_successfully'          => __( 'video(s) removed from deferred', WPVR_LANG ),
			'show_details'                         => __( 'Show Details', WPVR_LANG ),
			'details'                              => __( 'Details', WPVR_LANG ),
			'showing'                              => __( 'Showing', WPVR_LANG ),
			'on'                                   => __( 'on', WPVR_LANG ),
			'page'                                 => __( 'Page', WPVR_LANG ),
			'seconds'                              => __( 'seconds', WPVR_LANG ),
			'videos_processed_successfully'        => __( 'videos processed successfully', WPVR_LANG ),
			'duplicates_removed_in'                => __( 'duplicates removed in', WPVR_LANG ),
			'errorJSON'                            => __( 'Headers already sent by some other scripts. Error thrown :', WPVR_LANG ),
			'error'                                => __( 'Error', WPVR_LANG ),
			'confirm_run_fillers'                  => __( 'Run fillers on existant videos ? This may take some time.', WPVR_LANG ),
			'confirm_remove_filler'                => __( 'Do you really want to remove this filler ?', WPVR_LANG ),
		);
		
		wp_enqueue_script( 'jquery' );
		
		if ( WPVR_DEV_MODE === false && WPVR_USE_MIN_JS === true ) {
			$js_file = WPVR_URL . 'assets/js/wpvr.scripts.min.js';
			
			wp_register_script( 'wpvr_scripts', $js_file . '?version=' . WPVR_VERSION, array( 'jquery' ) );
			wp_localize_script( 'wpvr_scripts', 'wpvr_localize', $js_localize_array );
			wp_localize_script( 'wpvr_scripts', 'wpvr_globals', $js_globals_array );
			wp_localize_script( 'wpvr_scripts', 'wpvr_options', $wpvr_options );
			wp_enqueue_script( 'wpvr_scripts' );
			
		} else {
			$js_file = WPVR_URL . 'assets/js/wpvr.scripts.js';
			
			wp_register_script( 'wpvr_scripts_assets', WPVR_URL . 'assets/js/wpvr.assets.min.js' );
			wp_enqueue_script( 'wpvr_scripts_assets' );
			
			wp_register_script( 'wpvr_scripts', $js_file . '?version=' . WPVR_VERSION );
			wp_localize_script( 'wpvr_scripts', 'wpvr_localize', $js_localize_array );
			wp_localize_script( 'wpvr_scripts', 'wpvr_globals', $js_globals_array );
			wp_localize_script( 'wpvr_scripts', 'wpvr_options', $wpvr_options );
			wp_enqueue_script( 'wpvr_scripts' );
		}
	}
	
	/* Load CSS files (minified or normal version) in admin area only */
	add_action( 'admin_head', 'wpvr_load_styles' );
	function wpvr_load_styles() {
		
		if ( WPVR_USE_LOCAL_FONTAWESOME ) {
			wp_register_style( 'wpvr_icons', WPVR_URL . 'assets/css/font-awesome.min.css' );
			wp_enqueue_style( 'wpvr_icons' );
		} else {
			wp_register_style( 'wpvr_icons', WPVR_FONTAWESOME_CSS_URL );
			wp_enqueue_style( 'wpvr_icons' );
		}
		
		if ( WPVR_DEV_MODE === false && WPVR_USE_MIN_CSS === true ) {
			
			$css_file = WPVR_URL . 'assets/css/wpvr.styles.min.css';
			wp_register_style( 'wpvr_styles', $css_file . '?version=' . WPVR_VERSION );
			wp_enqueue_style( 'wpvr_styles' );
			
		} else {
			
			$css_file = WPVR_URL . 'assets/css/wpvr.styles.css';
			wp_register_style( 'wpvr_assets_styles', WPVR_URL . 'assets/css/wpvr.assets.min.css' );
			wp_enqueue_style( 'wpvr_assets_styles' );
			
			wp_register_style( 'wpvr_styles', $css_file . '?version=' . WPVR_VERSION );
			wp_enqueue_style( 'wpvr_styles' );
			
		}
		
		
		if ( is_rtl() ) {
			wp_enqueue_style( 'wpvr_styles_rtl', WPVR_URL . 'assets/css/wpvr.styles.rtl.css' );
		}
	}
	
	/* Load CSS fix for embeding youtube player */
	add_action( 'wp_head', 'wpvr_load_services_css_styles', 120 );
	add_action( 'admin_head', 'wpvr_load_services_css_styles', 120 );
	function wpvr_load_services_css_styles() {
		global $wpvr_vs;
		$css = '';
		$css .= '.is_small.wpvr_external_thumbnail{margin:-33px 0 -41px !important;}';
		$css .= '#adminmenu .menu-icon-video div.wp-menu-image:before {content: "\f126";}';
		$css .= '#adminmenu .menu-icon-source div.wp-menu-image:before {content: "\f179";}';
		$css .= WPVR_VIDEO_TYPE == 'post' ? '#menu-posts.menu-top-first {display:none;}' : '';
		
		if ( count( $wpvr_vs ) != 0 ) {
			foreach ( (array) $wpvr_vs as $vs ) {
				if ( WPVR_DEV_MODE === true ) {
					$css .= "/*WPVR DEV MODE */\n";
					$css .= "#adminmenuback{display:none;}\n";
					$css .= "/*WPVR DEV MODE */\n";
				}
				$css .= "/*WPVR VIDEO SERVICE STYLES ( " . $vs['label'] . " ) */\n";
				//$css .= "/* START */\n";
				// $css .= trim( preg_replace( '/\t+/', '', $vs['get_styles']() ) );
				$css .= trim( preg_replace( '/\t+/', '', wpvr_render_vs_styles( $vs ) ) );
				//$css .= "<!-- END -->\n";
				$css .= "/* WPVR VIDEO SERVICE STYLES ( " . $vs['label'] . " ) */\n\n";
			}
		}
		echo "<style>\n $css\n </style>\n";
	}
	
	/* Load CSS fix for embeding youtube player */
	add_action( 'wp_head', 'wpvr_load_dynamic_css', 100 );
	add_action( 'admin_head', 'wpvr_load_dynamic_css', 100 );
	function wpvr_load_dynamic_css() {
		global $wpvr_status, $wpvr_services;
		
		$css = '';
		$css .= '.wpvr_embed .fluid-width-video-wrapper{ padding-top:56% !important; }';
		$css .= '.ad-container.ad-container-single-media-element-annotations.ad-overlay{ background:red !important; }';
		/*
		$css .= '.wpvr_button{ background : '.WPVR_BUTTON_BGCOLOR.' !important; color : '.WPVR_BUTTON_COLOR.' !important; }';
		$css .= '.wpvr_button:hover{ background : '.WPVR_BUTTON_HOVER_BGCOLOR.' !important; color : '.WPVR_BUTTON_HOVER_COLOR.' !important; }';
		*/
		foreach ( (array) $wpvr_status as $value => $data ) {
			$css .= '.wpvr_video_status.' . $value . '{ background:' . $data['color'] . ' ;} ';
		}
		?>
        <style><?php echo $css; ?></style><?php
	}
	
	/* Load CSS fix for embeding youtube player */
	add_action( 'wp_footer', 'wpvr_load_css_fix' );
	function wpvr_load_css_fix() {
		global $wpvr_status, $wpvr_services;
		
		$css = '';
		
		foreach ( (array) $wpvr_status as $value => $data ) {
			$css .= '.wpvr_video_status.' . $value . '{ background-color:red;}';
		}
		
		
		?>
        <style>
            <?php echo $css; ?>
            .wpvr_embed {
                position: relative !important;
                padding-bottom: 56.25% !important;
                padding-top: 30px !important;
                height: 0 !important;
                overflow: hidden !important;
            }

            .wpvr_embed.wpvr_vst_embed {
                padding-top: 0px !important;
            }

            .wpvr_embed iframe, .wpvr_embed object, .wpvr_embed embed {
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                height: 100% !important;
            }
        </style>
		<?php
	}
	
	add_filter( 'wp_head', 'wpvr_watermark', 10000 );
	function wpvr_watermark() {
		$act = wpvr_get_activation( 'wpvr' );
		//_d( $act );
		if ( $act['act_status'] == 1 ) {
			$licensed = " - License activated by " . $act['buy_user'] . ".";
		} else {
			$licensed = " - Not Activated. ";
		}
		echo "\n <!-- ##WPVR : WP Video Robot version " . $act["act_version"] . " " . $licensed . "--> \n";
	}