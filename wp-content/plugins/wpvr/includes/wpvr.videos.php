<?php
	
	
	/* Defining videos as wpvr_pages */
	add_action( 'admin_notices', 'wpvr_videos_define_wpvr_pages' );
	function wpvr_videos_define_wpvr_pages() {
		$type = 'post';
		if ( isset( $_GET['post_type'] ) ) {
			$type = $_GET['post_type'];
		}
		if ( WPVR_VIDEO_TYPE == $type ) {
			global $wpvr_pages;
			$wpvr_pages = true;
		}
	}
	
	/* Define custom video type */
	add_action( 'init', 'wpvr_define_video_post_type', 0 );
	function wpvr_define_video_post_type() {
		global $wpvr_options, $wpvr_dynamics;
		
		if ( apply_filters( 'wpvr_escape_defining_video_type', false ) === true ) {
			//wpvr_ooo('SKIP DEFINING VIDEOS');
			return false;
		}
		$videos_support = array( 'title', 'editor', 'author', 'thumbnail' );
		
		$videos_support[] = 'custom-fields';
		
		
		if ( $wpvr_options['enableVideoComments'] === true ) {
			$videos_support[] = 'comments';
		}
		
		if ( WPVR_ENABLE_POST_FORMATS ) {
			$videos_support[] = 'post-formats';
		}
		
		$videos_support = apply_filters( 'wpvr_extend_videos_support', $videos_support );
		
		$labels = array(
			'name'               => _x( 'Videos', 'Post Type General Name', WPVR_LANG ),
			'singular_name'      => _x( 'Video', 'Post Type Singular Name', WPVR_LANG ),
			'menu_name'          => __( 'Videos', WPVR_LANG ),
			'parent_item_colon'  => __( 'Parent Item:', WPVR_LANG ),
			'all_items'          => __( 'All Videos', WPVR_LANG ),
			'view_item'          => __( 'View Video', WPVR_LANG ),
			'add_new_item'       => __( 'Add New Video', WPVR_LANG ),
			'add_new'            => __( 'Add New', WPVR_LANG ),
			'edit_item'          => __( 'Edit Video', WPVR_LANG ),
			'update_item'        => __( 'Update Video', WPVR_LANG ),
			'search_items'       => __( 'Search Video', WPVR_LANG ),
			'not_found'          => __( 'Not found', WPVR_LANG ),
			'not_found_in_trash' => __( 'Not found in Trash', WPVR_LANG ),
		);
		$args   = array(
			'label'               => __( 'video', WPVR_LANG ),
			'description'         => __( 'Video', WPVR_LANG ),
			'labels'              => $labels,
			'rewrite'             => false,
			'supports'            => $videos_support,
			'taxonomies'          => array( 'category', 'post_tag' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-format-video',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
		);
		register_post_type( WPVR_VIDEO_TYPE, $args );
		
		
		// wpvr_ooo( $videos_support );
	}
	
	
	/*Init Videos Editing metaboxes */
	add_action( 'init', 'wpvr_video_init_metaboxes', 9999 );
	function wpvr_video_init_metaboxes() {
		if ( ! class_exists( 'wpvr_cmb_Meta_Box' ) ) {
			require_once( WPVR_PATH . '/assets/metabox/init.php' );
		}
	}
	
	/* Define Video Metaboxes */
	add_filter( 'wpvr_cmb_meta_boxes', 'wpvr_video_metaboxes' );
	function wpvr_video_metaboxes( $meta_boxes ) {
		global $wpvr_options;
		$prefix = 'wpvr_video_';
		
		if ( isset( $_GET['post'] ) ) {
			if ( is_array( $_GET['post'] ) ) {
				return $meta_boxes;
			} else {
				$post_id = $_GET['post'];
			}
		} elseif ( isset( $_POST['post_ID'] ) ) {
			$post_id = $_POST['post_ID'];
		} else {
			$post_id = "";
		}
		
		$shortcode_msg  = __( 'Embed this video in any post or page, simply by including this shortcode.', WPVR_LANG );
		$shortcode_code = '[wpvr id=' . $post_id . ']';
		
		$unwanted_button = wpvr_render_add_unwanted_button( $post_id );
		$embed_button
		                 = '
			<button
                dialog_title = "' . __( 'WPVR - Embed this video', WPVR_LANG ) . '"
                msg = "' . $shortcode_msg . '"
                code = "' . $shortcode_code . '"
                class="wpvr_black_button wpvr_half_width wpvr_button wpvr_embed_video_btn wpvr_source_actions_btn"
            >
                <i class="fa fa-code" style="margin-right:5px;"></i>
                ' . __( 'Embed', WPVR_LANG ) . '
            </button>
		';
		
		
		$mb_fields   = array();
		$mb_fields[] = array(
			'name'      => __( 'Plugin Version', WPVR_LANG ),
			'default'   => WPVR_VERSION,
			'id'        => $prefix . 'plugin_version',
			'type'      => 'text_small',
			'wpvrStyle' => 'display:none;',
		);
		
		if ( $post_id != '' && wpvr_is_imported_video( $post_id ) ) {
			
			
			$video_id       = get_post_meta( $post_id, 'wpvr_video_id', true );
			$video_duration = wpvr_get_duration( $post_id );
			if ( $video_id == '' ) {
				$video_id_short = '#undefined#';
			} elseif ( strlen( $video_id ) > 18 ) {
				$video_id_short = substr( $video_id, 0, 15 ) . '...';
			} else {
				$video_id_short = $video_id;
			}
			$video_service = get_post_meta( $post_id, 'wpvr_video_service', true );
			$preview_button
			               = '
				    <button
						post_id = "' . $post_id . '"
						video_id = "' . $video_id . '"
						service = "' . $video_service . '"
						class="wpvr_black_button wpvr_half_width wpvr_button wpvr_video_view wpvr_source_actions_btn"
					>
						<i class="fa fa-eye" style="margin-right:5px;"></i>
						' . __( 'Preview', WPVR_LANG ) . '
					</button>
			';
			
			$view_button
				= '
				    <button
						href= "' . get_post_permalink( $post_id ) . '"
						target= "_blank"
						post_id = "' . $post_id . '"
						video_id = "' . $video_id . '"
						service = "' . $video_service . '"
						class="wpvr_black_button wpvr_half_width wpvr_button wpvr_video_view_ext wpvr_source_actions_btn"
					>
						<i class="fa fa-link" style="margin-right:5px;"></i>
						' . __( 'View', WPVR_LANG ) . '
					</button>
			';
			
			$save_button
				= '
				<button
						post_id = "' . $post_id . '"
						video_id = "' . $video_id . '"
						service = "' . $video_service . '"
						class=" wpvr_half_width wpvr_button wpvr_video_update wpvr_source_actions_btn"
					>
                    <i class="fa fa-save" style="margin-right:5px;"></i>
                    ' . __( 'Update', WPVR_LANG ) . '
                </button>
			';
			
			$mb_fields[] = array(
				'name'      => '',
				'desc'      => '',
				'id'        => $prefix . 'html',
				'html'      => '<div class="wpvr_no_actions">' . __( 'Loading ...', WPVR_LANG ) . '</div>',
				'type'      => 'show_html',
				'wpvrClass' => 'wpvr_metabox_html wpvr_hide_when_loaded',
			);
			
			$post_types = wpvr_get_available_post_types();
			
			if ( get_post_meta( $post_id, 'wpvr_video_using_external_thumbnail', true ) != '' ) {
				$thumbnail_info = '<div class="wpvr_video_info_type thumb">' .
				                  '<i class="fa fa-globe"></i>' .
				                  __( 'Using External Thumbnail', WPVR_LANG ) . ' ' .
				                  '</div>';
			} else {
				$thumbnail_info = '';
			}
			
			
			$mb_fields[] = array(
				'name'      => '',
				'desc'      => '',
				'id'        => $prefix . 'html',
				'html'      => '<div class="wpvr_video_info_type">' .
				               '<i class="fa fa-circle"></i>' .
				               __( 'Imported as', WPVR_LANG ) . ' ' .
				               $post_types[ WPVR_VIDEO_TYPE ] .
				               '</div>' .
				               '<div class="wpvr_clearfix"></div>' .
				               '<div class="wpvr_video_single_info">' .
				               '<div class="wpvr_service_icon wpvr_video_info_service ' . $video_service . '">' . $video_service . '</div>' .
				               '<div class="wpvr_video_info_id " title="' . $video_id . '">' . $video_id_short . '</div>' .
				               '<div class="wpvr_video_info_duration ">' . $video_duration . '</div>' .
				               '<div class="wpvr_clearfix"></div>' . $thumbnail_info,
				'</div>',
				'type'      => 'show_html',
				'wpvrClass' => 'wpvr_metabox_html wpvr_show_when_loaded',
				'wpvrStyle' => 'display:none;',
			);
			
			$mb_fields[] = array(
				'name'      => '',
				'desc'      => '',
				'id'        => $prefix . 'html',
				'html'      => '<button 
									class="wpvr_button wpvr_full_width wpvr_import_wizzard"
									video_service = "' . $video_service . '"
									video_id = "' . $video_id . '"
								>
									<i class="fa fa-magic"></i>
									' . __( 'Video Wizard', WPVR_LANG ) . '
								</button><br/>
								<p style="text-align:center;">
									<a href="#" class="wpvr_toggle_advanced_adding">
										<span class="advanced">' . __( 'Hide advanced mode', WPVR_LANG ) . '</span>
										<span class="not_advanced">' . __( 'Show advanced mode', WPVR_LANG ) . '</span>
									</a>
								</p><br/>
								<div class="wpvr_wizzard_overlay"style="display:none;"><i class="fa fa-refresh fa-spin"></i></div>',
				'type'      => 'show_html',
				'wpvrClass' => 'wpvr_metabox_html wpvr_show_when_loaded',
				'wpvrStyle' => 'display:none;',
			);
			
			$wizard_button = '
			    <button 
                    class="wpvr_button wpvr_full_width wpvr_import_wizzard wpvr_import_wizzard_top pull-left wpvr_source_actions_btn"
                    video_service = "' . $video_service . '"
                    video_id = "' . $video_id . '"
                >
                    <i class="fa fa-magic"></i>
                    ' . __( 'Video Wizard', WPVR_LANG ) . '
                </button>
			';
			
			$mb_fields[] = array(
				'name'      => '',
				'desc'      => '',
				'id'        => $prefix . 'html',
				'html'      => '<div class="wpvr_action_buttons_wrap">' .
				               $unwanted_button .
				               $preview_button .
				               $view_button .
				               $embed_button .
				               $save_button .
				               $wizard_button .
				               '</div>',
				'type'      => 'show_html',
				'wpvrClass' => 'wpvr_metabox_html wpvr_show_when_loaded',
				'wpvrStyle' => 'display:none;',
				'before'    => '<div class="wpvr_fixed_topbar"></div>',
			);
			
			// $mb_fields[] = array(
			// 	'name'      => '',
			// 	'desc'      => '',
			// 	'id'        => $prefix . 'html',
			// 	'html'      => $save_button,
			// 	'type'      => 'show_html',
			// 	'wpvrClass' => 'wpvr_metabox_html wpvr_action_btns wpvr_show_when_loaded',
			// 	'before'    => '<div class="wpvr_fixed_topbar"></div>',
			// 	'wpvrStyle' => 'display:none;',
			// );
			
			// $mb_fields[] = array(
			// 	'name'      => '',
			// 	'desc'      => '',
			// 	'id'        => $prefix . 'html',
			// 	'html'      => $preview_button,
			// 	'type'      => 'show_html',
			// 	'wpvrClass' => 'wpvr_metabox_html wpvr_action_btns wpvr_show_when_loaded',
			// 	'before'    => '<div class="wpvr_fixed_topbar"></div>',
			// 	'wpvrStyle' => 'display:none;',
			// );
			//
			// $mb_fields[] = array(
			// 	'name'      => '',
			// 	'desc'      => '',
			// 	'id'        => $prefix . 'html',
			// 	'html'      => $embed_button,
			// 	'type'      => 'show_html',
			// 	'wpvrClass' => 'wpvr_metabox_html wpvr_action_btns wpvr_show_when_loaded',
			// 	'wpvrStyle' => 'display:none;',
			// );
			//
			// $mb_fields[] = array(
			// 	'name'      => '',
			// 	'desc'      => '',
			// 	'id'        => $prefix . 'html',
			// 	'html'      => $unwanted_button,
			// 	'type'      => 'show_html',
			// 	'wpvrClass' => 'wpvr_metabox_html wpvr_action_btns wpvr_show_when_loaded',
			// 	'wpvrStyle' => 'display:none;',
			// );
			
		} else {
			$mb_fields[] = array(
				'name'      => '',
				'desc'      => '',
				'id'        => $prefix . 'html',
				'html'      => '<div class="wpvr_no_actions">' . __( 'Loading ...', WPVR_LANG ) . '</div>',
				'type'      => 'show_html',
				'wpvrClass' => 'wpvr_metabox_html wpvr_hide_when_loaded',
			);
			
			$mb_fields[] = array(
				'name'      => '',
				'desc'      => '',
				'id'        => $prefix . 'html',
				'html'      => '<button class="wpvr_button wpvr_full_width wpvr_import_wizzard" video_service="" video_id="">
									<i class="fa fa-magic"></i>
									' . __( 'Video Wizard', WPVR_LANG ) . '
								</button><br/>
								<p style="text-align:center;">
									<a href="#" class="wpvr_toggle_advanced_adding">
										<span class="advanced">' . __( 'Hide advanced mode', WPVR_LANG ) . '</span>
										<span class="not_advanced">' . __( 'Show advanced mode', WPVR_LANG ) . '</span>
									</a>
								</p>
								<div class="wpvr_wizzard_overlay"style="display:none;"><i class="fa fa-refresh fa-spin"></i></div>',
				'type'      => 'show_html',
				'wpvrClass' => 'wpvr_metabox_html wpvr_show_when_loaded',
				'wpvrStyle' => 'display:none;',
			);
			
		}
		
		$mb_fields = apply_filters( 'wpvr_extend_video_actions_fields', $mb_fields );
		
		$meta_boxes[] = array(
			'id'         => 'wpvr_video_actions_metabox',
			'title'      => __( 'WP Video Robot', WPVR_LANG ),
			'pages'      => array( WPVR_VIDEO_TYPE ), // post type
			'context'    => 'side',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			'fields'     => $mb_fields,
		);
		if ( $wpvr_options['enableManualAdding'] ) {
			
			/* Extending Video Services Options */
			$video_service_options = array();
			$video_service_options = apply_filters( 'wpvr_extend_video_services_options', $video_service_options );
			
			/* Extending Video Services Fields  */
			$video_fields = array();
			$video_fields = apply_filters( 'wpvr_extend_video_fields', $video_fields, $prefix );
			//d( $video_fields );
			$video_services = array(
				array(
					'name'      => __( 'Video Service', WPVR_LANG ),
					'desc'      => '',
					'id'        => $prefix . 'service',
					'type'      => 'radio_inline',
					'options'   => $video_service_options,
					'wpvrClass' => 'videoService',
					//'wpvrStyle' => 'display:none;',
				),
			);
			if ( $post_id != '' ) {
				$import_button_label = __( 'Re-Import Video', WPVR_LANG );
			} else {
				$import_button_label = __( 'Import Video', WPVR_LANG );
			}
			
			$grabButton
				= '
				<div class="wpvr_manual_adding_btns" style="display:none;">
					<button class="pull-right wpvr_button wpvr_green_button wpvr_manual_import_trigger">
						<i class="fa fa-download"></i>
						' . $import_button_label . '
					</button>

					<button href="#" class="wpvr_black_button wpvr_button pull-right wpvr_toggle_grabbing_button" state="off">
						<i class="fa fa-check-square-o"></i>
						' . __( 'Toggle All', WPVR_LANG ) . '
					</button>
				</div>
			';
			
			
			$video_choices = array(
				array(
					'name'        => __( 'Enable Grabbing', WPVR_LANG ),
					'desc'        => '',
					'id'          => $prefix . 'enableManualAdding',
					'type'        => 'select',
					'options'     => array(
						'on'  => __( 'YES', WPVR_LANG ),
						'off' => __( 'NO', WPVR_LANG ),
					),
					'default'     => 'off',
					'description' => __( 'Enable this to get the video data', WPVR_LANG ) . '. <br/>' . $grabButton,
					'wpvrClass'   => '',
					//'wpvrStyle'   => 'display:none;' ,
				
				),
				array(
					'name'        => __( 'Title', WPVR_LANG ),
					'desc'        => '',
					'id'          => $prefix . 'getTitle',
					'type'        => 'select',
					'options'     => array(
						'on'  => __( 'YES', WPVR_LANG ),
						'off' => __( 'NO', WPVR_LANG ),
					),
					'default'     => 'off',
					'description' => __( 'Grab the video Title', WPVR_LANG ) . '.',
					'wpvrClass'   => 'wpvrManualOptions',
					'wpvrStyle'   => 'display:none;',
				),
				array(
					'name'        => __( 'Thumbnail', WPVR_LANG ),
					'desc'        => '',
					'id'          => $prefix . 'getThumb',
					'type'        => 'select',
					'options'     => array(
						'on'  => __( 'YES', WPVR_LANG ),
						'off' => __( 'NO', WPVR_LANG ),
					),
					'default'     => 'off',
					'description' => __( 'Grab the video Thumbnail', WPVR_LANG ) . '.',
					'wpvrClass'   => 'wpvrManualOptions',
					'wpvrStyle'   => 'display:none;',
				),
				array(
					'name'        => __( 'Description', WPVR_LANG ),
					'desc'        => '',
					'id'          => $prefix . 'getDesc',
					'type'        => 'select',
					'options'     => array(
						'on'  => __( 'YES', WPVR_LANG ),
						'off' => __( 'NO', WPVR_LANG ),
					),
					'default'     => 'off',
					'description' => __( 'Grab the video Description', WPVR_LANG ) . '.',
					'wpvrClass'   => 'wpvrManualOptions',
					'wpvrStyle'   => 'display:none;',
				),
				array(
					'name'        => __( 'Tags', WPVR_LANG ),
					'desc'        => '',
					'id'          => $prefix . 'getTags',
					'type'        => 'select',
					'options'     => array(
						'on'  => __( 'YES', WPVR_LANG ),
						'off' => __( 'NO', WPVR_LANG ),
					),
					'default'     => 'off',
					'description' => __( 'Grab the video tags', WPVR_LANG ) . '.',
					'wpvrClass'   => 'wpvrManualOptions',
					'wpvrStyle'   => 'display:none;',
				),
				array(
					'name'        => __( 'Post Date', WPVR_LANG ),
					'desc'        => '',
					'id'          => $prefix . 'getPostDate',
					'type'        => 'select',
					'options'     => array(
						'on'  => __( 'YES', WPVR_LANG ),
						'off' => __( 'NO', WPVR_LANG ),
					),
					'default'     => 'off',
					'description' => __( 'Grab the video original post date', WPVR_LANG ) . '.',
					'wpvrClass'   => 'wpvrManualOptions',
					'wpvrStyle'   => 'display:none;',
				),
			);
			$video_options = array();
			
			$video_choices = apply_filters( 'wpvr_extend_video_choices', $video_choices, $prefix );
			$video_options = apply_filters( 'wpvr_extend_video_options', $video_options, $prefix );
			
			$video_manual_fields = array_merge(
				$video_services,
				$video_fields,
				$video_choices,
				$video_options
			);
			//d( $video_manual_fields );
			$meta_boxes[] = array(
				'id'         => 'wpvr_video_metabox',
				'title'      => __( 'WP Video Robot - Advanced ', WPVR_LANG ),
				'pages'      => array( WPVR_VIDEO_TYPE ), // post type
				'context'    => 'normal',
				'priority'   => 'low',
				'show_names' => true, // Show field names on the left
				'fields'     => $video_manual_fields,
			);
		}
		global $debug;
		$meta_boxes = apply_filters( 'wpvr_extend_videos_metaboxes', $meta_boxes );
		
		//d( $meta_boxes );//new dBug( $debug);
		return $meta_boxes;
	}
	
	
	add_filter( 'wpvr_cmb_meta_boxes', 'wpvr_video_options_metaboxes' );
	function wpvr_video_options_metaboxes( $meta_boxes ) {
		$prefix               = 'wpvr_video_';
		$video_options_fields = array();
		
		$video_options_fields[] = array(
			'name'        => __( 'AutoEmbed Player', WPVR_LANG ),
			'desc'        => '',
			'id'          => $prefix . 'disableAutoEmbed',
			'type'        => 'select',
			'options'     => array(
				'default' => __( '- Default -', WPVR_LANG ),
				'on'      => __( "Don't embed the plugin player", WPVR_LANG ),
				'off'     => __( "Embed the plugin player", WPVR_LANG ),
			),
			'default'     => 'off',
			'description' => __( "Choose don't embed if you want to use your theme video player.", WPVR_LANG ),
			'wpvrClass'   => 'wpvr_show_when_loaded',
			'wpvrStyle'   => 'display:none;',
		
		);
		
		$video_options_fields[] = array(
			'name'        => __( 'Start Time', WPVR_LANG ),
			'desc'        => '',
			'id'          => $prefix . 'startTime',
			'type'        => 'text_small',
			'default'     => '',
			'description' => '<br/>' . __( 'Define the given number of seconds from the start of the video, when the player begin playing.', WPVR_LANG ) . '<br/>' .
			                 __( 'Works only with Youtube.', WPVR_LANG ) . '',
			'wpvrClass'   => 'wpvr_show_when_loaded',
			'wpvrStyle'   => 'display:none;',
		);
		$video_options_fields[] = array(
			'name'        => __( 'End Time', WPVR_LANG ),
			'desc'        => '',
			'id'          => $prefix . 'endTime',
			'type'        => 'text_small',
			'default'     => '',
			'description' => '<br/>' . __( 'Define the time, measured in seconds from the end of the video, when the player should stop playing.', WPVR_LANG ) . '<br/>' .
			                 __( 'Works only with Youtube.', WPVR_LANG ) . '',
			'wpvrClass'   => 'wpvr_show_when_loaded',
			'wpvrStyle'   => 'display:none;',
		);
		$video_options_fields[] = array(
			'name'        => __( 'Related Videos', WPVR_LANG ),
			'desc'        => '',
			'id'          => $prefix . 'hidePlayerRelated',
			'type'        => 'select',
			'options'     => array(
				'default' => __( '- Default -', WPVR_LANG ) . wpvr_print_default_value( 'hidePlayerRelated',
						__( 'Hide Related Videos', WPVR_LANG ),
						__( 'Show Related Videos', WPVR_LANG )
					),
				'on'      => __( 'Hide Related on Video Pause and End', WPVR_LANG ),
				'off'     => __( 'Show Related on Video Pause and End', WPVR_LANG ),
			),
			'default'     => 'default',
			'description' => __( 'You can define whether to show or hide the related videos inside the player when the video ends.', WPVR_LANG ) . '<br/>' .
			                 __( 'Works only with Youtube.', WPVR_LANG ) . '',
			'wpvrClass'   => 'wpvr_show_when_loaded',
			'wpvrStyle'   => 'display:none;',
		);
		
		$video_options_fields[] = array(
			'name'        => __( 'Player Title', WPVR_LANG ),
			'desc'        => '',
			'id'          => $prefix . 'hidePlayerTitle',
			'type'        => 'select',
			'options'     => array(
				'default' => __( '- Default -', WPVR_LANG ) . wpvr_print_default_value( 'hidePlayerRelated',
						__( 'Hide Player Title', WPVR_LANG ),
						__( 'Show Player Title', WPVR_LANG )
					),
				'on'      => __( 'Hide Player Title', WPVR_LANG ),
				'off'     => __( 'Show Player Title', WPVR_LANG ),
			),
			'default'     => 'default',
			'description' => __( 'You can define whether to show or hide the video title inside the player.', WPVR_LANG ) . '<br/>' .
			                 __( 'Works only with Youtube.', WPVR_LANG ) . '',
			'wpvrClass'   => 'wpvr_show_when_loaded',
			'wpvrStyle'   => 'display:none;',
		);
		
		$video_options_fields[] = array(
			'name'        => __( 'Player Annotations', WPVR_LANG ),
			'desc'        => '',
			'id'          => $prefix . 'hidePlayerAnnotations',
			'type'        => 'select',
			'options'     => array(
				'default' => __( '- Default -', WPVR_LANG ) . wpvr_print_default_value( 'hidePlayerAnnotations',
						__( 'Hide Player Annotations', WPVR_LANG ),
						__( 'Show Player Annotations', WPVR_LANG )
					),
				'on'      => __( 'Hide Player Annotations', WPVR_LANG ),
				'off'     => __( 'Show Player Annotations', WPVR_LANG ),
			),
			'default'     => 'default',
			'description' => __( 'You can define whether to show or hide the video annotations inside the player.', WPVR_LANG ) . '<br/>' .
			                 __( 'Works only with Youtube.', WPVR_LANG ) . '',
			'wpvrClass'   => 'wpvr_show_when_loaded',
			'wpvrStyle'   => 'display:none;',
		);
		
		
		$video_options_fields = apply_filters( 'wpvr_extend_videos_options_fields', $video_options_fields );
		
		$meta_boxes[] = array(
			'id'         => 'wpvr_video_options_metabox',
			'title'      => __( 'WP Video Robot - Video Options ', WPVR_LANG ),
			'pages'      => array( WPVR_VIDEO_TYPE ), // post type
			'context'    => 'normal',
			'priority'   => 'low',
			'show_names' => true, // Show field names on the left
			'fields'     => $video_options_fields,
		);
		
		return $meta_boxes;
		
	}
	
	add_filter( 'wpvr_cmb_meta_boxes', 'wpvr_video_external_thumb_metabox' );
	function wpvr_video_external_thumb_metabox( $meta_boxes ) {
		$prefix = 'wpvr_video_';
		if ( isset( $_GET['post'] ) ) {
			if ( is_array( $_GET['post'] ) ) {
				return $meta_boxes;
			} else {
				$post_id = $_GET['post'];
			}
		} elseif ( isset( $_POST['post_ID'] ) ) {
			$post_id = $_POST['post_ID'];
		} else {
			$post_id = "";
		}
		
		$using_external_thumb = get_post_meta( $post_id, 'wpvr_video_using_external_thumbnail', true );
		if ( $using_external_thumb == '' ) {
			return $meta_boxes;
		}
		$video_external_thumb_fields   = array();
		$video_external_thumb_fields[] = array(
			'name' => '',
			'desc' => '',
			'id'   => $prefix . 'html',
			'html' => '<div class="wpvr_external_thumbnail_admin wpvr_show_when_loaded" style="display:none;"><img src="' . $using_external_thumb . '" /></div>',
			'type' => 'show_html',
			// 'wpvrClass' => 'wpvr_metabox_html wpvr_show_when_loaded',
		);
		
		$video_external_thumb_fields = apply_filters( 'wpvr_extend_videos_options_fields', $video_external_thumb_fields );
		
		$meta_boxes[] = array(
			'id'         => 'wpvr_video_external_thumbnail_metabox',
			'title'      => __( 'WPVR External Thumbnail', WPVR_LANG ),
			'pages'      => array( WPVR_VIDEO_TYPE ), // post type
			'context'    => 'side',
			'priority'   => 'low',
			'show_names' => true, // Show field names on the left
			'fields'     => $video_external_thumb_fields,
		);
		
		return $meta_boxes;
		
	}
	
	
	/* Adding Manually a Video by ID */
	add_filter( 'wp_insert_post_data', 'wpvr_manual_add_function', '99', 2 );
	function wpvr_manual_add_function( $data, $postarr ) {
		global $wpvr_vs, $wpvr_imported;
		
		$post_id = $postarr['ID'];
		
		if (
			! isset( $postarr['wpvr_video_enableManualAdding'] )
			|| $postarr['wpvr_video_enableManualAdding'] != "on"
		) {
			return $data;
		}
		
		if ( isset( $postarr['wpvr_video_service'] ) && $postarr['wpvr_video_service'] != "" ) {
			$video_service = $postarr['wpvr_video_service'];
			$field_name    = 'wpvr_video_' . $wpvr_vs[ $video_service ]['pid'] . 'Id';
			$video_id      = trim( wpvr_retreive_video_id_from_param(
				$postarr[ $field_name ],
				$video_service
			) );
			//$video_id      = $postarr[ $field_name ];
		} else {
			return $data;
		}
		
		
		//wpvr_reset_debug();
		//wpvr_set_debug( $video_id , TRUE );
		//return $data ;
		$video_meta = $wpvr_vs[ $video_service ]['get_single_video_data']( $video_id );
		//wpvr_set_debug( $video_meta , TRUE );
		//return $data ;
		
		if ( $video_meta === false ) {
			return $data;
		}
		
		
		/**************************** PERSO PART ******************************************/
		/*********************************************************************************/
		if ( $video_service == 'perso' ) {
			$old_id        = get_post_meta( $post_id, 'wpvr_video_id', true );
			$data['ID']    = $post_id;
			$video_service = 'perso';
			$video_id      = ( $old_id != '' ) ? $old_id : md5( uniqid( rand(), true ) );
			
			update_post_meta( $post_id, 'wpvr_video_id', $video_id );
			update_post_meta( $post_id, 'wpvr_video_service', $video_service );
			update_post_meta( $post_id, 'wpvr_video_enableManualAdding', 'off' );
			
			//wpvr_set_debug( get_post_meta( $post_id , 'wpvr_video_enableManualAdding' , TRUE ) );
			
			//Datafillers
			wpvr_run_dataFillers( $post_id );
			do_action( 'wpvr_event_run_dataFillers', $post_id );
			
			//WPVR Hooks
			do_action( 'wpvr_event_manually_add_video', $video_meta, $post_id );
			do_action( 'wpvr_event_add_video', $video_meta, $post_id );
			
			wpvr_add_notice( array(
				'title'       => 'WP Video Robot',
				//'class'     => 'updated' , //updated or warning or error
				'content'     => $wpvr_vs[ $video_service ]['msgs']['import_success'],
				'hidable'     => true,
				'is_dialog'   => false,
				'show_once'   => true,
				'single_line' => true,
				'color'       => '#09B189',
				'icon'        => 'fa-thumbs-up',
			) );
			
			$wpvr_imported[ $video_service ][ $video_id ] = $post_id;
			update_option( 'wpvr_imported', $wpvr_imported );
			
			
			return $data;
		}
		/*********************************************************************************/
		/**************************** PERSO PART ******************************************/
		
		$mOptions = array(
			'getTitle'    => true,
			'getDesc'     => true,
			'getThumb'    => true,
			'getTags'     => true,
			'getPostDate' => true,
		);
		
		if ( isset( $postarr['wpvr_video_getThumb'] ) && $postarr['wpvr_video_getThumb'] == 'on' ) {
			$mOptions['getThumb'] = true;
		} else {
			$mOptions['getThumb'] = false;
		}
		
		if ( isset( $postarr['wpvr_video_getTitle'] ) && $postarr['wpvr_video_getTitle'] == 'on' ) {
			$mOptions['getTitle'] = true;
		} else {
			$mOptions['getTitle'] = false;
		}
		
		if ( isset( $postarr['wpvr_video_getDesc'] ) && $postarr['wpvr_video_getDesc'] == 'on' ) {
			$mOptions['getDesc'] = true;
		} else {
			$mOptions['getDesc'] = false;
		}
		
		if ( isset( $postarr['wpvr_video_getTags'] ) && $postarr['wpvr_video_getTags'] == 'on' ) {
			$mOptions['getTags'] = true;
		} else {
			$mOptions['getTags'] = false;
		}
		
		if ( isset( $postarr['wpvr_video_getPostDate'] ) && $postarr['wpvr_video_getPostDate'] == 'on' ) {
			$mOptions['getPostDate'] = true;
		} else {
			$mOptions['getPostDate'] = false;
		}
		
		
		update_post_meta( $post_id, 'wpvr_video_id', $video_meta['id'] );
		update_post_meta( $post_id, 'wpvr_video_duration', $video_meta['duration'] );
		update_post_meta( $post_id, 'wpvr_video_service', $video_meta['service'] );
		
		update_post_meta( $post_id, 'wpvr_sourceId', '' );
		update_post_meta( $post_id, 'wpvr_sourceName', 'Manual Adding' );
		update_post_meta( $post_id, 'wpvr_sourceType', 'Manual' );
		
		update_post_meta( $post_id, 'wpvr_video_service_url', $video_meta['url'] );
		update_post_meta( $post_id, 'wpvr_video_service_views', $video_meta['views'] );
		update_post_meta( $post_id, 'wpvr_video_service_likes', $video_meta['likes'] );
		update_post_meta( $post_id, 'wpvr_video_service_dislikes', $video_meta['dislikes'] );
		update_post_meta( $post_id, 'wpvr_video_service_thumb', $video_meta['thumb'] );
		update_post_meta( $post_id, 'wpvr_video_service_icon', $video_meta['icon'] );
		update_post_meta( $post_id, 'wpvr_video_service_desc', $video_meta['desc'] );
		
		if ( isset( $video_meta['author'] ) ) {
			update_post_meta( $post_id, 'wpvr_video_service_author_id', $video_meta['author']['id'] );
			
			update_post_meta( $post_id, 'wpvr_video_service_author_name', $video_meta['author']['title'] );
			update_post_meta( $post_id, 'wpvr_video_service_author_thumbnail', $video_meta['author']['thumbnail'] );
			update_post_meta( $post_id, 'wpvr_video_service_author_link', $video_meta['author']['link'] );
		}
		//update_post_meta( $post_id , 'wpvr_video_enableManualAdding' , 'off' );
		
		
		$postarr[ $field_name ] = $video_meta['id'];
		
		$data['ID'] = $post_id;
		//$data[ $field_name ] = $video_meta['id'] ;
		
		wpvr_run_dataFillers( $post_id );
		do_action( 'wpvr_event_run_dataFillers', $post_id );
		//title ?
		if ( $mOptions['getTitle'] ) {
			$data['post_title'] = $video_meta['title'];
			$data['post_name']  = sanitize_title( $video_meta['title'] );
		}
		
		//tags ?
		global $wpvr_tags_fix;
		if ( $mOptions['getTags'] ) {
			if ( is_array( $video_meta['tags'] ) ) {
				$video_meta['tags'] = implode( ',', $video_meta['tags'] );
			}
			$wpvr_tags_fix = $video_meta['tags'];
		}
		
		//desc ?
		if ( $mOptions['getDesc'] ) {
			$data['post_content'] = $video_meta['desc'];
		}
		
		
		//original post date ?
		if ( $mOptions['getPostDate'] ) {
			$data['post_date'] = $video_meta['originalPostDate'];
		}
		
		
		//Thumb ?
		global $wpvr_thumb_fix;
		if ( $mOptions['getThumb'] ) {
			//$image_url = $video_meta[ 'thumb' ];
			
			$thumb = wpvr_download_featured_image(
				$thumb = $video_meta['hqthumb'],
				$fallback_thumb = $video_meta['thumb'],
				$video_meta['title'],
				$video_meta['desc'],
				$post_id
			);
			wpvr_set_debug( $thumb );
			if ( $thumb != false ) {
				$wpvr_thumb_fix        = $thumb['attachment_id'];
				$video_meta['service'] = $video_service;
				do_action( 'wpvr_event_add_video_thumbnail', $video_meta, $post_id, $thumb['file'] );
			}
			
		}
		
		do_action( 'wpvr_event_add_video', $video_meta, $post_id );
		wpvr_add_notice( array(
			'title'       => 'WP Video Robot',
			//'class'     => 'updated' , //updated or warning or error
			'content'     => $wpvr_vs[ $video_service ]['msgs']['import_success'],
			'hidable'     => true,
			'is_dialog'   => false,
			'show_once'   => true,
			'single_line' => true,
			'color'       => '#09B189',
			'icon'        => 'fa-thumbs-up',
		) );
		
		
		$wpvr_imported[ $video_service ][ $video_id ] = $post_id;
		
		$data = apply_filters( 'wpvr_extend_video_manual_adding', $data, $post_id, $video_service, $postarr );
		
		update_option( 'wpvr_imported', $wpvr_imported );
		update_post_meta( $post_id, 'wpvr_video_enableManualAdding', 'off' );
		
		//d ($data );
		//d ($postarr );
		
		//$data['wpvr_video_enableManualAdding'] = 'off' ;
		
		return $data;
	}
	
	add_action( 'save_post', 'wpvr_tags_fix_function' );
	function wpvr_tags_fix_function( $post_id ) {
		global $wpvr_tags_fix, $wpvr_thumb_fix;
		if ( ! ( empty( $wpvr_tags_fix ) ) ) {
			wp_set_object_terms( $post_id, $wpvr_tags_fix, 'post_tag' );
		}
		
		if ( ! ( empty( $wpvr_thumb_fix ) ) ) {
			set_post_thumbnail( $post_id, $wpvr_thumb_fix );
		}
		
		do_action( 'wpvr_event_run_dataFillers_after_adding', $post_id );
		
	}
	
	add_action( 'save_post', 'wpvr_disable_importing_after_importing', 1000, 1 );
	function wpvr_disable_importing_after_importing( $post_id ) {
		global $wpvr_video_import_choices;
		
		$wpvr_video_import_choices = apply_filters( 'wpvr_extend_manual_video_adding_choices', $wpvr_video_import_choices );
		
		
		update_post_meta( $post_id, 'wpvr_video_enableManualAdding', 'off' );
		foreach ( (array) $wpvr_video_import_choices as $choice ) {
			update_post_meta( $post_id, $choice['target'], 'off' );
		}
		
	}
	
	/* HAck to allow Empty Video Title Adding */
	add_filter( 'pre_post_title', 'wpvr_allow_empty_video_title_function' );
	add_filter( 'pre_post_content', 'wpvr_allow_empty_video_title_function' );
	function wpvr_allow_empty_video_title_function( $value ) {
		if ( empty( $value ) ) {
			return ' ';
		}
		
		return $value;
	}
	
	/* HAck to allow Empty Video Title Adding */
	add_filter( 'wp_insert_post_data', 'wpvr_unmask_empty' );
	function wpvr_unmask_empty( $data ) {
		if ( ' ' == $data['post_title'] ) {
			$data['post_title'] = '';
		}
		if ( ' ' == $data['post_content'] ) {
			$data['post_content'] = '';
		}
		
		return $data;
	}
	
	/* Register 'INVALID' custom post status */
	add_action( 'init', 'wpvr_video_status_invalid' );
	function wpvr_video_status_invalid() {
		register_post_status(
			'invalid',
			array(
				'label'                     => __( 'Invalid', WPVR_LANG ),
				'public'                    => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Invalid <span class="count">(%s)</span>', 'Invalid <span class="count">(%s)</span>' ),
			)
		);
	}
	
	/* Add INVALID LABEL on invalid videos */
	add_action( 'admin_footer-post.php', 'wpvr_video_status_invalid_list' );
	function wpvr_video_status_invalid_list() {
		global $post;
		$complete = '';
		$label    = '';
		if ( $post->post_type == WPVR_VIDEO_TYPE ) {
			if ( $post->post_status == 'invalid' ) {
				$complete = ' selected="selected"';
				$label    = '<span id="post-status-display"> Invalid </span>';
			}
			?>
            <script>
                //jQuery(document).ready(function($){
                jQuery("select#post_status").append("<option value='invalid' <?php echo $complete; ?> ><?php _e( 'Invalid', WPVR_LANG ); ?></option>");
                jQuery(".misc-pub-section label").append("<?php echo $label; ?>");
                //});
            </script>
			<?php
		}
	}
	
	/* Return vodeo state if invalid */
	add_filter( 'display_post_states', 'wpvr_video_status_invalid_state' );
	function wpvr_video_status_invalid_state( $states ) {
		global $post;
		$arg = get_query_var( 'post_status' );
		if ( $arg != 'invalid' ) {
			if ( $post->post_status == 'invalid' ) {
				return array( 'INVALID !' );
			}
		}
		
		return $states;
	}
	
	/* Add invalid status option on screen */
	add_action( 'admin_footer-edit.php', 'wpvr_video_status_invalid_bulk' );
	function wpvr_video_status_invalid_bulk() {
		?>
        <script>
            //jQuery(document).ready(function($){
            jQuery(".inline-edit-status select ").append("<option value='invalid'><?php _e( 'Invalid', WPVR_LANG ); ?></option>");
            //});
        </script>
		<?php
	}
	
	add_action( 'restrict_manage_posts', 'wpvr_create_videos_filters' );
	function wpvr_create_videos_filters() {
		global $wpvr_vs, $pagenow;
		$post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : 'post';
		if ( $post_type != WPVR_VIDEO_TYPE ) {
			return false;
		}
		if ( $pagenow != 'edit.php' ) {
			return false;
		}
		
		?>
        <button class="button wpvr_filters_toggle">
			<span class="plus">
				<i class="fa fa-plus"></i><?php echo __( 'More filters', WPVR_LANG ); ?>
                <n class="wpvr_filters_count"></n>
			</span>
            <span class="minus">
				<i class="fa fa-minus"></i><?php echo __( 'Less filters', WPVR_LANG ); ?>
                <n class="wpvr_filters_count"></n>
			</span>
        </button>
        <div class="wpvr_filters_wrap">
			<?php echo wpvr_render_video_filters( 'services', $_GET ); ?>
			<?php echo wpvr_render_video_filters( 'authors', $_GET ); ?>
			<?php echo wpvr_render_video_filters( 'categories', $_GET ); ?>
			<?php echo wpvr_render_video_filters( 'wpvr_only', $_GET ); ?>
			<?php echo wpvr_render_video_filters( 'sources', $_GET ); ?>
            <div class="wpvr_clearfix"></div>

            <div class="wpvr_filter_input">
                <label class="wpvr_filter_label">
					<?php echo ___( 'Imported After' ); ?>
                </label>
                <input
                        type="text"
                        name="video_imported_after"
                        class="wpvr_admin_filters_input wpvr_date_field"
                        placeholder="<?php echo ___( 'Pick a date' ) . ' ...'; ?>"
                        value="<?php echo isset( $_GET['video_imported_after'] ) ? $_GET['video_imported_after'] : ''; ?>"
                />
            </div>

            <div class="wpvr_filter_input">
                <label class="wpvr_filter_label">
					<?php echo ___( 'Imported Before' ); ?>
                </label>
                <input
                        type="text"
                        name="video_imported_before"
                        class="wpvr_admin_filters_input wpvr_date_field"
                        placeholder="<?php echo ___( 'Pick a date' ) . ' ...'; ?>"
                        value="<?php echo isset( $_GET['video_imported_before'] ) ? $_GET['video_imported_before'] : ''; ?>"
                />
            </div>


            <div class="wpvr_filter_input">
                <label class="wpvr_filter_label">
					<?php echo ___( 'Posted After' ); ?>
                </label>
                <input
                        type="text"
                        name="video_posted_after"
                        class="wpvr_admin_filters_input wpvr_date_field"
                        placeholder="<?php echo ___( 'Pick a date' ) . ' ...'; ?>"
                        value="<?php echo isset( $_GET['video_posted_after'] ) ? $_GET['video_posted_after'] : ''; ?>"
                />
            </div>
            <div class="wpvr_filter_input">
                <label class="wpvr_filter_label">
					<?php echo ___( 'Posted before' ); ?>
                </label>
                <input
                        type="text"
                        name="video_posted_before"
                        class="wpvr_admin_filters_input wpvr_date_field"
                        placeholder="<?php echo ___( 'Pick a date' ) . ' ...'; ?>"
                        value="<?php echo isset( $_GET['video_posted_before'] ) ? $_GET['video_posted_before'] : ''; ?>"
                />
            </div>


            <button class="wpvr_tipso wpvr_button wpvr_admin_filters_button refine icon_only"
                    title="<?php echo ___( 'Refine' ); ?>">
                <i class="fa fa-search"></i>
				<?php //echo ___( 'Refine' ); ?>
            </button>

            <button class="wpvr_tipso wpvr_button wpvr_admin_filters_button clear wpvr_black_button icon_only"
                    title="<?php echo ___( 'Clear' ); ?>">
                <i class="fa fa-times"></i>
				<?php //echo ___( 'Clear' ); ?>
            </button>

            <div class="wpvr_clearfix"></div>
        </div>
		
		<?php
	}
	
	
	/* Filter videos by author or restrict to owners and admin*/
	add_filter( 'pre_get_posts', 'wpvr_video_filter_by_author' );
	function wpvr_video_filter_by_author( $query ) {
		global $pagenow, $wpvr_options, $wpvr_vs;
		$current_user_id = get_current_user_id();
		
		if ( ! is_admin() || $pagenow != 'edit.php' ) {
			return $query;
		}
		
		
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return $query;
		}
		
		
		$type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : 'post';
		if ( $type != WPVR_VIDEO_TYPE || $query->query_vars['post_type'] != WPVR_VIDEO_TYPE ) {
			return $query;
		}
		
		$query_args = $query->query_vars;
		if ( isset( $query_vars['meta_query'] ) ) {
			$meta_query             = $query_args['meta_query'];
			$meta_query['relation'] = 'AND';
		} else {
			$meta_query = array(
				'relation' => 'AND',
			);
		}
		
		if ( isset( $query_vars['tax_query'] ) ) {
			$tax_query             = $query_args['tax_query'];
			$tax_query['relation'] = 'AND';
		} else {
			$tax_query = array(
				'relation' => 'AND',
			);
		}
		if ( isset( $query_vars['date_query'] ) ) {
			$date_query              = $query_args['date_query'];
			$date_query['inclusive'] = true;
		} else {
			$date_query = array(
				'inclusive' => true,
			);
		}
		
		if ( $wpvr_options['restrictVideos'] && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			//d( 'REstrict Mode ' );
			$query->query_vars['author'] = $current_user_id;
			
			$current_user_sources = count_many_users_posts( array( $current_user_id ), WPVR_SOURCE_TYPE, false );
			$current_user_videos  = count_many_users_posts( array( $current_user_id ), WPVR_VIDEO_TYPE, false );
			
			
			if ( $current_user_sources[ $current_user_id ] == 0 || $current_user_videos[ $current_user_id ] == 0 ) {
				add_action( 'admin_notices', 'wpvr_show_restriction_msg' );
				if ( ! function_exists( 'wpvr_show_restriction_msg' ) ) {
					function wpvr_show_restriction_msg() {
						?>
                        <div class="error warning">
                            <b><?php _e( 'WP Video Robot WARNING', WPVR_LANG ); ?></b> : <br/>

                            <p>
                                <b><?php _e( 'Restriction mode is ON', WPVR_LANG ); ?></b><br/>
								<?php _e( 'You can view or edit your own sources and videos only unless you have Admin role.', WPVR_LANG ); ?>
                            </p>

                            <div class="wpvr_clearfix"></div>
                        </div>
						
						<?php
					}
				}
			}
			
		}
		
		//Filtering by author
		if ( isset( $_GET['video_author'] ) ) {
			$video_author = json_decode( urldecode( stripslashes( $_GET['video_author'] ) ), true );
			if ( count( $video_author ) != 0 ) {
				$query->query_vars['author__in'] = $video_author;
			}
		}
		
		
		//Filtering by service
		if ( isset( $_GET['video_service'] ) ) {
			$video_service = json_decode( urldecode( stripslashes( $_GET['video_service'] ) ), true );
			// d( $video_service );
			if ( count( $video_service ) != 0 ) {
				$meta_query[] = array(
					'key'     => 'wpvr_video_service',
					'value'   => $video_service,
					'compare' => 'IN',
				);
			}
		}
		
		//Filtering by source
		if ( isset( $_GET['video_source'] ) ) {
			$video_source = json_decode( urldecode( stripslashes( $_GET['video_source'] ) ), true );
			if ( count( $video_source ) != 0 ) {
				$meta_query[] = array(
					'key'     => 'wpvr_video_sourceId',
					'value'   => $video_source,
					'compare' => 'IN',
				);
			}
		}
		//Filtering by post date
		if ( isset( $_GET['video_posted_before'] ) && $_GET['video_posted_before'] != '' ) {
			$date                 = new Datetime( $_GET['video_posted_before'] );
			$date_query['before'] = array(
				'year'  => $date->format( 'Y' ),
				'month' => $date->format( 'm' ),
				'day'   => $date->format( 'd' ),
			);
		}
		if ( isset( $_GET['video_posted_after'] ) && $_GET['video_posted_after'] != '' ) {
			$date                = new Datetime( $_GET['video_posted_after'] );
			$date_query['after'] = array(
				'year'  => $date->format( 'Y' ),
				'month' => $date->format( 'm' ),
				'day'   => $date->format( 'd' ),
			);
		}
		//Filtering by import date
		if ( isset( $_GET['video_imported_before'] ) && $_GET['video_imported_before'] != '' ) {
			$meta_query[] = array(
				'key'     => 'wpvr_video_importDate',
				'value'   => $_GET['video_imported_before'],
				'compare' => '<=',
				'type'    => 'date',
			);
		}
		if ( isset( $_GET['video_imported_after'] ) && $_GET['video_imported_after'] != '' ) {
			$meta_query[] = array(
				'key'     => 'wpvr_video_importDate',
				'value'   => $_GET['video_imported_after'],
				'compare' => '>=',
				'type'    => 'date',
			);
		}
		
		//Filtering by source
		if ( isset( $_GET['video_cats'] ) ) {
			$video_cats = json_decode( urldecode( stripslashes( $_GET['video_cats'] ) ), true );
			if ( count( $video_cats ) != 0 ) {
				$query->query_vars['category__in'] = $video_cats;
				$query->query_vars['cat']          = '';
			}
		}
		
		//Filtering by WPVR videos
		if ( isset( $_GET['wpvr_only'] ) ) {
			$wpvr_only = json_decode( urldecode( stripslashes( $_GET['wpvr_only'] ) ), true );
			if ( $wpvr_only == array( "-1" ) ) {
				$meta_query[] = array(
					'key'     => 'wpvr_video_id',
					'compare' => 'NOT EXISTS',
				);
			} else {
				$meta_query[] = array(
					'key'     => 'wpvr_video_id',
					'value'   => '',
					'compare' => '!=',
				);
			}
		}
		
		// d( $date_query );
		
		$query->set( 'meta_query', $meta_query );
		$query->set( 'tax_query', $tax_query );
		$query->set( 'date_query', $date_query );
		
		return $query;
	}
	
	
	/* Hiding sources of Inactive services */
	add_filter( 'parse_query', 'wpvr_show_only_active_services_videos' );
	function wpvr_show_only_active_services_videos( $query ) {
		global $wpvr_vs_ids;
		if (
			! is_admin()
			|| ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		) {
			return $query;
		}
		
		$type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : 'post';
		if ( $type != WPVR_VIDEO_TYPE || $query->query_vars['post_type'] != WPVR_VIDEO_TYPE ) {
			return $query;
		}
		$meta_query             = isset( $query->query_vars['meta_query'] ) ? $query->query_vars['meta_query'] : array();
		$meta_query['relation'] = 'AND';
		
		$meta_query[] = array(
			array(
				'key'     => 'wpvr_video_service',
				'value'   => $wpvr_vs_ids['ids'],
				'compare' => 'IN',
			),
		);
		$query->set( 'meta_query', $meta_query );
		
		return $query;
	}
	
	
	add_action( 'plugins_loaded', 'wpvr_load_video_hooks', 1000 );
	function wpvr_load_video_hooks() {
		
		if ( apply_filters( 'wpvr_extend_define_videos_columns', true ) ) {
			
			/* Define Video List Column */
			add_filter( 'manage_edit-' . WPVR_VIDEO_TYPE . '_columns', 'wpvr_video_columns', 1000, 1 );
			function wpvr_video_columns( $columns ) {
				unset( $columns );
				$columns = array(
					'cb'          => '<input type="checkbox"/>',
					'video_thumb' => __( 'Thumbnail', WPVR_LANG ),
					'title'       => __( 'Title', WPVR_LANG ),
					'video_meta'  => __( 'Video Info', WPVR_LANG ),
					//'video_info'  => __( 'Info', WPVR_LANG ),
					'video_data'  => '',
				);
				
				//wpvr_ooo( $columns );
				
				return $columns;
			}
			
			add_action( 'manage_' . WPVR_VIDEO_TYPE . '_posts_custom_column', 'wpvr_video_custom_columns', 1000, 1 );
			function wpvr_video_custom_columns( $column ) {
				global $post, $wpvr_status, $wpvr_vs;
				$video_info          = wpvr_get_video_information( $post->ID );
				$wpvr_video_statuses = array( 'private' , 'pending', 'publish', 'invalid', 'draft', 'trash' );
				$status              = $video_info['post_status'];
				
				$using_external_thumb = get_post_meta( $post->ID, 'wpvr_video_using_external_thumbnail', true );
				$is_external_class    = $using_external_thumb != '' ? 'wpvr_external_thumb' : '';
				$is_external_flag     = $using_external_thumb != '' ? '' : '';
				
				switch ( $column ) {
					
					//Thumb Column
					case 'video_thumb':
						
						
						?>
                        <div class="wpvr_thumb_box <?php echo $is_external_class; ?> ">
							
							<?php if ( $using_external_thumb ) { ?>
                                <span class="wpvr_external_thumb_flag">
                                <i class="fa fa-globe"></i>
                                External Thumbnail
                            </span>
							<?php } ?>
							
							<?php if ( $video_info['service'] != '' ) { ?>
                                <div class="wpvr_center wpvr_service_icon sharp <?php echo $video_info['service']; ?>">
									<?php if ( isset( $wpvr_vs[ $video_info['service'] ] ) ) { ?>
										<?php echo $wpvr_vs[ $video_info['service'] ]['label']; ?>
									<?php } else { ?>
										<?php echo $video_info['service']; ?>
									<?php } ?>
                                </div>
							<?php } ?>
							<?php if ( $video_info['service'] != '' && $video_info['is_unwanted'] ) { ?>
                                <div class="wpvr_center wpvr_is_unwanted">
                                    <i class="fa fa-ban"></i>
                                    <span><?php echo __( 'UNWANTED', WPVR_LANG ); ?></span>
                                </div>
							<?php } ?>

                            <div class="wpvr_video_actions" style="display:none;">

                                <a
                                        class="wpvr_button small wpvr_edit_video"
                                        href="<?php echo $video_info['edit_link']; ?>"
                                >
                                    <i class="wpvr_link_icon fa fa-pencil"></i>
									<?php echo __( 'EDIT', WPVR_LANG ); ?>
                                </a>
                                <a
                                        href="#"
                                        class="wpvr_button small wpvr_preview_video wpvr_video_view"
                                        url="<?php echo WPVR_MANAGE_URL; ?>"
                                        service="<?php echo $video_info['service']; ?>"
                                        video_id="<?php echo $video_info['video_id']; ?>"
                                        post_id="<?php echo $video_info['post_id']; ?>"
                                >
                                    <i class="wpvr_link_icon fa fa-eye"></i>
									<?php echo __( 'PREVIEW', WPVR_LANG ); ?>
                                </a>
                                <a
                                        class="wpvr_button small wpvr_edit_video"
                                        target="_blank"
                                        href="<?php echo $video_info['view_link']; ?>"
                                >
                                    <i class="wpvr_link_icon fa fa-external-link"></i>
									<?php echo __( 'VIEW', WPVR_LANG ); ?>
                                </a>

                            </div>
                            <div class="wpvr_video_actions_overlay" style="display:none;"></div>


                            <img
                                    src="<?php echo $video_info['thumb_url']; ?>"
                            />
                        </div>
						<?php
						
						break;
					
					//Data Column
					case 'video_data':
						
						if ( $video_info['video_id'] == '' ) {
							break;
						}
						
						if ( ! isset( $wpvr_vs[ $video_info['service'] ] ) ) {
							echo __( 'Service disabled', WPVR_LANG );
							break;
						}
						
						if ( $using_external_thumb != '' ) {
							$thumbnail_info = '<div class="wpvr_video_info_type thumb">' .
							                  '<i class="fa fa-globe"></i>' .
							                  __( 'Using External Thumbnail', WPVR_LANG ) . ' ' .
							                  '</div>';
						} else {
							$thumbnail_info = '';
						}
						
						?>
                        <div style="">
							<?php if ( $video_info['service'] != '' ) { ?>
                                <div class="wpvr_center wpvr_service_icon <?php echo $video_info['service']; ?>">
									<?php echo $wpvr_vs[ $video_info['service'] ]['label'] . ' ' . __( 'video', WPVR_LANG ); ?>
                                </div>
							<?php } ?>

                            <div class="wpvr_center wpvr_video_admin_post_type">
								<?php echo __( 'Imported as', WPVR_LANG ) . ' <strong>' . $video_info['post_type_label'] . '</strong>'; ?>
                            </div>
                            <div class="wpvr_center wpvr_video_admin_id">
								<?php echo __( 'Video ID', WPVR_LANG ) . ': <strong style="text-transform:initial !important;">' . $video_info['video_id'] . '</strong>'; ?>
                            </div>

                            <div class="wpvr_center wpvr_video_admin_duration wpvr_video_admin_column">
								<?php echo $video_info['duration'] != '' ? $video_info['duration'] : ''; ?>
                            </div>

                            <div class="wpvr_center wpvr_video_admin_views wpvr_video_admin_column">
                                <b><?php echo wpvr_numberK( $video_info['views'] ); ?></b>
                                <span><?php _e( 'Views', WPVR_LANG ); ?></span>
                            </div>

                            <div class="wpvr_center wpvr_video_admin_views wpvr_video_admin_column">
                                <b><?php echo wpvr_numberK( $video_info['comment_count'] ); ?></b>
                                <span><?php _e( 'Comments', WPVR_LANG ); ?></span>
                            </div>

                            <div class="wpvr_clearfix"></div>
							
							<?php if ( in_array( $status, $wpvr_video_statuses ) ) { ?>
                                <div class="wpvr_center wpvr_video_status <?php echo $status; ?>">
                                    <i class="fa wpvr_video_status_icon <?php echo $wpvr_status[ $status ]['icon']; ?>"></i>
									<?php echo $wpvr_status[ $status ]['label']; ?>
                                </div>
							<?php } ?>


                        </div>
						<?php
						$echo = "";
						$echo = apply_filters( 'wpvr_extend_video_list_data_column', $echo, $post );
						echo $echo;
						
						unset( $_SESSION['video_admin_tmp'] );
						
						
						break;
					
					// Meta Column
					case 'video_meta':
						$echo = '';
						
						
						/* Echo Video Shortcode */
						$echo .= '<span class="wpvr_source_span">';
						$echo .= '<i class="fa fa-hashtag"></i>';
						$echo .= __( 'Post ID :', WPVR_LANG ) . ' ' . $video_info['post_id'];
						$echo .= '</span><br/>';
						
						
						if( $video_info['import_date'] != '' ){
							$echo .= '<span class=" wpvr_source_span">';
							$echo .= '<i class="fa fa-download"></i>';
							$echo .= __( 'Imported', WPVR_LANG ) .
							         ' <strong class="wpvr_tipso" title="'.$video_info['import_date_zoned'].'">' .
							         $video_info['import_date'] .
							         '</strong> <br/>';
							$echo .= '</span>';
                        }
						
						/* Echo Video Post Date */
						$echo .= '<span class=" wpvr_source_span">';
						$echo .= '<i class="fa fa-clock-o"></i>';
						$echo .= __( 'Posted', WPVR_LANG ) .
                                 ' <strong class="wpvr_tipso" title="'.$video_info['post_date_zoned'].'">' .
                                 $video_info['post_date'] .
                                 '</strong> <br/>';
						$echo .= '</span>';
						
						
						/* Echo Video Author */
						$echo .= '<span class=" wpvr_source_span">';
						$echo .= '<i class="fa fa-user"></i>';
						$echo .= __( 'Posted by', WPVR_LANG );
						$echo .= ' <b>' . $video_info['author_name'] . '</b> <br/>';
						$echo .= '</span>';
						
						/* Echo Video Categories */
						if ( count( $video_info['post_cats'] ) != 0 ) {
							$echo .= '<span class=" wpvr_source_span">';
							$echo .= '<i class="fa fa-folder-open"></i>';
							$echo .= __( 'Posted in', WPVR_LANG ) . ' ' . implode( ',', $video_info['post_cats'] );
							$echo .= '</span><br/>';
						}
						
						/* Echo Video Source infos */
						if ( $video_info['source_name'] != '' ) {
							$echo .= '<span class=" wpvr_source_span">';
							$echo .= '<i class="fa fa-search"></i>';
							$echo .= __( 'Source :', WPVR_LANG );
							$echo .= ' <b>' . $video_info['source_name'] . '</b> <br/>';
							$echo .= '</span>';
						}
						
						/* Echo Video Autoembeding ? */
						if ( $video_info['disableAutoembed'] == 'on' ) {
							$echo .= '<span class=" wpvr_source_span">';
							$echo .= '<i class="fa fa-close"></i>';
							//$echo .= ' <b>' . $video_comments_count . '</b> ';
							$echo .= __( 'Autoembedding Disabled.', WPVR_LANG );
							$echo .= '<br/></span>';
						}
						
						$echo = apply_filters( 'wpvr_extend_video_list_settings_column', $echo, $post );
						
						echo $echo;
						
						break;
				}
			}
		}
		
	}
	
	add_filter( 'bulk_post_updated_messages', 'my_bulk_post_updated_messages_filter', 10, 2 );
	function my_bulk_post_updated_messages_filter( $bulk_messages, $bulk_counts ) {
		
		$trashed_message = apply_filters( 'wpvr_extend_trashed_message', '' );
		$deleted_message = apply_filters( 'wpvr_extend_deleted_message', '' );
		
		$bulk_messages[ WPVR_VIDEO_TYPE ] = array(
			'updated'   => _n( '%s video updated.', '%s my_cpts updated.', $bulk_counts['updated'], WPVR_LANG ),
			'locked'    => _n( '%s video not updated, somebody is editing it.', '%s videos not updated, somebody is editing them.', $bulk_counts['locked'], WPVR_LANG ),
			'deleted'   => _n( '%s video permanently deleted.', '%s videos permanently deleted.', $bulk_counts['deleted'], WPVR_LANG ) . $deleted_message,
			'trashed'   => _n( '%s video moved to the Trash.', '%s videos moved to the Trash.', $bulk_counts['trashed'], WPVR_LANG ) . $trashed_message,
			'untrashed' => _n( '%s video restored from the Trash.', '%s videos restored from the Trash.', $bulk_counts['untrashed'], WPVR_LANG ),
		);
		
		return $bulk_messages;
		
	}
	
	