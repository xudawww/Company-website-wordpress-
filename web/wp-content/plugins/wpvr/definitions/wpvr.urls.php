<?php
	
	
	/* API URLs */

	//if( ! defined( 'WPVR_ACTIVATE_URL' ) ) define( 'WPVR_ACTIVATE_URL' , WPVR_API_URL . 'req/index.php' );
	//if( ! defined( 'WPVR_ADDONS_URL' ) ) define( 'WPVR_ADDONS_URL' , WPVR_API_URL.'q/products/' );

	//CAPI Connections
	if( ! defined( 'WPVR_API_URL' ) ) define( 'WPVR_API_URL' , "http://capi.pressaholic.com/" );
	if( ! defined( 'WPVR_API_REQ_URL' ) ) define( 'WPVR_API_REQ_URL' , WPVR_API_URL . 'q/' );
	if( ! defined( 'WPVR_API_REQ_KEY' ) ) define( 'WPVR_API_REQ_KEY' , 'lilI1Hoka2e60D8BmL97413AhnBjlVw4' );

	//AUTH Connections
	if( ! defined( 'WPVR_AUTH_URL' ) ) define( 'WPVR_AUTH_URL' , 'http://auth.pressaholic.com/latest/' );
	if( ! defined( 'WPVR_AUTH_KEY' ) ) define( 'WPVR_AUTH_KEY' , '1glV7XMCa4Cz8XKgYE5q' );
	if( ! defined( 'WPVR_AUTH_CUSTOM_LIST' ) ) define( 'WPVR_AUTH_CUSTOM_LIST' , 'WPVR users' );


	/* Internal URLs */
	if( ! defined( 'WPVR_URL' ) ) define( 'WPVR_URL' , plugin_dir_url( WPVR_MAIN_FILE ) );
	if( ! defined( 'WPVR_CRON_URL' ) ) define( 'WPVR_CRON_URL' , WPVR_URL . "wpvr.cron.php" );
	if( ! defined( 'WPVR_ACTIONS_URL' ) ) define( 'WPVR_ACTIONS_URL' , WPVR_URL . "includes/wpvr.actions.php" );

	if( ! defined( 'WPVR_OPTIONS_URL' ) ) define( 'WPVR_OPTIONS_URL' , WPVR_URL . "includes/wpvr.options.php" );
	if( ! defined( 'WPVR_SETTERS_URL' ) ) define( 'WPVR_SETTERS_URL' , WPVR_URL . "includes/wpvr.setters.php" );
	if( ! defined( 'WPVR_MANAGE_URL' ) ) define( 'WPVR_MANAGE_URL' , WPVR_URL . "includes/wpvr.manage.php" );
	if( ! defined( 'WPVR_IMPORT_URL' ) ) define( 'WPVR_IMPORT_URL' , WPVR_URL . "includes/wpvr.import.php" );
	if( ! defined( 'WPVR_FILLERS_URL' ) ) define( 'WPVR_FILLERS_URL' , WPVR_URL . "includes/wpvr.datafillers.php" );
	if( ! defined( 'WPVR_SITE_URL' ) ) define( 'WPVR_SITE_URL' , get_bloginfo( 'url' ) );
	if( ! defined( 'WPVR_DASHBOARD_URL' ) ) define( 'WPVR_DASHBOARD_URL' , admin_url( 'admin.php?page=wpvr' ) );
	if( ! defined( 'WPVR_ACTIONS_URL_ASYNC' ) ) define( 'WPVR_ACTIONS_URL_ASYNC' , WPVR_SITE_URL . "/wp-content/plugins/wpvr/includes/wpvr.actions.php" );
	
	/* External URLs */
	if( ! defined( 'WPVR_MAIN_URL' ) ) define( 'WPVR_MAIN_URL' , "http://wpvideorobot.com" );
	if( ! defined( 'WPVR_DOC_URL' ) ) define( 'WPVR_DOC_URL' , "http://doc.wpvideorobot.com" );
	if( ! defined( 'WPVR_SUPPORT_URL' ) ) define( 'WPVR_SUPPORT_URL' , "http://support.wpvideorobot.com" );
	if( ! defined( 'WPVR_DEMOS_URL' ) ) define( 'WPVR_DEMOS_URL' , "http://wpvideorobot.com/demos/" );
	if( ! defined( 'WPVR_STORE_URL' ) ) define( 'WPVR_STORE_URL' , "http://store.wpvideorobot.com" );
	if( ! defined( 'WPVR_STORE_URL_SSL' ) ) define( 'WPVR_STORE_URL_SSL' , "https://store.wpvideorobot.com" );
	if( ! defined( 'WPVR_CC_PAGE_URL' ) ) define( 'WPVR_CC_PAGE_URL' , "http://codecanyon.net/item/wordpress-video-robot-plugin/8619739?ref=pressaholic" );
	if( ! defined( 'WPVR_FONTAWESOME_CSS_URL' ) ) define( 'WPVR_FONTAWESOME_CSS_URL' , "https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" );

	/* Internal PATHs */
	if( ! defined( 'WPVR_PATH' ) ) define( 'WPVR_PATH' , plugin_dir_path( WPVR_MAIN_FILE ) );
	$x = explode( 'wpvr/' , WPVR_PATH );
	if( ! defined( 'WPVR_TMP_PATH' ) ) define( 'WPVR_TMP_PATH' , WPVR_PATH . 'tmp/' );
	if( ! defined( 'WPVR_LANG_FOLDER_PATH' ) ) define( 'WPVR_LANG_FOLDER_PATH' , WPVR_PATH . 'languages/' );
	if( ! defined( 'WPVR_CRON_PATH' ) ) define( 'WPVR_CRON_PATH' , WPVR_PATH . "wpvr.cron.php" );
	if( ! defined( 'WPVR_CRON_FILE_PATH' ) ) define( 'WPVR_CRON_FILE_PATH' , WPVR_PATH . "/assets/php/cron.txt" );
	if( ! defined( 'WPVR_PLUGINS_PATH' ) ) define( 'WPVR_PLUGINS_PATH' , $x[ 0 ] );
	if( ! defined( 'WPVR_ERROR_FILE' ) ) define( 'WPVR_ERROR_FILE' , WPVR_PATH . 'error.log' );
	if( ! defined( 'WPVR_DASH_PATH' ) ) define( 'WPVR_DASH_PATH' , WPVR_PATH . 'includes/wpvr.dashboard.php' );
	
	
	/* IMAGES */
	if( ! defined( 'WPVR_NO_THUMB' ) ) define( 'WPVR_NO_THUMB' , WPVR_URL . "assets/images/nothumb.jpg" );
	if( ! defined( 'WPVR_LOGO_SMALL' ) ) define( 'WPVR_LOGO_SMALL' , WPVR_URL . "assets/images/logo.padded.small.png" );
	
	/* CHANGELOG */
	if( ! defined( 'WPVR_CHANGELOG_URL_ENABLED' ) ) define( 'WPVR_CHANGELOG_URL_ENABLED' , TRUE );
	if( ! defined( 'WPVR_CHANGELOG_URL' ) ) define( 'WPVR_CHANGELOG_URL' , 'http://support.wpvideorobot.com/tutorials/wp-video-robot-1-9-released/' );
	
	
	
	
	
	