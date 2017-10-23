<?php
	if( isset( $_GET[ 'wpvr_wpload' ] ) || isset( $_POST[ 'wpvr_wpload' ] ) ) {
		if( !defined('DOING_AJAX') ) define( 'DOING_AJAX' , TRUE );
		//define('WP_ADMIN', true );
		$wpload = 'wp-load.php';
		while( ! is_file( $wpload ) ) {
			if( is_dir( '..' ) ) chdir( '..' );
			else die( 'EN: Could not find WordPress! FR : Impossible de trouver WordPress !' );
		}
		require_once( $wpload );
	}
	
	add_action( 'wpvr_screen_addon_options_top' , 'wpvr_yvs_add_custom_addon_buttons' , 100 , 2 );
	function wpvr_yvs_add_custom_addon_buttons( $addon_id , $addon ) {
		if ( $addon_id != WPVRYVS_ID ) {
			return FALSE;
		}
		$test_button
			= '
			<button
				class="wpvr_button pull-left wpvr_black_button wpvr_load_asyncr_ajax "
				json = "1"
				method = "click"
				action="import_sample_sources_youku"
				data-stoune="koko"
			>
				<i class="wpvr_button_icon fa fa-plus-circle"></i>
					' . __( 'Import Sample Sources' , WPVRYVS_ID ) . '
			</button>
			';
		echo $test_button;
	}
	
	add_action( 'wp_ajax_import_sample_sources_youku' , 'wpvr_import_sample_sources_youku_ajax_function' );
	add_action( 'wp_ajax_nopriv_import_sample_sources_youku' , 'wpvr_import_sample_sources_youku_ajax_function' );
	function wpvr_import_sample_sources_youku_ajax_function() {
		echo wpvr_import_sample_sources('youku');
		die();
	}