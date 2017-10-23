<?php
	
	// You should be using the free addon Hooker ...
	
	//add_filter('wpvr_extend_video_query_injection', 'wpvr_escape_injection' , 100 , 2 );
	//function wpvr_escape_injection( $getOut , $query ){
	//	/* return true to escape WPVR imported videos injection */
	//}
	
	
	// add_filter( 'wpvr_extend_dataFillers_processing', 'wpvr_hooker_correct_facebook_video_url' , 10 , 4 );
	// function wpvr_hooker_correct_facebook_video_url( $data, $from, $to, $post_id ) {
	// 	if( $from == 'wpvr_video_service_url' ){
	// 		$data = str_replace('http://facebook' , 'https://www.facebook' , $data );
	// 		return $data ;
	// 	}
	//
	// 	return $data;
	// }
	
	