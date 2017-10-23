<?php
	
	/* Debug Assets */
	require_once( 'assets/php/dBug.php' );
	require_once( 'assets/php/kint/Kint.class.php' );
	wpvrKint::$theme = 'aante-light';
	function _d( $var ) {
		new dBug( $var );
	}
	
	function ___( $string, $ucwords = false ) {
		if ( $ucwords === true ) {
			return ucwords( __( $string, WPVR_LANG ) );
		} else {
			return __( $string, WPVR_LANG );
		}
	}
	
	/* Predef Functions */
	require_once( 'definitions/wpvr.predef.php' );
	
	/* Defining Constants */
	require_once( 'definitions/wpvr.constants.php' );
	
	/* Defining plugin links */
	require_once( 'definitions/wpvr.urls.php' );
	
	/* Including Services definitons */
	add_action( 'plugins_loaded', 'wpvr_load_services_init', 5 );
	function wpvr_load_services_init() {
		
		
		/* Definings the plugin global variables */
		require_once( 'definitions/wpvr.globals.php' );
		
		/* Wrapping up definitions */
		require_once( 'definitions/wpvr.set.before.php' );
		
		
		/* Including Services definitons */
		require_once( 'definitions/wpvr.services.php' );
		
		/* Definings the plugin default options values */
		require_once( 'definitions/wpvr.defaults.php' );
		
		/* Loading dataFillers presets */
		require_once( 'definitions/wpvr.presets.php' );
		
		/* Wrapping up definitions */
		require_once( 'definitions/wpvr.set.after.php' );
		
	}




	
	