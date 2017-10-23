<?php
	/*
	Plugin Name: WP Video Robot - Youku Video Service
	Plugin URI: https://store.wpvideorobot.com/addons/youku-video-service/
	Description: Import videos from youku.com.
	Version: 1.9
	Author: pressaholic
	Author URI: http://www.pressaholic.com
	License: GPL2
	*/
	add_action( 'plugins_loaded', 'wpvryvs_addon_init', 10 );
	function wpvryvs_addon_init() {
		
		define( 'WPVRYVS_MIN_VERSION' , '1.9' );
		define( 'WPVRYVS_VERSION' , '1.9' );
		
		require_once('define.php');
		require_once('hooks.php');
	}


	add_action( 'plugins_loaded', 'wpvryvs_addon_init_service', 4 );
	function wpvryvs_addon_init_service() {
		add_action('wpvr_init_extended_video_services' , 'wpvryvs_init_service' , 1);
		function wpvryvs_init_service(){
			$yvs_path = plugin_dir_path( __FILE__ );
			$yvs_slot = 'wpvr-yvs-options';
			
			$slot = get_option( $yvs_slot );
			if( $slot != '' && $slot['addon_enabled'] === true ) {
				require_once( $yvs_path . 'youku/init.php' );
			}
		}
	}
	
	