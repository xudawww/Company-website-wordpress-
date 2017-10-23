<?php
	
	
	/* Defining sources as wpvr_pages */
	add_action( 'admin_notices', 'wpvr_sources_define_wpvr_pages' );
	function wpvr_sources_define_wpvr_pages() {
		$type = 'post';
		if ( isset( $_GET['post_type'] ) ) {
			$type = $_GET['post_type'];
		}
		if ( WPVR_SOURCE_TYPE == $type ) {
			global $wpvr_pages;
			$wpvr_pages = true;
		}
	}
	
	/* Defining Duplicate Source actions */
	add_action( 'admin_action_duplicate_source', 'wpvr_source_duplicate_fct' );
	function wpvr_source_duplicate_fct() {
		global $wpdb;
		if ( ! ( isset( $_GET['post'] ) || isset( $_POST['post'] ) || ( isset( $_REQUEST['action'] ) && 'duplicate_source' == $_REQUEST['action'] ) ) ) {
			wp_die( 'No post to duplicate has been supplied!' );
		}
		$post_id = ( isset( $_GET['post'] ) ? $_GET['post'] : $_POST['post'] );
		wpvr_duplicate_source( $post_id, $singleDuplicate = true );
	}
	
	/* Defining The Csutom source type*/
	add_action( 'init', 'wpvr_define_sources_post_type', 0 );
	function wpvr_define_sources_post_type() {
		if ( WPVR_META_DEBUG_MODE ) {
			$sources_support = array( 'custom-fields' );
		} else {
			$sources_support = array( '' );
		}
		
		$sources_support = apply_filters( 'wpvr_extend_sources_support', $sources_support );
		
		$labels = array(
			'name'               => _x( 'Sources', 'Post Type General Name', WPVR_LANG ),
			'singular_name'      => _x( 'Source', 'Post Type Singular Name', WPVR_LANG ),
			'menu_name'          => __( 'Sources', WPVR_LANG ),
			'parent_item_colon'  => __( 'Parent Source:', WPVR_LANG ),
			'all_items'          => __( 'All Sources', WPVR_LANG ),
			'view_item'          => __( 'View Source', WPVR_LANG ),
			'add_new_item'       => __( 'Add New Source', WPVR_LANG ),
			'add_new'            => __( 'New Source', WPVR_LANG ),
			'edit_item'          => __( 'Edit Source', WPVR_LANG ),
			'update_item'        => __( 'Update Source', WPVR_LANG ),
			'search_items'       => __( 'Search sources', WPVR_LANG ),
			'not_found'          => __( 'No sources found', WPVR_LANG ),
			'not_found_in_trash' => __( 'No sources found in Trash', WPVR_LANG ),
		);
		$args   = array(
			'label'               => __( 'source', WPVR_LANG ),
			'description'         => __( 'WPVR Sources', WPVR_LANG ),
			'labels'              => $labels,
			//'supports'            => array( 'title','custom-fields' ), //DEBUG LINE
			'supports'            => $sources_support,
			'taxonomies'          => array( '' ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-search',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => false,
			'capability_type'     => 'page',
		);
		register_post_type( WPVR_SOURCE_TYPE, $args );
	}
	
	// Register Custom Taxonomy
	add_action( 'init', 'wpvr_define_source_folders', 0 );
	function wpvr_define_source_folders() {
		$labels = array(
			'name'                       => _x( 'Source Folders', 'Taxonomy General Name', 'wpvr_lang' ),
			'singular_name'              => _x( 'Source Folder', 'Taxonomy Singular Name', 'wpvr_lang' ),
			'menu_name'                  => __( 'Source Folders', 'wpvr_lang' ),
			'all_items'                  => __( 'All Folders', 'wpvr_lang' ),
			'parent_item'                => __( 'Parent Folder', 'wpvr_lang' ),
			'parent_item_colon'          => __( 'Parent Folder:', 'wpvr_lang' ),
			'new_item_name'              => __( 'New Folder Name', 'wpvr_lang' ),
			'add_new_item'               => __( 'Add New Folder', 'wpvr_lang' ),
			'edit_item'                  => __( 'Edit Folder', 'wpvr_lang' ),
			'update_item'                => __( 'Update Folder', 'wpvr_lang' ),
			'view_item'                  => __( 'View Folder', 'wpvr_lang' ),
			'separate_items_with_commas' => __( 'Separate folders with commas', 'wpvr_lang' ),
			'add_or_remove_items'        => __( 'Add or remove folders', 'wpvr_lang' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'wpvr_lang' ),
			'popular_items'              => __( 'Popular folders', 'wpvr_lang' ),
			'search_items'               => __( 'Search folders', 'wpvr_lang' ),
			'not_found'                  => __( 'Not Found', 'wpvr_lang' ),
			'no_terms'                   => __( 'No folders', 'wpvr_lang' ),
			'items_list'                 => __( 'Folders list', 'wpvr_lang' ),
			'items_list_navigation'      => __( 'Folders list navigation', 'wpvr_lang' ),
		);
		$args   = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => false,
		);
		register_taxonomy( WPVR_SFOLDER_TYPE, array( 'wpvr_source' ), $args );
		
	}
	
	
	/*Manage Custom Columns on Sources list */
	add_filter( 'manage_edit-' . WPVR_SOURCE_TYPE . '_columns', 'wpvr_source_define_custom_columns' );
	function wpvr_source_define_custom_columns( $columns ) {
		unset( $columns );
		$columns = array(
			'cb'      => '<input type="checkbox"/>',
			'name'    => __( 'Name', WPVR_LANG ),
			'stats'   => __( 'Statistics', WPVR_LANG ),
			'info'    => __( 'Information', WPVR_LANG ),
			'options' => __( 'Settings', WPVR_LANG ),
			'status'  => __( 'Status', WPVR_LANG ),
		);
		
		return $columns;
	}
	
	/*Manage Custom Columns on Sources list */
	add_action( 'manage_' . WPVR_SOURCE_TYPE . '_posts_custom_column', 'wpvr_source_manage_custom_columns' );
	function wpvr_source_manage_custom_columns( $column ) {
		global $post;
		
		if ( isset( $_GET['post_status'] ) && $_GET['post_status'] != '' ) {
			$post_status = $_GET['post_status'];
		} else {
			$post_status = 'publish';
		}
		//d( $post_status );
		echo wpvr_get_source_columns( $post->ID, $column, $post_status );
		if ( $column == 'status' ) {
			unset( $_SESSION['tmp_sources_columns'] );
		}
	}
	
	
	/*Manage Custom Columns on Sources Folders list */
	add_filter( 'manage_edit-' . WPVR_SFOLDER_TYPE . '_columns', 'wpvr_source_folders_define_custom_columns' );
	function wpvr_source_folders_define_custom_columns( $columns ) {
		$columns['actions'] = __( 'Sources Actions', WPVR_LANG );
		
		return $columns;
	}
	
	/*Manage Custom Columns on Sources Folders list */
	add_action( 'manage_' . WPVR_SFOLDER_TYPE . '_custom_column', 'wpvr_source_folders_manage_custom_columns', 10, 3 );
	function wpvr_source_folders_manage_custom_columns( $value, $column_name, $folder_id ) {
		//d( $column_name );
		if ( $column_name == 'actions' ) {
			
			$testLink   = admin_url( 'admin.php?page=wpvr&test_sources&folders=' . $folder_id, 'http' );
			$runLink    = admin_url( 'admin.php?page=wpvr&run_sources&folders=' . $folder_id, 'http' );
			$exportLink = admin_url( 'admin.php?page=wpvr&export_sources&folders=' . $folder_id, 'http' );
			
			$more = apply_filters( 'wpvr_extend_source_folder_column_actions', '', $folder_id );
			
			return '
				<div class = "wpvr_source_action_button pull-left">
					<a href = "' . $testLink . '" target = "_blank">
						<i class = "wpvr_link_icon fa fa-eye"></i>
						' . __( 'Test', WPVR_LANG ) . '
					</a>
				</div>
				<div class = "wpvr_source_action_button pull-left ">
					<a href = "' . $runLink . '" target = "_blank">
						<i class = "wpvr_link_icon fa fa-bolt"></i>
						' . __( 'Run', WPVR_LANG ) . '
					</a>
				</div>
				<div class="wpvr_clearfix"></div>
				<div class = "wpvr_source_action_button wpvr_black_button pull-left">
					<a href = "' . $exportLink . '" target = "_blank">
						<i class = "wpvr_link_icon fa fa-upload"></i>
						' . __( 'Export', WPVR_LANG ) . '
					</a>
				</div>
				' . $more . '
			';
		}
		
		return $value;
	}
	
	
	/* Define Sources Metaboxes */
	add_filter( 'wpvr_cmb_meta_boxes', 'wpvr_source_define_metaboxes' );
	function wpvr_source_define_metaboxes( $meta_boxes ) {
		$prefix       = 'wpvr_source_';
		$authorsArray = wpvr_get_authors( $invert = true, $default = true, $restrict = false );
		
		global
		$wpvr_hours,
		$wpvr_hours_us,
        $wpvr_days_names,
        $wpvr_countries,
        $wpvr_options,
        $wpvr_post_statuses;
		$wpvr_hours_formatted = $wpvr_options['timeFormat'] == 'standard' ? $wpvr_hours : $wpvr_hours_us;
		
		if ( WPVR_ACCEPT_EMPTY_SOURCE_NAMES ) {
			$accept_empty_source_name = 'canBeEmpty';
		} else {
			$accept_empty_source_name = '';
		}
		
		if ( WPVR_MAX_WANTED_VIDEOS === false ) {
			$max_wanted_videos = '';
		} else {
			$max_wanted_videos = WPVR_MAX_WANTED_VIDEOS;
		}
		
		/* Extending Video Services Options */
		$video_service_options = array();
		$video_service_options = apply_filters( 'wpvr_extend_video_services_options', $video_service_options );
		// d( $video_service_options );
		/* Extending Video Services Types Options */
		$video_service_types_options = array();
		$video_service_types_options = apply_filters( 'wpvr_extend_video_services_types_options', $video_service_types_options );
		
		/* Extending Video Services Types Options */
		$source_fields = array();
		$source_fields = apply_filters( 'wpvr_extend_video_services_types_fields', $source_fields, $prefix );
		
		$source_basics       = array(
			array(
				'name' => __( 'Name', WPVR_LANG ),
				'desc' => '',
				'id'   => $prefix . 'name',
				'type' => 'text',
			),
			array(
				'name'        => __( 'Video Service', WPVR_LANG ),
				'desc'        => '',
				'id'          => $prefix . 'service',
				'type'        => 'radio_inline',
				'options'     => $video_service_options,
				'default'     => 'youtube',
				'wpvrClass'   => $accept_empty_source_name,
				'wpvrService' => $max_wanted_videos,
			),
			array(
				'name'      => __( 'Source Type', WPVR_LANG ),
				'desc'      => '',
				'id'        => $prefix . 'type',
				'type'      => 'radio_inline',
				'options'   => $video_service_types_options,
				'default'   => '',
				'wpvrClass' => 'sourceType',
				'wpvrStyle' => 'display:none;',
				// 'wpvrService' => 'koko' ,
			),
		);
		$source_infos_fields = array_merge( $source_basics, $source_fields );
		
		$meta_boxes[] = array(
			'id'         => 'wpvr_source_metabox',
			'title'      => '<i class="fa fa-info-circle"></i> ' . __( 'Source Information', WPVR_LANG ),
			'pages'      => array( WPVR_SOURCE_TYPE ), // post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			'fields'     => $source_infos_fields,
		);
		global $wpvr_options;
		
		
		$global_unwanted_count  = wpvr_count_unwanted_videos( wpvr_get_unwanted_videos( false, true ) );
		$global_unwanted_videos = $global_unwanted_count == 0 ? '' : ' (' . wpvr_numberK( $global_unwanted_count ) . ' videos)';
		
		if ( isset( $_GET['post'] ) ) {
			$source_unwanted_count  = wpvr_count_unwanted_videos( wpvr_get_unwanted_videos( array( $_GET['post'] ), true ) );
			$source_unwanted_videos = $source_unwanted_count == 0 ? '' : ' (' . wpvr_numberK( $source_unwanted_count ) . ' videos)';
		} elseif ( isset( $_POST['post_ID'] ) ) {
			$source_unwanted_count  = wpvr_count_unwanted_videos( wpvr_get_unwanted_videos( array( $_POST['post_ID'] ), true ) );
			$source_unwanted_videos = $source_unwanted_count == 0 ? '' : ' (' . wpvr_numberK( $source_unwanted_count ) . ' videos)';
		} else {
			$source_unwanted_videos = '';
		}
		
		
		$meta_boxes[]   = array(
			'id'         => 'wpvr_source_options_metabox',
			'title'      => '<i class="fa fa-search"></i> ' . __( 'Source Fetching Options', WPVR_LANG ),
			'pages'      => array( WPVR_SOURCE_TYPE ), // post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name'    => __( 'Wanted Videos', WPVR_LANG ),
					'id'      => $prefix . 'wantedVideosBool',
					'type'    => 'select',
					'options' => array(
						'default' => __( '- Default -', WPVR_LANG ) . wpvr_print_default_value( 'wantedVideos' ),
						'custom'  => __( 'Custom number', WPVR_LANG ),
					),
					'default' => 'default',
					'desc'    => __( 'Define here how many videos you want to fetch and import at once.', WPVR_LANG ) . '<br/>' .
					             __( 'We strongly recommend that you set this to a low number to avoid crashing your server.', WPVR_LANG ),
				
				),
				array(
					'name'            => __( 'Number of videos', WPVR_LANG ),
					'desc'            => __( 'How many videos to get at a time?', WPVR_LANG ) . ' ' .
					                     __( 'Max', WPVR_LANG ) . ' : ' . ( ( WPVR_MAX_WANTED_VIDEOS === false ) ? __( 'Unlimited', WPVR_LANG ) : WPVR_MAX_WANTED_VIDEOS ),
					'default'         => '5',
					'id'              => $prefix . 'wantedVideos',
					'type'            => 'text_small',
					'wpvrStyle'       => 'display:none;',
					'wpvrClass'       => 'wpvr_has_master',
					'wpvr_attributes' => array(
						'master_id'    => $prefix . 'wantedVideosBool',
						'master_value' => 'custom',
					),
				),
				array(
					'name'    => __( 'Order by', WPVR_LANG ),
					'desc'    => __( 'Define the the criterion that should be used to order the fetched videos.', WPVR_LANG ),
					'id'      => $prefix . 'order',
					'type'    => 'select',
					'options' => array(
						'default'   => __( '- Default -', WPVR_LANG ) . wpvr_print_default_value( 'orderVideos' ),
						'relevance' => __( 'Relevance', WPVR_LANG ),
						'date'      => __( 'Date', WPVR_LANG ),
						'viewCount' => __( 'Views', WPVR_LANG ),
						'title'     => __( 'Title', WPVR_LANG ),
						'rating'    => __( 'Rating', WPVR_LANG ),
					),
					'default' => 'default',
				),
				array(
					'name'    => __( 'Duplicates', WPVR_LANG ),
					'desc'    => __( 'Choose whether to import only new videos, and skip already imported videos.', WPVR_LANG ) . '<br/>' .
					             __( 'Note that if you turn off this option, you will have several duplicates of the same video on your site.', WPVR_LANG ),
					'id'      => $prefix . 'onlyNewVideos',
					'type'    => 'select',
					'options' => array(
						'default' => __( '- Default -', WPVR_LANG ) . wpvr_print_default_value( 'onlyNewVideos' ),
						'on'      => __( 'Skip duplicates', WPVR_LANG ),
						'off'     => __( 'Do not skip duplicates', WPVR_LANG ),
					),
					'default' => 'default',
				),
				array(
					'name'    => __( 'Unwanted Scope', WPVR_LANG ),
					'desc'    => __( 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', WPVR_LANG ) . '<br/>' .
					             __( 'xxxxxxxxxxxxxxxxxxx', WPVR_LANG ),
					'id'      => $prefix . 'skipUnwanted',
					'type'    => 'select',
					'options' => array(
						'global' => __( 'Skip Global Unwanted', WPVR_LANG ) . ' ' . $global_unwanted_videos,
						'source' => __( 'Skip Source Unwanted', WPVR_LANG ) . ' ' . $source_unwanted_videos,
					),
					'default' => 'global',
				),
				
				array(
					'name'    => __( 'Statistics', WPVR_LANG ),
					'desc'    => __( 'Choose whether to import video views, duration and likes too.', WPVR_LANG ) . '<br/>' .
					             __( 'Note that this feature is only supported by Youtube. Turn this off to improve the plugin performances.', WPVR_LANG ),
					'id'      => $prefix . 'getVideoStats',
					'type'    => 'select',
					'options' => array(
						'default' => __( '- Default -', WPVR_LANG ) . wpvr_print_default_value( 'getStats' ),
						'on'      => __( 'Get Video Statistics', WPVR_LANG ),
						'off'     => __( 'Do not get Video Statistics', WPVR_LANG ),
					),
					'default' => 'default',
				),
				array(
					'name'    => __( 'Video Tags', WPVR_LANG ),
					'desc'    => __( 'Choose whether to import and assign the video tags while importing the video.', WPVR_LANG ) . '<br/>' .
					             __( 'Note that this feature is only supported by Youtube. Turn this off to improve the plugin performances.', WPVR_LANG ),
					'id'      => $prefix . 'getVideoTags',
					'type'    => 'select',
					'options' => array(
						'default' => __( '- Default -', WPVR_LANG ) . wpvr_print_default_value( 'getTags' ),
						'on'      => __( 'Get Video Tags', WPVR_LANG ),
						'off'     => __( 'Do not get Video Tags', WPVR_LANG ),
					),
					'default' => 'default',
				),
			
			),
		);
		$edit_cats_link = admin_url( 'edit-tags.php?taxonomy=category' );
		$catsArray      = array(
			'' => __( 'Choose one or more categories', WPVR_LANG ),
		);
		if ( WPVR_HIERARCHICAL_CATS_ENABLED === true ) {
			$cats = wpvr_get_hierarchical_cats();
		} else {
			$cats = wpvr_get_categories_count( $invert = false, $get_empty = true );
		}
		foreach ( (array) $cats as $cat ) {
			$catsArray[ $cat['value'] ] = $cat['label'];
		}
		
		$tagsArray = array( '' => __( 'Enter one or more tags', WPVR_LANG ) );
		
		$available_tags_list = array(
			'%koko%',
			'%bango%',
		);
		$available_tags
		                     = '
			<a 
				href="#"
				class="wpvr_popup_info"
				popup_content="' . implode( "\n", $available_tags_list ) . '"
				popup_title="' . __( 'Available tags to use', WPVR_LANG ) . '"
				
			>
				' . __( 'Available Tags', WPVR_LANG ) . '
			</a >
			  ';
		
		
		// $source_id = $_GET['post'] ;
		// d( get_post_meta( $source_id ) );
		
		
		$meta_boxes[] = array(
			'id'         => 'wpvr_source_posting_metabox',
			'title'      => '<i class="fa fa-cloud-upload"></i> ' . __( 'Source Posting Options', WPVR_LANG ),
			'pages'      => array( WPVR_SOURCE_TYPE ), // post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name'    => __( 'Download Thumbnail', WPVR_LANG ),
					'desc'    => __( 'Choose whether to download or not the video thumbnail on your site and set it as the imported video featured image.', WPVR_LANG ) . '<br/>' .
					             __( 'Using external thumbnails will enhance the plugin performances considerably.', WPVR_LANG ),
					'id'      => $prefix . 'downloadThumb',
					'type'    => 'select',
					'options' => array(
						'default' => __( '- Default -', WPVR_LANG ) . wpvr_print_default_value( 'downloadThumb',
								__( 'Download thumbnails', WPVR_LANG ),
								__( 'Use external thumbnails', WPVR_LANG )
							),
						'on'      => __( 'Download thumbnails', WPVR_LANG ),
						'off'     => __( 'Use external thumbnails', WPVR_LANG ),
					),
					'default' => 'default',
				),
				
				array(
					'name'    => __( 'Post Status', WPVR_LANG ),
					'desc'    => __( 'Choose what post status the imported videos should automatically have.', WPVR_LANG ),
					//. '<br/>' .__( '', WPVR_LANG ),
					'id'      => $prefix . 'postStatus',
					'type'    => 'select',
					'options' => array_merge(
					        array('default' => __( '- Default -', WPVR_LANG ) . wpvr_print_default_value( 'postStatus' ),),
						    $wpvr_post_statuses
                    ),
					'default' => 'default',
				),
				
				
				array(
					'name'      => __( 'Post to', WPVR_LANG ) . ' HIDDEN',
					'id'        => $prefix . 'postCats',
					'type'      => 'text',
					'default'   => '',
					'wpvrClass' => 'wpvr_selectize_values',
					'wpvrStyle' => 'display:none;',
				),
				array(
					'name'         => __( 'Post to', WPVR_LANG ),
					'desc'         => __( 'Pick one or more categories to automatically assign to imported videos.', WPVR_LANG ) .
					                  '<br/><a href="' . $edit_cats_link . '" target="_blank">' . __( 'Edit or Add the Categories', WPVR_LANG ) . '</a>',
					'id'           => $prefix . 'postCats_',
					'type'         => 'select',
					'options'      => $catsArray,
					'wpvrClass'    => 'wpvr_cmb_selectize wpvr_has_caret',
					'wpvrMaxItems' => WPVR_MAX_POSTING_CATS,
					//'default' => '',
				),
				array(
					'name'      => __( 'Post Author', WPVR_LANG ) . ' HIDDEN',
					'id'        => $prefix . 'postAuthor',
					'type'      => 'text',
					'default'   => json_encode( array( 'default' ) ),
					'wpvrClass' => 'wpvr_selectize_values',
					'wpvrStyle' => 'display:none;',
				),
				array(
					'name'         => __( 'Post Author', WPVR_LANG ),
					'desc'         => __( 'Pick the WP user that should automatically be the author of the imported videos.', WPVR_LANG ),
					'id'           => $prefix . 'postAuthor_',
					'type'         => 'select',
					'default'      => 'default',
					'options'      => $authorsArray,
					'wpvrClass'    => 'wpvr_cmb_selectize wpvr_has_caret',
					'wpvrMaxItems' => 1,
					'wpvrService'  => $prefix . 'postAuthor',
				),
				array(
					'name'    => __( 'Post Date', WPVR_LANG ),
					'desc'    => __( 'When posting imported videos, you can either use the original video service publishing date, or the actual import date.', WPVR_LANG ),
					'id'      => $prefix . 'postDate',
					'type'    => 'select',
					'options' => array(
						'default'  => __( '- Default -', WPVR_LANG ) . wpvr_print_default_value( 'getPostDate' ),
						'original' => __( 'Original Date', WPVR_LANG ),
						'new'      => __( 'Updated Date', WPVR_LANG ),
					),
					'default' => 'default',
				),
				
				array(
					'name'    => __( 'Post Title Affix', WPVR_LANG ),
					'desc'    => __( 'Choose to add the name of the source or a custom text before or after the video title.', WPVR_LANG ),
					'id'      => $prefix . 'postAppend',
					'type'    => 'select',
					'options' => array(
						'off'          => __( 'Disabled', WPVR_LANG ),
						'before'       => __( 'Add source name before the video title', WPVR_LANG ),
						'after'        => __( 'Add source name after the video title', WPVR_LANG ),
						'customBefore' => __( 'Add custom text before the video title', WPVR_LANG ),
						'customAfter'  => __( 'Add custom text after the video title', WPVR_LANG ),
					),
					'default' => 'default',
				),
				array(
					'name'            => __( 'Custom Text Affix', WPVR_LANG ),
					'desc'            => __( 'Choose a custom text to add before or after the video title.', WPVR_LANG ),
					'id'              => $prefix . 'appendCustomText',
					'default'         => '',
					'type'            => 'text',
					'wpvrStyle'       => 'display:none;',
					'wpvrClass'       => 'wpvr_has_master',
					'wpvr_attributes' => array(
						'master_id'    => $prefix . 'postAppend',
						'master_value' => 'customBefore,customAfter',
					),
				
				),
				array(
					'name'    => __( 'Post Tags', WPVR_LANG ),
					'desc'    => __( 'Choose whether to auto assign some additional tags to the imported videos.', WPVR_LANG ),
					'id'      => $prefix . 'postTagsBool',
					'type'    => 'select',
					'options' => array(
						'disabled' => __( 'Disabled', WPVR_LANG ),
						'default'  => __( 'Default Tags', WPVR_LANG ),
						'custom'   => __( 'Custom Tags', WPVR_LANG ),
					),
					'default' => 'disabled',
				),
				array(
					'name'            => __( 'Post Tags', WPVR_LANG ) . '',
					'id'              => $prefix . 'postTags',
					'type'            => 'textarea',
					'desc'            => __( 'Enter your custom tags.', WPVR_LANG ),
					'default'         => '',
					'wpvrStyle'       => 'display:none;',
					'wpvrClass'       => 'wpvr_has_master',
					'wpvr_attributes' => array(
						'master_id'    => $prefix . 'postTagsBool',
						'master_value' => 'custom',
					),
				),
				
				array(
					'name'    => __( 'Video Text Content', WPVR_LANG ),
					'desc'    => __( 'Choose whether to import and use the video description as the post content, or import the video player only.', WPVR_LANG ),
					'id'      => $prefix . 'postContent',
					'type'    => 'select',
					'options' => array(
						'default' => $wpvr_options['postContent'] == 'on' ?
							__( '- Default -', WPVR_LANG ) . ' (' . __( 'Post the video text content', WPVR_LANG ) . ')' :
							__( '- Default -', WPVR_LANG ) . ' (' . __( 'Skip posting the video text content', WPVR_LANG ) . ')',
						'on'      => __( 'Post the video text content', WPVR_LANG ),
						'off'     => __( 'Skip posting the video text content', WPVR_LANG ),
					),
					'default' => 'default',
				),
			
			),
		);
		
		$meta_boxes[] = array(
			'id'         => 'wpvr_source_filtering_metabox',
			'title'      => '<i class="fa fa-filter"></i> ' . __( 'Source Filtering Options', WPVR_LANG ),
			'pages'      => array( WPVR_SOURCE_TYPE ), // post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name'    => __( 'Published After', WPVR_LANG ),
					'id'      => $prefix . 'publishedAfter_bool',
					'type'    => 'select',
					'desc'    => __( 'Import only videos published after this date.', WPVR_LANG ) . ' ' .
					             __( 'Leave empty to ignore this criterion.', WPVR_LANG ) . '<br/>' .
					             __( 'Note that this feature is only supported by Youtube and Dailymotion. Supported Format: mm/dd/YYYY', WPVR_LANG ),
					'options' => array(
						'default' => __( '- Default -', WPVR_LANG ) . wpvr_print_default_value( 'publishedAfter' ),
						'custom'  => __( 'Custom', WPVR_LANG ),
					),
					'default' => 'default',
				),
				array(
					'name'            => __( 'Published After', WPVR_LANG ) . ' (Date)',
					'id'              => $prefix . 'publishedAfter',
					'type'            => 'text_date',
					'default'         => '',
					'wpvrStyle'       => 'display:none;',
					'wpvrClass'       => 'wpvr_has_master',
					'wpvr_attributes' => array(
						'master_id'    => $prefix . 'publishedAfter_bool',
						'master_value' => 'custom',
					),
				),
				
				array(
					'name'    => __( 'Published Before', WPVR_LANG ),
					'id'      => $prefix . 'publishedBefore_bool',
					'desc'    => __( 'Import only videos published after this date.', WPVR_LANG ) . ' ' .
					             __( 'Leave empty to ignore this criterion.', WPVR_LANG ) . '<br/>' .
					             __( 'Note that this feature is only supported by Youtube and Dailymotion. Supported Format: mm/dd/YYYY', WPVR_LANG ),
					'type'    => 'select',
					'options' => array(
						'default' => __( '- Default -', WPVR_LANG ) . wpvr_print_default_value( 'publishedBefore' ),
						'custom'  => __( 'Custom', WPVR_LANG ),
					),
					'default' => 'default',
				),
				
				array(
					'name'            => __( 'Published Before', WPVR_LANG ) . ' (Date)',
					'id'              => $prefix . 'publishedBefore',
					'type'            => 'text_date',
					'default'         => '',
					'wpvrStyle'       => 'display:none;',
					'wpvrClass'       => 'wpvr_has_master',
					'wpvr_attributes' => array(
						'master_id'    => $prefix . 'publishedBefore_bool',
						'master_value' => 'custom',
					),
				),
				array(
					'name'    => __( 'Duration', WPVR_LANG ),
					'desc'    => __( 'Filter fetched videos by their duration.', WPVR_LANG ) . '<br/>' .
					             __( 'Note that this feature is only supported by Search sources and works only for Youtube, Vimeo and Dailymotion videos.', WPVR_LANG ),
					'id'      => $prefix . 'videoDuration',
					'type'    => 'select',
					'options' => array(
						'default' => __( '- Default -', WPVR_LANG ) . wpvr_print_default_value( 'videoDuration' ),
						'any'     => __( 'All Videos', WPVR_LANG ),
						'short'   => __( 'Videos less than 4min.', WPVR_LANG ),
						'medium'  => __( 'Videos between 4min. and 20min.', WPVR_LANG ),
						'long'    => __( 'Videos longer than 20min.', WPVR_LANG ),
					
					),
					'default' => 'default',
				),
				array(
					'name'    => __( 'Video Quality', WPVR_LANG ),
					'desc'    => __( 'Filter fetched videos by their video definition.', WPVR_LANG ) . '<br/>' .
					             __( 'Note that this feature is only supported by Youtube, Vimeo and Dailymotion.', WPVR_LANG ),
					'id'      => $prefix . 'videoQuality',
					'type'    => 'select',
					'options' => array(
						'default'  => __( '- Default -', WPVR_LANG ) . wpvr_print_default_value( 'videoQuality' ),
						'any'      => __( 'All Videos', WPVR_LANG ),
						'high'     => __( 'Only High Definition Videos', WPVR_LANG ),
						'standard' => __( 'Only Standard Definitions Videos', WPVR_LANG ),
					),
					'default' => 'default',
				),
			),
		);
		
		$meta_boxes[] = array(
			'id'         => 'wpvr_source_integration_metabox',
			'title'      => '<i class="fa fa-plug"></i> ' . __( 'Source Integration Options', WPVR_LANG ),
			'pages'      => array( WPVR_SOURCE_TYPE ), // post type
			'context'    => 'normal',
			'priority'   => 'low',
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name'        => __( 'Start Time', WPVR_LANG ),
					'desc'        => '',
					'id'          => $prefix . 'startTime',
					'type'        => 'text_small',
					'default'     => '',
					'description' => '<br/>' . __( 'Define the given number of seconds from the start of the video, when the player begin playing.', WPVR_LANG ) . '<br/>' .
					                 __( 'Works only with Youtube.', WPVR_LANG ) . '',
					'wpvrClass'   => 'wpvr_show_when_loaded',
					'wpvrStyle'   => 'display:none;',
				),
				array(
					'name'        => __( 'End Time', WPVR_LANG ),
					'desc'        => '',
					'id'          => $prefix . 'endTime',
					'type'        => 'text_small',
					'default'     => '',
					'description' => '<br/>' . __( 'Define the time, measured in seconds from the end of the video, when the player should stop playing.', WPVR_LANG ) . '<br/>' .
					                 __( 'Works only with Youtube.', WPVR_LANG ) . '',
					'wpvrClass'   => 'wpvr_show_when_loaded',
					'wpvrStyle'   => 'display:none;',
				),
				array(
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
				),
				
				array(
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
				),
				array(
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
				),
			
			
			),
		);
		
		if ( isset( $_GET['post'] ) ) {
			
			if ( is_array( $_GET['post'] ) ) {
				return $meta_boxes;
			}
			
			$post_id = $_GET['post'];
			//$shortcode = '[wpvr id='.$post_id.']';
		} elseif ( isset( $_POST['post_ID'] ) ) {
			$post_id = $_POST['post_ID'];
			//$shortcode = '[wpvr id='.$post_id.']';
		} else {
			$post_id = "";
			//$shortcode = "Save First";
		}
		
		$actionButtons = wpvr_render_source_actions( $post_id );
		
		$meta_boxes[] = array(
			'id'         => 'wpvr_source_status_metabox',
			'title'      => '<i class="fa fa-play-circle"></i> ' . __( 'Source Actions', WPVR_LANG ),
			'pages'      => array( WPVR_SOURCE_TYPE ), // post type
			'context'    => 'side',
			'priority'   => 'high',
			'show_names' => false, // Show field names on the left
			'fields'     => array(
				
				array(
					'name'      => '',
					'desc'      => '',
					'id'        => $prefix . 'html_preload',
					'html'      => '<div style="text-align:center;">' . __( 'Loading ...', WPVR_LANG ) . '</div>',
					'type'      => 'show_html',
					'wpvrClass' => 'wpvr_metabox_html wpvr_hide_when_loaded',
					'wpvrStyle' => '',
				),
				
				array(
					'name'      => '',
					'desc'      => '',
					'id'        => $prefix . 'html',
					'html'      => '<div class="wpvr_action_buttons_wrap">' . $actionButtons['test'] .
					               $actionButtons['run'] .
					               $actionButtons['clone'] .
					               $actionButtons['save'] .
					               $actionButtons['trash'] . '</div>',
					'type'      => 'show_html',
					'wpvrClass' => 'wpvr_metabox_html wpvr_show_when_loaded',
					'wpvrStyle' => 'display:none;',
					'before'    => '<div class="wpvr_fixed_topbar"></div>',
				),
				// array(
				// 	'name'      => '',
				// 	'desc'      => '',
				// 	'id'        => $prefix . 'html',
				// 	'html'      => $actionButtons['run'],
				// 	'type'      => 'show_html',
				// 	'wpvrClass' => 'wpvr_metabox_html wpvr_show_when_loaded',
				// 	'wpvrStyle' => 'display:none;',
				// ),
				//
				// array(
				// 	'name'      => '',
				// 	'desc'      => '',
				// 	'id'        => $prefix . 'html',
				// 	'html'      => $actionButtons['clone'],
				// 	'type'      => 'show_html',
				// 	'wpvrClass' => 'wpvr_metabox_html wpvr_show_when_loaded',
				// 	'wpvrStyle' => 'display:none;',
				// ),
				//
				// array(
				// 	'name'      => '',
				// 	'desc'      => '',
				// 	'id'        => $prefix . 'html',
				// 	'html'      => $actionButtons['save'],
				// 	'type'      => 'show_html',
				// 	'wpvrClass' => 'wpvr_metabox_html wpvr_show_when_loaded',
				// 	'wpvrStyle' => 'display:none;',
				// ),
				//
				// array(
				// 	'name'      => '',
				// 	'desc'      => '',
				// 	'id'        => $prefix . 'html',
				// 	'html'      => $actionButtons['trash'],
				// 	'type'      => 'show_html',
				// 	'wpvrClass' => 'wpvr_metabox_html wpvr_show_when_loaded',
				// 	'wpvrStyle' => 'display:none;',
				// ),
				//
				
				array(
					'name'      => __( 'Plugin Version', WPVR_LANG ),
					'default'   => WPVR_VERSION,
					'id'        => $prefix . 'plugin_version',
					'type'      => 'text_small',
					'wpvrStyle' => 'display:none;',
				),
			),
		);
		$meta_boxes[] = array(
			'id'         => 'wpvr_source_scheduling_metabox',
			'title'      => '<i class="fa fa-calendar"></i> ' . __( 'Source Automation', WPVR_LANG ),
			'pages'      => array( WPVR_SOURCE_TYPE ), // post type
			'context'    => 'side',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			'fields'     => array(
				array(
					'name'    => __( 'Source Status', WPVR_LANG ),
					'desc'    => __( 'Enable this source to allow it to be executed automatically.', WPVR_LANG ) . ' ',
					'id'      => $prefix . 'status',
					'type'    => 'select',
					'options' => array(
						'on'  => __( 'Source is Active', WPVR_LANG ),
						'off' => __( 'Source not Active', WPVR_LANG ),
					),
					'default' => 'off',
				),
				array(
					'name'    => __( 'Source Schedule', WPVR_LANG ),
					'desc'    => __( 'Choose how often you want to automatically run this source.', WPVR_LANG ) . ' ',
					'id'      => $prefix . 'schedule',
					'type'    => 'select',
					'options' => array(
						'hourly' => __( 'Run Hourly', WPVR_LANG ),
						'daily'  => __( 'Run Daily', WPVR_LANG ),
						'weekly' => __( 'Run Weekly', WPVR_LANG ),
						'once'   => __( 'Run Once', WPVR_LANG ),
					),
					'default' => 'hourly',
				),
				array(
					'name' => __( 'Choose a date', WPVR_LANG ),
					'desc' => '',
					'id'   => $prefix . 'schedule_date',
					'type' => 'text_date_timestamp',
				
				),
				array(
					'name'    => __( 'Choose a day', WPVR_LANG ),
					'desc'    => '',
					'id'      => $prefix . 'schedule_day',
					'type'    => 'select',
					'options' => $wpvr_days_names,
					'default' => 'monday',
				),
				array(
					'name'    => __( 'Choose a time', WPVR_LANG ),
					'desc'    => __( 'Timezone Used:', WPVR_LANG ) . ' <br/>' . wpvr_get_timezone_name( wpvr_get_timezone() ),
					'id'      => $prefix . 'schedule_time',
					'type'    => 'select',
					'options' => $wpvr_hours_formatted,
					'default' => '04H00',
				),
			),
		);
		if ( $post_id != '' ) {
			$source = wpvr_get_source( $post_id );
			if ( $source != false ) {
				$source_type  = $source->type;
				$wantedVideos = ( ! isset( $source->wantedVideos ) || ( $source->wantedVideos == '' ) ) ? 0 : $source->wantedVideos;
				if ( $source_type == 'channel' ) {
					$subsources       = count( wpvr_parse_string( $source->channelIds ) );
					$subsources_label = __( 'channels', WPVR_LANG );
					$subsources_line  = ' <b>' . wpvr_numberK( $subsources, true ) . '</b> ' . $subsources_label . '<br/>';
					
				} elseif ( $source_type == 'playlist' ) {
					$subsources       = count( wpvr_parse_string( $source->playlistIds ) );
					$subsources_label = __( 'playlists', WPVR_LANG );
					$subsources_line  = ' <b>' . wpvr_numberK( $subsources, true ) . '</b> ' . $subsources_label . '<br/>';
					
				} else {
					$subsources      = 0;
					$subsources_line = '';
				}
				if ( $subsources > 1 ) {
					$wantedVideos = $wantedVideos * $subsources;
				}
				
				//d($source);
				$source_stats_html = '';
				$source_stats_html .= '<div  style="text-transform:uppercase;">';
				$source_stats_html .= ' <b>' . wpvr_numberK( $wantedVideos, true ) . '</b> ' . __( 'Wanted videos', WPVR_LANG ) . '<br/>';
				$source_stats_html .= '<b>' . wpvr_numberK( $source->count_imported, true ) . '</b> ' . __( 'Imported videos', WPVR_LANG ) . '<br/>';
				$source_stats_html .= $subsources_line;
				$source_stats_html .= __( 'TESTED', WPVR_LANG ) . ' <strong>' . wpvr_numberK( $source->count_test, true ) . '</strong> ' . __( 'times', WPVR_LANG ) . '<br/>';
				$source_stats_html .= __( 'RUN', WPVR_LANG ) . ' <strong>' . wpvr_numberK( $source->count_run, true ) . '</strong> ' . __( 'times', WPVR_LANG ) . '<br/>';
				$source_stats_html .= ' <strong>' . wpvr_numberK( $source->count_success, true ) . '</strong> ' . __( 'Success', WPVR_LANG ) . ' / ' .
				                      ' <strong>' . wpvr_numberK( $source->count_fail, true ) . '</strong> ' . __( 'Fail', WPVR_LANG ) . '<br/>';
				$source_stats_html .= '</div>';
			} else {
				$source_stats_html = '<div class="wpvr_no_actions">' . __( 'Start by saving your source', WPVR_LANG ) . '</div>';
			}
		} else {
			$source_stats_html = '<div class="wpvr_no_actions">' . __( 'Start by saving your source', WPVR_LANG ) . '</div>';
		}
		$meta_boxes[] = array(
			'id'         => 'wpvr_source_stats_metabox',
			'title'      => '<i class="fa fa-bar-chart"></i> ' . __( 'Source Stats', WPVR_LANG ),
			'pages'      => array( WPVR_SOURCE_TYPE ), // post type
			'context'    => 'side',
			'priority'   => 'low',
			'show_names' => false, // Show field names on the left
			'fields'     => array(
				array(
					'name'      => '',
					'desc'      => '',
					'id'        => $prefix . 'html',
					'html'      => $source_stats_html,
					'type'      => 'show_html',
					'wpvrClass' => 'wpvr_metabox_html',
				),
			),
		);
		$meta_boxes   = apply_filters( 'wpvr_extend_sources_metaboxes', $meta_boxes );
		
		return $meta_boxes;
	}
	
	// New Sources filters
	add_action( 'restrict_manage_posts', 'wpvr_create_source_filters' );
	function wpvr_create_source_filters() {
		global $wpvr_vs;
		$post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : 'post';
		if ( $post_type != WPVR_SOURCE_TYPE ) {
			return false;
		}
		
		?>
        <button class="button wpvr_filters_toggle">
			<span class="plus">
				<i class="fa fa-plus"></i><?php echo __( 'More Filters', WPVR_LANG ); ?>
                <n class="wpvr_filters_count"></n>
			</span>
            <span class="minus">
				<i class="fa fa-minus"></i><?php echo __( 'Less Filters', WPVR_LANG ); ?>
                <n class="wpvr_filters_count"></n>
			</span>
        </button>
        <div class="wpvr_filters_wrap">
			<?php //d( $_GET ); ?>
			<?php echo wpvr_render_source_filters( 'services', $_GET ); ?>
			<?php echo wpvr_render_source_filters( 'types', $_GET ); ?>
			<?php echo wpvr_render_source_filters( 'folders', $_GET ); ?>
			<?php echo wpvr_render_source_filters( 'categories', $_GET ); ?>
			<?php echo wpvr_render_source_filters( 'authors', $_GET ); ?>
			<?php echo wpvr_render_source_filters( 'status', $_GET ); ?>

            <div class="wpvr_clearfix"></div>
            <div class="wpvr_filter_input">
                <label class="wpvr_filter_label">
					<?php echo ___( 'Created After' ); ?>
                </label>
                <input
                        type="text"
                        name="source_created_after"
                        class="wpvr_admin_filters_input wpvr_date_field"
                        placeholder="<?php echo ___( 'Pick a date' ) . ' ...'; ?>"
                        value="<?php echo isset( $_GET['source_created_after'] ) ? $_GET['source_created_after'] : ''; ?>"
                />
            </div>
            <div class="wpvr_filter_input">
                <label class="wpvr_filter_label">
					<?php echo ___( 'Created before' ); ?>
                </label>
                <input
                        type="text"
                        name="source_created_before"
                        class="wpvr_admin_filters_input wpvr_date_field"
                        placeholder="<?php echo ___( 'Pick a date' ) . ' ...'; ?>"
                        value="<?php echo isset( $_GET['source_created_before'] ) ? $_GET['source_created_before'] : ''; ?>"
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
	
	/*Filtering sources list */
	add_filter( 'pre_get_posts', 'wpvr_filter_source_list' );
	function wpvr_filter_source_list( $query ) {
		global $pagenow, $wpvr_options, $wpvr_vs;
		
		$source_ids = array();
		
		
		if ( ! is_admin() ) {
			return $query;
		}
		
		
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return $query;
		}
		
		$type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : 'post';
		if ( $type != WPVR_SOURCE_TYPE || ! is_admin() || $pagenow != 'edit.php' ) {
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
		
		// Filtering By Source Type
		if ( isset( $_GET['source_type'] ) ) {
			$selected_types = array();
			$get_type       = json_decode( urldecode( stripslashes( $_GET['source_type'] ) ), true );
			if ( count( $get_type ) != 0 ) {
				foreach ( (array) $wpvr_vs as $vs ) {
					foreach ( (array) $vs['types'] as $vs_type ) {
						if ( in_array( $vs_type['global_id'], $get_type ) ) {
							$selected_types[] = $vs_type['id'];
						}
					}
				}
			}
			//d( $get_type );
			if ( count( $selected_types ) > 0 ) {
				$meta_query[] = array(
					'key'     => 'wpvr_source_type',
					'value'   => $selected_types,
					'compare' => 'IN',
				);
			}
		}
		
		// Filtering By Source Type
		if ( isset( $_GET['source_cats'] ) ) {
			$source_cats = json_decode( urldecode( stripslashes( $_GET['source_cats'] ) ), true );
			if ( count( $source_cats ) != 0 ) {
				$cats_query = array( 'relation' => 'OR', );
				foreach ( (array) $source_cats as $cat_id ) {
					$cats_query[] = array(
						'key'     => 'wpvr_source_postCats',
						'value'   => '"' . $cat_id . '"',
						'compare' => 'LIKE',
					);
				}
				// d( $cats_query );
				$meta_query[] = $cats_query;
			}
			
		}
		
		// Filtering By Source Service
		if ( isset( $_GET['source_folder'] ) ) {
			$source_folder = json_decode( urldecode( stripslashes( $_GET['source_folder'] ) ), true );
			if ( count( $source_folder ) != 0 ) {
				$tax_query[] = array(
					'taxonomy' => WPVR_SFOLDER_TYPE,
					'field'    => 'term_id',
					'terms'    => $source_folder,
				);
			}
		}
		
		// Filtering By Source Status
		if ( isset( $_GET['source_status'] ) ) {
			$source_status = json_decode( urldecode( stripslashes( $_GET['source_status'] ) ), true );
			if ( count( $source_status ) != 0 ) {
				$meta_query[] = array(
					'key'     => 'wpvr_source_status',
					'value'   => $source_status,
					'compare' => 'IN',
				);
			}
		}
		
		// Filtering By Source Service
		if ( isset( $_GET['source_service'] ) ) {
			$source_service = json_decode( urldecode( stripslashes( $_GET['source_service'] ) ), true );
			if ( count( $source_service ) != 0 ) {
				$meta_query[] = array(
					'key'     => 'wpvr_source_service',
					'value'   => $source_service,
					'compare' => 'IN',
				);
			}
		}
		
		//Filtering by source creation date
		if ( isset( $_GET['source_created_after'] ) && $_GET['source_created_after'] != '' ) {
			$date                = new Datetime( $_GET['source_created_after'] );
			$date_query['after'] = array(
				'year'  => $date->format( 'Y' ),
				'month' => $date->format( 'm' ),
				'day'   => $date->format( 'd' ),
			);
		}
		
		if ( isset( $_GET['source_created_before'] ) && $_GET['source_created_before'] != '' ) {
			$date                 = new Datetime( $_GET['source_created_before'] );
			$date_query['before'] = array(
				'year'  => $date->format( 'Y' ),
				'month' => $date->format( 'm' ),
				'day'   => $date->format( 'd' ),
			);
		}
		
		// Filtering By Source Author
		if ( isset( $_GET['source_author'] ) ) {
			$source_author = json_decode( urldecode( stripslashes( $_GET['source_author'] ) ), true );
			//d( $source_author );
			if ( count( $source_author ) != 0 ) {
				//$source_author[] = 'default';
				$author_query = array( 'relation' => 'OR', );
				
				foreach ( (array) $source_author as $author_id ) {
					$author_query[] = array(
						'key'     => 'wpvr_source_postAuthor',
						'value'   => '"' . $author_id . '"',
						'compare' => 'LIKE',
					);
				}
				
				
				$meta_query[] = $author_query;
				
			}
		}
		
		//d( $meta_query );
		
		$query->set( 'meta_query', $meta_query );
		$query->set( 'tax_query', $tax_query );
		$query->set( 'date_query', $date_query );
		
		
		return $query;
	}
	
	
	/* Hide Publishing  button on edit sources screen */
	add_action( 'admin_head-post.php', 'wpvr_sources_hide_publishing_actions' );
	add_action( 'admin_head-post-new.php', 'wpvr_sources_hide_publishing_actions' );
	function wpvr_sources_hide_publishing_actions() {
		global $post;
		if ( $post->post_type == WPVR_SOURCE_TYPE ) {
			?>
            <style type="text/css">
                #misc-publishing-actions, #minor-publishing-actions {
                    display: none;
                }
            </style>
			<?php
		}
	}
	
	
	/* Customize WP Messages for sources editing */
	add_filter( 'post_updated_messages', 'wpvr_source_custom_updated_message' );
	function wpvr_source_custom_updated_message( $messages ) {
		global $post, $post_ID;
		$testLink = admin_url( 'admin.php?page=wpvr&test_sources&ids=' . $post->ID, 'http' );
		$runLink  = admin_url( 'admin.php?page=wpvr&run_sources&ids=' . $post->ID, 'http' );
		
		$messages[ WPVR_SOURCE_TYPE ] = array(
			0  => '',
			// Unused. Messages start at index 1.
			1  => sprintf( __( 'Source updated. <a class="add-new-h2 wpvr_notice_link" target = "_blank" href="%s"><i class="fa fa-eye"></i>Test this source</a> <a class="add-new-h2 wpvr_notice_link" target = "_blank" href="%s"><i class="fa fa-bolt"></i>Run this source</a>', WPVR_LANG ), $testLink, $runLink ),
			2  => __( 'Custom field updated.', WPVR_LANG ),
			3  => __( 'Custom field deleted.', WPVR_LANG ),
			4  => __( 'Source updated.', WPVR_LANG ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Source restored to revision from %s', WPVR_LANG ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => sprintf( __( 'Source updated. <a class="add-new-h2 wpvr_notice_link" target = "_blank" href="%s"><i class="fa fa-eye"></i>Test this source</a> <a class="add-new-h2 wpvr_notice_link" target = "_blank" href="%s"><i class="fa fa-bolt"></i>Run this source</a>', WPVR_LANG ), $testLink, $runLink ),
			//6 => sprintf( __('Source published. <a target = "_blank" href="%s">Test Source</a>', WPVR_LANG ), $testLink ),
			7  => __( 'Source saved.', WPVR_LANG ),
			8  => sprintf( __( 'Source updated. <a class="add-new-h2 wpvr_notice_link" target = "_blank" href="%s"><i class="fa fa-eye"></i>Test this source</a> <a class="add-new-h2 wpvr_notice_link" target = "_blank" href="%s"><i class="fa fa-bolt"></i>Run this source</a>', WPVR_LANG ), $testLink, $runLink ),
			//8 => sprintf( __('Source submitted. <a target="_blank" href="%s">Test Source</a>', WPVR_LANG ), $testLink ),
			9  => sprintf( __( 'Source updated. <a class="add-new-h2 wpvr_notice_link" target = "_blank" href="%s"><i class="fa fa-eye"></i>Test this source</a> <a class="add-new-h2 wpvr_notice_link" target = "_blank" href="%s"><i class="fa fa-bolt"></i>Run this source</a>', WPVR_LANG ), $testLink, $runLink ),
			//9 => sprintf( __('Source scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Test source</a>', WPVR_LANG ),
			// translators: Publish box date format, see http://php.net/date
			// date_i18n( __( 'M j, Y @ G:i' , WPVR_LANG ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( __( 'Source updated. <a class="add-new-h2 wpvr_notice_link" target = "_blank" href="%s"><i class="fa fa-eye"></i>Test this source</a> <a class="add-new-h2 wpvr_notice_link" target = "_blank" href="%s"><i class="fa fa-bolt"></i>Run this source</a>', WPVR_LANG ), $testLink, $runLink ),
			//10 => sprintf( __('Source draft updated. <a target="_blank" href="%s">Test source</a>', WPVR_LANG ), $testLink ),
		);
		
		return $messages;
	}
	
	/* Adding search filter for admin sources list screen */
	add_filter( 'posts_join', 'wpvr_source_search_join' );
	function wpvr_source_search_join( $join ) {
		global $pagenow, $wpdb;
		// I want the filter only when performing a search on edit page of Custom Post Type named "segnalazioni"
		if ( is_admin() && $pagenow == 'edit.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] == WPVR_SOURCE_TYPE && isset( $_GET['s'] ) && $_GET['s'] != '' ) {
			$join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
		}
		
		return $join;
	}
	
	add_filter( 'posts_where', 'wpvr_source_search_where' );
	function wpvr_source_search_where( $where ) {
		global $pagenow, $wpdb;
		// I want the filter only when performing a search on edit page of Custom Post Type named "segnalazioni"
		if ( is_admin() && $pagenow == 'edit.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] == WPVR_SOURCE_TYPE && isset( $_GET['s'] ) && $_GET['s'] != '' ) {
			$where = preg_replace(
				"/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
				"(" . $wpdb->posts . ".post_title LIKE $1) OR ( " . $wpdb->postmeta . ".meta_key='wpvr_source_name' AND " . $wpdb->postmeta . ".meta_value LIKE $1)", $where );
		}
		
		return $where;
	}
	
