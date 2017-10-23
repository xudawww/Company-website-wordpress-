<?php
	/*
	Plugin Name: WP Video Robot
	Plugin URI: http://www.wpvideorobot.com
	Description: The Ultimate Wordpress Automated Video Importer
	Version: 1.9.1
	Author: pressaholic
	Author URI: http://www.pressaholic.com
	License: GPL2
	*/

	define( 'WPVR_MAIN_FILE' , __FILE__ );
	define( 'WPVR_VERSION' , '1.9.1' );
	

	/* User Custom Definitions */
	require_once( 'wpvr.config.php' );

	/* Plugin Default Definitions */
	require_once( 'wpvr.definitions.php' );

	/* Including functions definitions */
	require_once( 'wpvr.functions.php' );

	/* Including functions definitions */
	require_once( 'wpvr.hooks.php' );
	
	/* Include AJAX definitions */
	require_once( 'wpvr.ajax.php' );

	/* Including Sources CPT definitions */
	require_once( 'includes/wpvr.sources.php' );

	require_once( 'assets/php/RollingCurlX.php' );


	/* Including Videos CPT definitions */
	require_once( 'includes/wpvr.videos.php' );

	
	/* Including Sources & Videos Bulk Action */
	require_once( 'includes/wpvr.bulk.sources.php' );
	require_once( 'includes/wpvr.bulk.videos.php' );