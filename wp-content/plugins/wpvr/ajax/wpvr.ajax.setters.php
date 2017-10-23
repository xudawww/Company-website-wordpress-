<?php
	
	add_action( 'wp_ajax_nopriv_reset_video_tables', 'wpvr_reset_video_tables_ajax_function' );
	add_action( 'wp_ajax_reset_video_tables', 'wpvr_reset_video_tables_ajax_function' );
	function wpvr_reset_video_tables_ajax_function() {
		global $wpvr_imported;
		
		update_site_option( 'wpvr_deferred', array() );
		update_site_option( 'wpvr_deferred_ids', array() );
		update_site_option( 'wpvr_imported', array() );
		
		$imported      = wpvr_update_imported_videos();
		$wpvr_imported = get_site_option( 'wpvr_imported' );
		echo wpvr_get_json_response( 'ok' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_clear_deferred', 'wpvr_clear_deferred_ajax_function' );
	add_action( 'wp_ajax_clear_deferred', 'wpvr_clear_deferred_ajax_function' );
	function wpvr_clear_deferred_ajax_function() {
		update_site_option( 'wpvr_deferred', array() );
		update_site_option( 'wpvr_deferred_ids', array() );
		echo wpvr_get_json_response( 'ok' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_clear_unwanted', 'wpvr_clear_unwanted_ajax_function' );
	add_action( 'wp_ajax_clear_unwanted', 'wpvr_clear_unwanted_ajax_function' );
	function wpvr_clear_unwanted_ajax_function() {
		update_site_option( 'wpvr_unwanted', array() );
		update_site_option( 'wpvr_unwanted_ids', array() );
		echo wpvr_get_json_response( 'ok' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_reset_cron_token', 'wpvr_reset_cron_token_ajax_function' );
	add_action( 'wp_ajax_reset_cron_token', 'wpvr_reset_cron_token_ajax_function' );
	function wpvr_reset_cron_token_ajax_function() {
		update_site_option( 'wpvr_cron_token', '' );
		echo wpvr_get_json_response( 'ok' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_reset_wpvr_tokens', 'wpvr_reset_wpvr_tokens_ajax_function' );
	add_action( 'wp_ajax_reset_wpvr_tokens', 'wpvr_reset_wpvr_tokens_ajax_function' );
	function wpvr_reset_wpvr_tokens_ajax_function() {
		update_site_option( 'wpvr_tokens', '' );
		echo wpvr_get_json_response( 'ok' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_reset_cron_data', 'wpvr_reset_cron_data_ajax_function' );
	add_action( 'wp_ajax_reset_cron_data', 'wpvr_reset_cron_data_ajax_function' );
	function wpvr_reset_cron_data_ajax_function() {
		file_put_contents( WPVR_CRON_FILE_PATH, '' );
		echo wpvr_get_json_response( 'ok' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_clear_errors', 'wpvr_clear_errors_ajax_function' );
	add_action( 'wp_ajax_clear_errors', 'wpvr_clear_errors_ajax_function' );
	function wpvr_clear_errors_ajax_function() {
		update_site_option( 'wpvr_errors', array() );
		echo wpvr_get_json_response( 'ok' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_reset_notices', 'wpvr_reset_notices_ajax_function' );
	add_action( 'wp_ajax_reset_notices', 'wpvr_reset_notices_ajax_function' );
	function wpvr_reset_notices_ajax_function() {
		update_site_option( 'wpvr_notices', array() );
		
		echo wpvr_get_json_response( 'ok' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_show_errors', 'wpvr_show_errors_ajax_function' );
	add_action( 'wp_ajax_show_errors', 'wpvr_show_errors_ajax_function' );
	function wpvr_show_errors_ajax_function() {
		update_site_option( 'wpvr_notices', array() );
		echo wpvr_get_json_response( 'ok' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_remove_tmp', 'wpvr_remove_tmp_ajax_function' );
	add_action( 'wp_ajax_remove_tmp', 'wpvr_remove_tmp_ajax_function' );
	function wpvr_remove_tmp_ajax_function() {
		wpvr_remove_tmp_files();
		echo wpvr_get_json_response( 'ok' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_setter_reset_activation', 'wpvr_reset_activation_setter_ajax_function' );
	add_action( 'wp_ajax_setter_reset_activation', 'wpvr_reset_activation_setter_ajax_function' );
	function wpvr_reset_activation_setter_ajax_function() {
		update_site_option( 'wpvr_activation', '' );
		echo wpvr_get_json_response( 'ok' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_update_all_thumbnails_prepare', 'wpvr_update_all_thumbnails_prepare_ajax_function' );
	add_action( 'wp_ajax_update_all_thumbnails_prepare', 'wpvr_update_all_thumbnails_prepare_ajax_function' );
	function wpvr_update_all_thumbnails_prepare_ajax_function() {
		global $wpdb ;
		$post_ids = $wpdb->get_results("
			select 
				ID, post_title
			FROM 
				{$wpdb->posts} P 
			WHERE 
				P.post_type = '".WPVR_VIDEO_TYPE."'
				AND P.post_status in('pending','publish')
		", ARRAY_A );
		
		echo wpvr_get_json_response(
			array(
				'items' => $post_ids,
			), 1,
			sprintf( __( '%s videos found.', WPVR_LANG ), '<strong>' . count( $post_ids ) . '</strong>' ) .
			'<br/>' . __( 'Updating all those thumbnails might take some time. Do you want to continue?', WPVR_LANG )
		);
		die();
	}
	
	add_action( 'wp_ajax_nopriv_update_single_thumbnail', 'wpvr_update_single_thumbnail_ajax_function' );
	add_action( 'wp_ajax_update_single_thumbnail', 'wpvr_update_single_thumbnail_ajax_function' );
	function wpvr_update_single_thumbnail_ajax_function() {
		$post_id = $_POST['post']['ID'];
		$count = wpvr_bulk_update_thumbs( array( $post_id ) ) ;
		if( $count['errors'] != 0 ){
			echo wpvr_get_json_response( false , 0 , "Error update the thumbnail of post #{$post_id}");
		}
		
		echo wpvr_get_json_response( true , 1 , "Update done for post #{$post_id}");
		
		die();
	}
	
	//add_action( 'wp_ajax_nopriv_@@@' , 'wpvr_@@@_ajax_function' );
	//add_action( 'wp_ajax_@@@' , 'wpvr_@@@_ajax_function' );
	//function wpvr_@@@_ajax_function(){
	//
	//                 die();
	//}
