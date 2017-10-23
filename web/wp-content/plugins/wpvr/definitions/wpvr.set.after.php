<?php
	global
	$wpvr_tokens ,
	$wpvr_default_tokens ,
	$wpvr_dynamics ,
	$wpvr_roles;


	$wpvr_tokens = get_option( 'wpvr_tokens' );
	if( $wpvr_tokens == '' ) {
		update_option( 'wpvr_tokens' , $wpvr_default_tokens );
		$wpvr_tokens = $wpvr_default_tokens;
	}


	/* Dynamic data variable */
	$wpvr_dynamics = array(
		'video_taxonomies' => array() ,

		'player_options' => array() ,

		'player_tags'    => array(
			'force_autoplay_disable' => FALSE ,
			'before_outer'           => '' ,
			'after_outer'            => '' ,
			'after_inner'            => '' ,
			'before_inner'           => '' ,
			'embed_class'            => '' ,
		) ,
		'player_classes' => array() ,
		'content_tags'   => array(
			'before' => '' ,
			'after'  => '' ,
		) ,
	);

	$wpvr_dynamics = apply_filters( 'wpvr_extend_dynamics' , $wpvr_dynamics );

	/* Getting available Roles on current WP Installation */
	$wpvr_roles = wpvr_get_available_roles();

