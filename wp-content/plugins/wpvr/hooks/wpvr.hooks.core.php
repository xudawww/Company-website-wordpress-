<?php
	
	
	add_filter( 'wpvr_extend_saved_options', 'wpvr_check_saved_options', 100, 3 );
	function wpvr_check_saved_options( $args, $old_options, $new_options ) {
		
		
		$args['refresh']    = false;
		$args['param']      = '';
		$refreshing_options = array(
			'videoType',
		);
		foreach ( $refreshing_options as $option ) {
			if ( $old_options[ $option ] != $new_options[ $option ] ) {
				$args['refresh'] = true;
				$args['param']   = 'do_reset_tables';
			}
		}
		
		return $args;
	}
	
	/* Plugin Init Action Hook */
	add_action( 'init', 'wpvr_init' );
	function wpvr_init() {
		/*starting a PHP session if not already started */
		if ( ! session_id() ) {
			@session_start();
		}
		wpvr_mysql_install();
		add_image_size( 'wpvr_hard_thumb', 200, 150, true ); // Hard Crop Mode
		add_image_size( 'wpvr_soft_thumb', 200, 150 ); // Soft Crop Mode
		wpvr_capi_init();
	}
	
	add_action( 'plugins_loaded', 'wpvr_reload_tables_if_needed', 1000 );
	function wpvr_reload_tables_if_needed(){
	    global $wpvr_imported;
	    
	    if( isset( $_GET['do_reset_tables'] ) && $_GET['do_reset_tables'] == '1' ){
		    $wpvr_imported = wpvr_update_imported_videos();
	    }
    }
	add_action( 'plugins_loaded', 'wpvr_load_addons_activation_hooks', 5 );
	function wpvr_load_addons_activation_hooks() {
		$x           = explode( 'wpvr', WPVR_MAIN_FILE );
		$plugins_dir = $x[0];
		$addons_obj  = wpvr_get_addons( array(), false );
		if ( isset( $addons_obj['items'] ) && count( $addons_obj['items'] ) != 0 ) {
			foreach ( (array) $addons_obj['items'] as $addon ) {
				$addon_main_file = $plugins_dir . str_replace( '/', "\\", $addon->plugin_dir );
				register_activation_hook(
					$addon_main_file,
					function () use ( $addon ) {
						wpvr_start_plugin( $addon->id, $addon->version, false );
					}
				);
			}
		}
	}
	
	/* Loading WPVR translation files */
	add_action( 'plugins_loaded', 'wpvr_load_textdomain' );
	function wpvr_load_textdomain() {
		load_plugin_textdomain( WPVR_LANG, false, dirname( plugin_basename( __FILE__ ) ) . '/../languages/' );
	}
	
	/* Loading the WPVR Superwrap HEADER*/
	add_action( 'load-edit.php', 'wpvr_add_slug_edit_screen_header', - 1 );
	function wpvr_add_slug_edit_screen_header() {
		global $wpvr_options;
		
		if ( isset( $_GET['_wpnonce'] ) || isset( $_POST['_wpnonce'] ) ) {
			//Disable smooth screen on WP redirects
			return;
		}
		if ( $wpvr_options['smoothScreen'] === true ) {
			$screen = get_current_screen();
			if ( $screen->id == 'edit-' . WPVR_SOURCE_TYPE || $screen->id == 'edit-' . WPVR_VIDEO_TYPE ) {
				?><div class="wpvr_super_wrap" style=" transition:visibility 1s ease-in-out;visibility:hidden;"><!-- SUPER_WRAP --><?php
			}
		}
	}
	
	/* Loading the WPVR Superwrap FOOTER */
	add_action( 'admin_footer', 'wpvr_add_slug_edit_screen_footer', 999999999999 );
	function wpvr_add_slug_edit_screen_footer() {
		global $wpvr_options;
		
		if ( isset( $_GET['_wpnonce'] ) || isset( $_POST['_wpnonce'] ) ) {
			//Disable smooth screen on WP redirects
			return;
		}
		if ( $wpvr_options['smoothScreen'] === true ) {
			$screen = get_current_screen();
			if ( $screen->id == 'edit-' . WPVR_SOURCE_TYPE || $screen->id == 'edit-' . WPVR_VIDEO_TYPE ) {
				?><!-- SUPER_WRAP --><?php
			}
		}
	}
	
	/*Fix For pagination Category 1/2 */
	add_filter( 'request', 'wpvr_remove_page_from_query_string' );
	function wpvr_remove_page_from_query_string( $query_string ) {
		if ( isset( $query_string['name'] ) && $query_string['name'] == 'page' && isset( $query_string['page'] ) ) {
			unset( $query_string['name'] );
			// 'page' in the query_string looks like '/2', so i'm spliting it out
			list( $delim, $page_index ) = split( '/', $query_string['page'] );
			$query_string['paged'] = $page_index;
		}
		
		return $query_string;
	}
	
	/*Fix For pagination Category 2/2 */
	add_filter( 'request', 'wpvr_fix_category_pagination' );
	function wpvr_fix_category_pagination( $qs ) {
		if ( isset( $qs['category_name'] ) && isset( $qs['paged'] ) ) {
			$qs['post_type'] = get_post_types( $args = array(
				'public'   => true,
				'_builtin' => false,
			) );
			array_push( $qs['post_type'], 'post' );
		}
		
		return $qs;
	}
	
	/* Actions to be done on the activation of WPVR */
	register_activation_hook( WPVR_MAIN_FILE, 'wpvr_activation' );
	function wpvr_activation() {
		
		wpvr_reset_on_activation();
		
		wpvr_start_plugin( 'wpvr', WPVR_VERSION, false );
		
		if ( ! get_option( 'wpvr_flush_rewrite_rules_flag' ) ) {
			add_option( 'wpvr_flush_rewrite_rules_flag', true );
		}
		
		wp_schedule_event( time(), 'hourly', 'wpvr_hourly_event' );
		wpvr_save_errors( ob_get_contents() );
		//wpvr_set_debug( ob_get_contents() , TRUE );
		flush_rewrite_rules();
		
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( '/%postname%/' );
	}
	
	/* Actions to be done on the DEactivation of WPVR */
	register_deactivation_hook( WPVR_MAIN_FILE, 'wpvr_deactivation' );
	function wpvr_deactivation() {
		wp_clear_scheduled_hook( 'wpvr_hourly_event' );
		//flush_rewrite_rules();
		wpvr_save_errors( ob_get_contents() );
		//wpvr_set_debug( ob_get_contents() , TRUE );
	}
	
	register_deactivation_hook( WPVR_MAIN_FILE, 'flush_rewrite_rules' );
	
	/* Set Autoupdate Hook */
	add_action( 'init', 'wpvr_activate_autoupdate', 100 );
	function wpvr_activate_autoupdate() {
		global $wpvr_addons;
		
		//Check WPVR updates
		if ( WPVR_CHECK_PLUGIN_UPDATES ) {
			new wpvr_autoupdate_product (
				WPVR_VERSION, // Current Version of the product (ex 1.7.0)
				WPVR_SLUG, // Product Plugin Slug (ex wpvr/wpvr.php')
				false // Update zip url ? (ex TRUE or FALSE ),
			);
		}
		
		//Check for active addons updates
		if ( WPVR_CHECK_ADDONS_UPDATES ) {
			$addons_obj = wpvr_get_addons( array(), false );
			//d( $wpvr_addons );
			if ( ! is_multisite() ) {
				if ( isset( $addons_obj['items'] ) && count( $addons_obj['items'] ) != 0 ) {
					foreach ( (array) $addons_obj['items'] as $addon ) {
						//continue;
						if ( ! isset( $wpvr_addons[ $addon->id ] ) ) {
							continue;
						}
						if ( ! is_plugin_active( $addon->plugin_dir ) ) {
							continue;
						}
						$local_version = $wpvr_addons[ $addon->id ]['infos']['version'];
						//d( $local_version );
						//d( $addon->id );
						new wpvr_autoupdate_product (
							$local_version, // Current Version of the product (ex 1.7.0)
							$addon->plugin_dir, // Product Plugin Slug (ex wpvr/wpvr.php')
							false // Update zip url ? (ex TRUE or FALSE ),
						);
						
					}
				}
			} else {
				if ( isset( $addons_obj['items'] ) && count( $addons_obj['items'] ) != 0 ) {
					foreach ( (array) $addons_obj['items'] as $addon ) {
						if ( ! isset( $wpvr_addons[ $addon->id ] ) ) {
							continue;
						}
						
						//d( $addon->id );
						//d( is_plugin_active_for_network( $addon->plugin_dir ));
						
						if ( ! is_plugin_active_for_network( $addon->plugin_dir ) ) {
							continue;
						}
						
						
						$local_version = $wpvr_addons[ $addon->id ]['infos']['version'];
						//d( $local_version );
						//d( $addon->id );
						new wpvr_autoupdate_product (
							$local_version, // Current Version of the product (ex 1.7.0)
							$addon->plugin_dir, // Product Plugin Slug (ex wpvr/wpvr.php')
							false // Update zip url ? (ex TRUE or FALSE ),
						);
						
						//d( $addon );
						//$plugin = explode('/' , $addon->plugin_dir );
						//$plugin_data = get_plugin_data( $plugin[1] , $markup = true, $translate = true );
						//d( $plugin_data );
						
						
					}
				}
			}
		}
		
	}
	
	/* Activation */
	add_action( 'admin_footer', 'wpvr_check_customer' );
	
	/* Add query video custom post types on pre get posts action */
	add_filter( 'pre_get_posts', 'wpvr_include_custom_post_type_queries', 1000, 1 );
	function wpvr_include_custom_post_type_queries( $query ) {
		global $wpvr_options, $wpvr_private_cpt;
		$getOut = false;
		
		if ( ! $wpvr_options['addVideoType'] ) {
			return $query;
		}
		
		//d( DOING_AJAX );
		if ( $query->is_page ) {
			return $query;
		}
		//d( $query );
		if ( $query->is_attachment ) {
			return $query;
		}
		
		if ( ! defined( 'DOING_AJAX' ) || DOING_AJAX === false ) {
			if ( is_admin() ) {
				return $query;
			}
		}
		
		
		//Define Private Query Vars
		$wpvr_private_query_vars = apply_filters( 'wpvr_extend_private_query_vars', array(
			'product_cat',
			'download_artist',
			'download_tag',
			'download_category',
		) );
		
		// Define Private CPT
		$wpvr_private_cpt = apply_filters( 'wpvr_extend_private_cpt',
			( $wpvr_options['privateCPT'] == null ) ? array() : $wpvr_options['privateCPT']
		);
        
		
		// Escaping if using Private Query Vars
		foreach ( (array) $query->query_vars as $key => $val ) {
			if ( in_array( $key, $wpvr_private_query_vars ) ) {
				return $query;
			}
		}
		
		$supported = $query->get( 'post_type' );
		
		if ( is_array( $supported ) ) {
			foreach ( (array) $supported as $s ) {
				if ( in_array( $s, $wpvr_private_cpt ) ) {
					$getOut = true;
				}
			}
		} else {
			$getOut = in_array( $supported, $wpvr_private_cpt );
		}
		
		$getOut = apply_filters( 'wpvr_extend_video_query_injection', $getOut, $query );
		
		if ( $getOut === true ) {
			return $query;
		} elseif ( $supported == 'post' || $supported == '' ) {
			$supported = array( 'post', WPVR_VIDEO_TYPE );
		} elseif ( is_array( $supported ) ) {
			array_push( $supported, WPVR_VIDEO_TYPE );
		} elseif ( is_string( $supported ) ) {
			$supported = array( $supported, WPVR_VIDEO_TYPE );
		}
		// d( $getOut );
		$query->set( 'post_type', $supported );
		
		return $query;
		
	}