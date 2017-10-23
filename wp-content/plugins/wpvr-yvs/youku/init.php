<?php

	$vs = array();

	require_once( 'basics.php' );
	require_once( 'helpers.php' );
	require_once( 'types.php' );
	require_once( 'functions.php' );
	
	add_filter(
		'wpvr_extend_video_services' ,
		function ( $wpvr_vs ) use ( $vs ) {
			$wpvr_vs[ $vs['id'] ] = $vs ;
			return $wpvr_vs;
		}, 12 , 1 
	);



