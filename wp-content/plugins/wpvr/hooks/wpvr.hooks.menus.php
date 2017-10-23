<?php
	
	/* ADd Plugins Page WPVR menu */
	add_filter( 'plugin_action_links_' . plugin_basename( WPVR_MAIN_FILE ), 'wpvr_add_wpvr_links_to_plugins_page' );
	function wpvr_add_wpvr_links_to_plugins_page( $links ) {
		$links[] = '<br/>';
		$links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=wpvr-welcome' ) ) . '" class="wpvr_first_actions_link" >' . ___( 'Welcome', true ) . '</a>';
		$links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=wpvr' ) ) . '">' . ___( 'Dashboard', true ) . '</a>';
		$links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=wpvr-options' ) ) . '">' . ___( 'Options', true ) . '</a>';
		$links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=wpvr-licences' ) ) . '">' . ___( 'Licenses', true ) . '</a>';
		
		return $links;
	}
	
	
	/* Define WPVR menu items */
	add_action( 'admin_menu', 'wpvr_admin_actions' );
	function wpvr_admin_actions() {
		$can_show_menu_links = wpvr_can_show_menu_links();
		if ( $can_show_menu_links === true ) {
			
			add_menu_page(
				WPVR_LANG,
				'WP Video Robot',
				'read',
				WPVR_LANG,
				'wpvr_action_render',
				WPVR_URL . "assets/images/wpadmin.icon.png"
			//'dashicons-lightbulb'
			);
			
			add_submenu_page(
				WPVR_LANG,
				___( 'WELCOME | WP video Robot', true ),
				___( 'Welcome', true ),
				'read',
				'wpvr-welcome',
				'wpvr_welcome_render'
			);
			
			add_submenu_page(
				WPVR_LANG,
				___( 'VIDEOS | WP video Robot', true ),
				___( 'Manage Videos', true ),
				'read',
				'wpvr-manage',
				'wpvr_manage_render'
			);
			
			add_submenu_page(
				WPVR_LANG,
				___( 'OPTIONS | WP video Robot', true ),
				___( 'Manage Options', true ),
				'read',
				'wpvr-options',
				'wpvr_options_render'
			);
			
			// add_submenu_page(
			// 	WPVR_LANG,
			// 	___( 'LOG | WP video Robot', true ),
			// 	___( 'Activity Logs', true ),
			// 	'read',
			// 	'wpvr-log',
			// 	'wpvr_log_render'
			// );
			
			add_submenu_page(
				WPVR_LANG,
				___( 'ACTIVITY LOGS | WP video Robot', true ),
				___( 'Activity Logs', true ),
				'read',
				'wpvr-logs',
				'wpvr_logs_render'
			);
			
			add_submenu_page(
				WPVR_LANG,
				___( 'DEFERRED VIDEOS | WP video Robot', true ),
				___( 'Deferred Videos', true ),
				'read',
				'wpvr-deferred',
				'wpvr_deferred_render'
			);
			
			add_submenu_page(
				WPVR_LANG,
				___( 'UNWANTED VIDEOS | WP Video Robot', true ),
				___( 'Unwanted Videos', true ),
				'read',
				'wpvr-unwanted',
				'wpvr_unwanted_render'
			);
			
			add_submenu_page(
				WPVR_LANG,
				___( 'Import | WP video Robot', true ),
				___( 'Import Panel', true ),
				'read',
				'wpvr-import',
				'wpvr_import_render'
			);
			
			add_submenu_page(
				WPVR_LANG,
				___( 'Licences | WP video Robot', true ),
				___( 'Manage Licences', true ),
				'read',
				'wpvr-licences',
				'wpvr_licences_render'
			);
			
			if ( WPVR_DEV_MODE === true || WPVR_ENABLE_SANDBOX === true ) {
				add_submenu_page(
					WPVR_LANG,
					___( 'Sandbox | WP Video Robot', true ),
					___( 'Sandbox', true ),
					'read',
					'wpvr-sandbox',
					'wpvr_sandbox_render'
				);
			}
			
			/* Removing Main WPVR Menu Item */
			global $menu;
			global $submenu;
			$submenu[ WPVR_LANG ][0][0] = ___( 'Plugin Dashboard', true );
			//remove_submenu_page( WPVR_LANG , true );
		}
	}
	
	/* Add Menu of Addons */
	add_action( 'admin_menu', 'wpvr_addons_admin_actions' );
	function wpvr_addons_admin_actions() {
		if ( WPVR_ENABLE_ADDONS === true ) {
			
			$can_show_menu_links = wpvr_can_show_menu_links();
			if ( $can_show_menu_links === true ) {
				add_menu_page(
					'WPVRM',
					'WPVR Addons',
					'read',
					'wpvr-addons',
					'wpvr_addons_render',
					WPVR_URL . "assets/images/wpadmin.icon.png"
				);
				add_submenu_page(
					'wpvr-addons',
					___( 'ADDONS | WP video Robot', true ),
					___( 'Browse Addons', true ),
					'read',
					'wpvr-addons',
					'wpvr_addons_render'
				);
				
				/* Removing Main WPVR Menu Item */
				global $menu, $submenu, $wpvr_addons;
				//$submenu['wpvr-addons'][0][0] = ___('Browse Addons', true );
			}
		}
	}
	
	/* Add Manage Videos Link To Videos Admin Menu */
	add_action( 'admin_menu', 'wpvr_add_manage_videos_link', 1 );
	function wpvr_add_manage_videos_link() {
		add_submenu_page(
			WPVR_VIDEO_TYPE == 'post' ? 'edit.php' : 'edit.php?post_type=' . WPVR_VIDEO_TYPE,
			'VIDEOS',
			___( 'Manage Videos', true ),
			'manage_options',
			'wpvr_manage_videos',
			'wpvr_manage_videos_render'
		);
	}
	
	
	add_filter( 'custom_menu_order', 'wpvr_reorder_addons_submenu' );
	function wpvr_reorder_addons_submenu( $menu_ord ) {
		global $submenu;
		$a = $b = $c = array();
		if ( ! isset( $submenu['wpvr-addons'] ) ) {
			return $menu_ord;
		}
		
		foreach ( (array) $submenu['wpvr-addons'] as $link ) {
			if ( $link[2] == 'wpvr-addons' ) {
				$a[] = $link;
			} elseif ( strpos( $link[0], '+' ) != false ) {
				$a[] = $link;
			} else {
				$b[] = $link;
			}
		}
		$submenu['wpvr-addons'] = array_merge( $a, $b );
		
		return $menu_ord;
	}
	
	/* Define WPVR menu items */
	add_action( 'admin_bar_menu', 'wpvr_adminbar_actions' );
	function wpvr_adminbar_actions() {
		$can_show_menu_links = wpvr_can_show_menu_links();
		
		if ( $can_show_menu_links === true ) {
			add_menu_page(
				WPVR_LANG,
				'WP Video Robot',
				'read',
				WPVR_LANG,
				'wpvr_action_render',
				WPVR_URL . "assets/images/wpadmin.icon.png"
			//'dashicons-lightbulb'
			);
			
			add_submenu_page(
				WPVR_LANG,
				___( 'WELCOME | WP video Robot', true ),
				___( 'Welcome', true ),
				'read',
				'wpvr-welcome',
				'wpvr_welcome_render'
			);
			
			add_submenu_page(
				WPVR_LANG,
				___( 'VIDEOS | WP video Robot', true ),
				___( 'Manage Videos', true ),
				'read',
				'wpvr-manage',
				'wpvr_manage_render'
			);
			
			add_submenu_page(
				WPVR_LANG,
				___( 'OPTIONS | WP video Robot', true ),
				___( 'Manage Options', true ),
				'read',
				'wpvr-options',
				'wpvr_options_render'
			);
			add_submenu_page(
				WPVR_LANG,
				___( 'LOG | WP video Robot', true ),
				___( 'Activity Logs', true ),
				'read',
				'wpvr-log',
				'wpvr_log_render'
			);
			
			add_submenu_page(
				WPVR_LANG,
				___( 'ACTIVITY LOGS | WP video Robot', true ),
				___( 'Activity Logs NEW', true ),
				'read',
				'wpvr-logs',
				'wpvr_logs_render'
			);
			
			add_submenu_page(
				WPVR_LANG,
				___( 'DEFERRED VIDEOS | WP video Robot', true ),
				___( 'Deferred Videos', true ),
				'read',
				'wpvr-deferred',
				'wpvr_deferred_render'
			);
			
			add_submenu_page(
				WPVR_LANG,
				___( 'UNWANTED VIDEOS | WP Video Robot', true ),
				___( 'Unwanted Videos', true ),
				'read',
				'wpvr-unwanted',
				'wpvr_unwanted_render'
			);
			
			add_submenu_page(
				WPVR_LANG,
				___( 'Import | WP video Robot', true ),
				___( 'Import Panel', true ),
				'read',
				'wpvr-import',
				'wpvr_import_render'
			);
			add_submenu_page(
				WPVR_LANG,
				___( 'Licences | WP video Robot', true ),
				___( 'Manage Licences', true ),
				'read',
				'wpvr-licences',
				'wpvr_licences_render'
			);
			if ( WPVR_DEV_MODE === true || WPVR_ENABLE_SANDBOX === true ) {
				add_submenu_page(
					WPVR_LANG,
					___( 'Sandbox | WP Video Robot', true ),
					___( 'Sandbox', true ),
					'read',
					'wpvr-sandbox',
					'wpvr_sandbox_render'
				);
			}
			
			
			/* Removing Main WPVR Menu Item */
			global $menu;
			global $submenu;
			$submenu[ WPVR_LANG ][0][0] = ___( 'Plugin Dashboard', true );
			//remove_submenu_page( WPVR_LANG , true );
		}
	}
	
	/* Add Menu of Addons */
	add_action( 'admin_bar_menu', 'wpvr_addons_adminbar_actions', 100 );
	function wpvr_addons_adminbar_actions() {
		if ( ! WPVR_ENABLE_ADMINBAR_MENU ) {
			return false;
		}
		if ( wpvr_can_show_menu_links() ) {
			global $wp_admin_bar;
			
			// WPVR MAIN TOP BUTTON
			$wp_admin_bar->add_menu( array(
				'id'    => 'wpvr_ab',
				'title' => strtoupper( ___( 'WP Video Robot', true ) ),
				'href'  => admin_url( 'admin.php?page=wpvr' ),
			) );
			
			// DASHBOARD TOP MENU
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab',
				'id'     => 'wpvr_ab_dashboard',
				'title'  => ___( 'WPVR DASHBOARD', true ),
				'href'   => admin_url( 'admin.php?page=wpvr' ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_dashboard',
				'id'     => 'wpvr_ab_dashboard_content',
				'title'  => ___( 'Sources & Videos', true ),
				'href'   => admin_url( 'admin.php?page=wpvr&section=content' ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_dashboard',
				'id'     => 'wpvr_ab_dashboard_automation',
				'title'  => ___( 'Automation Dashboard', true ),
				'href'   => admin_url( 'admin.php?page=wpvr&section=automation' ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_dashboard',
				'id'     => 'wpvr_ab_dashboard_duplicates',
				'title'  => ___( 'Track Duplicates', true ),
				'href'   => admin_url( 'admin.php?page=wpvr&section=duplicates' ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_dashboard',
				'id'     => 'wpvr_ab_dashboard_datafillers',
				'title'  => ___( 'DataFillers', true ),
				'href'   => admin_url( 'admin.php?page=wpvr&section=datafillers' ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_dashboard',
				'id'     => 'wpvr_ab_dashboard_setters',
				'title'  => ___( 'Admin Actions', true ),
				'href'   => admin_url( 'admin.php?page=wpvr&section=setters' ),
			) );
			
			// OPTIONS TOP MENU
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab',
				'id'     => 'wpvr_ab_options',
				'title'  => ___( 'WPVR OPTIONS', true ),
				'href'   => admin_url( 'admin.php?page=wpvr-options' ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_options',
				'id'     => 'wpvr_ab_options_general',
				'title'  => ___( 'General options', true ),
				'href'   => admin_url( 'admin.php?page=wpvr-options&section=general' ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_options',
				'id'     => 'wpvr_ab_options_fetching',
				'title'  => ___( 'Fetching Options', true ),
				'href'   => admin_url( 'admin.php?page=wpvr-options&section=fetching' ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_options',
				'id'     => 'wpvr_ab_options_posting',
				'title'  => ___( 'Posting Options', true ),
				'href'   => admin_url( 'admin.php?page=wpvr-options&section=posting' ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_options',
				'id'     => 'wpvr_ab_options_integration',
				'title'  => ___( 'Integration Options', true ),
				'href'   => admin_url( 'admin.php?page=wpvr-options&section=integration' ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_options',
				'id'     => 'wpvr_ab_options_automation',
				'title'  => ___( 'Automation Options', true ),
				'href'   => admin_url( 'admin.php?page=wpvr-options&section=automation' ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_options',
				'id'     => 'wpvr_ab_options_api_keys',
				'title'  => ___( 'API Access', true ),
				'href'   => admin_url( 'admin.php?page=wpvr-options&section=api_keys' ),
			) );
			
			// SOURCES TOP MENU
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab',
				'id'     => 'wpvr_ab_sources',
				'title'  => strtoupper( ___( 'WPVR Sources', true ) ),
				'href'   => admin_url( 'edit.php?post_type=' . WPVR_SOURCE_TYPE ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_sources',
				'id'     => 'wpvr_ab_sources_all',
				'title'  => ___( 'All Sources', true ),
				'href'   => admin_url( 'edit.php?post_type=' . WPVR_SOURCE_TYPE ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_sources',
				'id'     => 'wpvr_ab_sources_new',
				'title'  => ___( 'New Source', true ),
				'href'   => admin_url( 'post-new.php?post_type=' . WPVR_SOURCE_TYPE ),
			) );
			
			// VIDEOS TOP MENU
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab',
				'id'     => 'wpvr_ab_videos',
				'title'  => strtoupper( ___( 'WPVR Videos', true ) ),
				'href'   => admin_url( 'edit.php?post_type=' . WPVR_VIDEO_TYPE ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_videos',
				'id'     => 'wpvr_ab_videos_all',
				'title'  => ___( 'All Videos', true ),
				'href'   => admin_url( 'edit.php?post_type=' . WPVR_VIDEO_TYPE ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_videos',
				'id'     => 'wpvr_ab_videos_new',
				'title'  => ___( 'New Video', true ),
				'href'   => admin_url( 'post-new.php?post_type=' . WPVR_VIDEO_TYPE ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_videos',
				'id'     => 'wpvr_ab_videos_manage',
				'title'  => ___( 'Manage Videos', true ),
				'href'   => admin_url( 'admin.php?page=wpvr-manage' ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_videos',
				'id'     => 'wpvr_ab_videos_deferred',
				'title'  => ___( 'Deferred Videos', true ),
				'href'   => admin_url( 'admin.php?page=wpvr-deferred' ),
			) );
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab_videos',
				'id'     => 'wpvr_ab_videos_unwanted',
				'title'  => ___( 'Unwanted Videos', true ),
				'href'   => admin_url( 'admin.php?page=wpvr-unwanted' ),
			) );
			
			//ADDONS TOP MENU
			if ( WPVR_ENABLE_ADDONS === true ) {
				$wp_admin_bar->add_menu( array(
					'parent' => 'wpvr_ab',
					'id'     => 'wpvr_ab_addons',
					'title'  => strtoupper( ___( 'WPVR Addons', true ) ),
					'href'   => admin_url( 'admin.php?page=wpvr-addons' ),
				) );
				$wp_admin_bar->add_menu( array(
					'parent' => 'wpvr_ab_addons',
					'id'     => 'wpvr_ab_addons_browse',
					'title'  => ___( 'Browse Addons', true ),
					'href'   => admin_url( 'admin.php?page=wpvr-addons' ),
				) );
				global $wpvr_addons;
				foreach ( (array) $wpvr_addons as $addon ) {
					//d( $addon );
					
					$wp_admin_bar->add_node( array(
						'parent' => 'wpvr_ab_addons',
						'id'     => 'adminbar-' . $addon['infos']['id'],
						'title'  => ' - ' . $addon['infos']['title'],
						'href'   => admin_url( 'admin.php?page=' . $addon['infos']['id'] ),
					) );
				}
			}
			
			// LICENSES TOP MENU
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab',
				'id'     => 'wpvr_ab_licenses',
				'title'  => ___( 'WPVR Licenses', true ),
				'href'   => admin_url( 'admin.php?page=wpvr-licences' ),
			) );
			
			// ACTIVITY LOGS TOP MENU
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpvr_ab',
				'id'     => 'wpvr_ab_logs',
				'title'  => ___( 'WPVR Activity Logs', true ),
				'href'   => admin_url( 'admin.php?page=wpvr-logs' ),
			) );
			
			// SANDBOX
			if ( WPVR_DEV_MODE === true || WPVR_ENABLE_SANDBOX === true ) {
				$wp_admin_bar->add_menu( array(
					'parent' => 'wpvr_ab',
					'id'     => 'wpvr_ab_sandbox',
					'title'  => ___( 'Sandbox', true ),
					'href'   => admin_url( 'admin.php?page=wpvr-sandbox' ),
				) );
			}
			
			if ( WPVR_DEV_MODE ) {
				$wp_admin_bar->add_menu( array(
					'id'    => 'wpvr_dev_mode',
					'title' => '<span class="wpvr_topbar_badge warning orange wpvr_show_when_loaded" style="display:none;">  WPVR DEV MODE </span>',
					'href'  => '#',
				) );
			}
			
			if ( WPVR_IS_DEMO ) {
				$wp_admin_bar->add_menu( array(
					'id'    => 'wpvr_demo_mode',
					'title' => '<span class="wpvr_topbar_badge play green wpvr_show_when_loaded" style="display:none;"> WPVR DEMO </span>',
					'href'  => '#',
				) );
			}
			
		}
	}
	
	/* restricting Actions for demo user */
	if ( WPVR_IS_DEMO_SITE === true ) {
		add_action( 'admin_init', 'wpvr_remove_menu_pages' );
		if ( ! function_exists( 'wpvr_remove_menu_pages' ) ) {
			function wpvr_remove_menu_pages() {
				
				global $user_ID;
				
				if ( $user_ID == WPVR_IS_DEMO_USER ) {
					define( 'DISALLOW_FILE_EDIT', true );
					remove_menu_page( 'plugins.php' );
					remove_menu_page( 'users.php' );
					remove_menu_page( 'tools.php' );
				}
			}
		}
	}
	
	
	/* Rendering Options */
	function wpvr_manage_render() {
		if ( ! WPVR_NONADMIN_CAP_MANAGE && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();
			
			return false;
		}
		include( WPVR_PATH . 'includes/wpvr.manage.php' );
	}
	
	
	/* Rendering Addons */
	function wpvr_welcome_render() {
		if ( ! WPVR_NONADMIN_CAP_MANAGE && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();
			
			return false;
		}
		include( WPVR_PATH . 'includes/wpvr.welcome.php' );
	}
	
	/* Rendering Addons */
	function wpvr_addons_render() {
		if ( ! WPVR_NONADMIN_CAP_MANAGE && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();
			
			return false;
		}
		//global $addon_id;
		//$addon_id = 'wpvrm';
		include( WPVR_PATH . 'addons/wpvr.addons.php' );
	}
	
	/* Rendering Licences */
	function wpvr_licences_render() {
		if ( ! WPVR_NONADMIN_CAP_MANAGE && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();
			
			return false;
		}
		include( WPVR_PATH . 'includes/wpvr.licences.php' );
	}
	
	
	function wpvr_options_render() {
		if ( ! WPVR_NONADMIN_CAP_OPTIONS && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();
			
			return false;
		}
		include( WPVR_PATH . 'options/wpvr.options.php' );
	}
	
	/* Rendering Logs */
	function wpvr_log_render() {
		if ( ! WPVR_NONADMIN_CAP_LOGS && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();
			
			return false;
		}
		include( WPVR_PATH . 'includes/wpvr.log.php' );
	}
	
	function wpvr_logs_render() {
		if ( ! WPVR_NONADMIN_CAP_LOGS && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();
			
			return false;
		}
		include( WPVR_PATH . 'includes/wpvr.logs.php' );
	}
	
	/* Rendering Deferred */
	function wpvr_deferred_render() {
		if ( ! WPVR_NONADMIN_CAP_DEFERRED && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();
			
			return false;
		}
		include( WPVR_PATH . 'includes/wpvr.deferred.php' );
	}
	
	/* Rendering Deferred */
	function wpvr_unwanted_render() {
		if ( ! WPVR_NONADMIN_CAP_DEFERRED && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();
			
			return false;
		}
		include( WPVR_PATH . 'includes/wpvr.unwanted.php' );
	}
	
	/* Rendering Actions */
	function wpvr_action_render() {
		if ( ! WPVR_NONADMIN_CAP_ACTIONS && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();
			
			return false;
		}
		global $wpvr_pages;
		$wpvr_pages = true;
		include( WPVR_PATH . 'includes/wpvr.actions.php' );
	}
	
	/* Rendering Import */
	function wpvr_import_render() {
		if ( ! WPVR_NONADMIN_CAP_IMPORT && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();
			
			return false;
		}
		include( WPVR_PATH . 'includes/wpvr.import.php' );
	}
	
	function wpvr_manage_videos_render() {
		if ( ! WPVR_NONADMIN_CAP_IMPORT && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
			wpvr_refuse_access();
			
			return false;
		}
		include( WPVR_PATH . 'includes/wpvr.manage.php' );
	}
	
	function wpvr_sandbox_render() {
		echo "<h2>WP VIDEO ROBOT SANDBOX</h2><br/><br/>";
		include( WPVR_PATH . 'wpvr.sandbox.php' );
	}