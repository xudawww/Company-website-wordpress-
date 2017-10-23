<?php

	global $wpvr_datafillers_presets;
	

	/* BeeTube Integration */
	$wpvr_datafillers_presets[ 'beetube' ] = array(
		'id'    => 'beetube' ,
		'label' => 'BEETUBE Theme Integration' ,
		'items' => array(
			array(
				'from' => 'wpvr_video_service_url' ,
				'to'   => 'jtheme_video_url' ,
			) ,
			array(
				'from' => 'wpvr_video_service_url' ,
				'to'   => 'jtheme_video_poster' ,
			) ,
			array(
				'from' => 'wpvr_video_embed_code' ,
				'to'   => 'jtheme_video_code' ,
			) ,
			/*array(
				'from' 			=> 'custom_data',
				'from_custom' 	=> 'my_custom_string',
				'to' 			=> 'my_custom_field',
			),
			*/
		) ,
	);
	
	/* DETUBE Integration */
	$wpvr_datafillers_presets[ 'detube' ] = array(
		'id'    => 'detube' ,
		'label' => 'DETUBE Theme Integration' ,
		'items' => array(
			array(
				'from' => 'wpvr_video_service_url' ,
				'to'   => 'dp_video_url' ,
			) ,
			array(
				'from' => 'wpvr_video_service_thumb' ,
				'to'   => 'dp_video_poster' ,
			) ,
			array(
				'from' => 'wpvr_video_embed_code' ,
				'to'   => 'dp-video-code' ,
			) ,
		) ,
	);
	
	/* BeeTube Integration */
	$wpvr_datafillers_presets[ 'truemag' ] = array(
		'id'    => 'truemag' ,
		'label' => 'TRUEMAG Theme Integration' ,
		'items' => array(
			array(
				'from' => 'wpvr_video_service_url' ,
				'to'   => 'tm_video_url' ,
			) ,
			array(
				'from' => 'wpvr_video_service_duration' ,
				'to'   => 'time_video' ,
			) ,
			array(
				'from' => 'wpvr_video_embed_code' ,
				'to'   => 'tm_video_code' ,
			) ,
		) ,
	);

	/* NEwsTube Integration */
	$wpvr_datafillers_presets[ 'newstube' ] = array(
		'id'    => 'newstube' ,
		'label' => 'NEWSTUBE Theme Integration' ,
		'items' => array(
			array(
				'from' => 'wpvr_video_service_url' ,
				'to'   => 'tm_video_url' ,
			) ,
			array(
				'from' 			=> 'custom_data',
				'from_custom' 	=> 'on',
				'to' 			=> 'user_rate_option',
			),

			array(
				'from' 			=> 'custom_data',
				'from_custom' 	=> '2',
				'to' 			=> 'post_video_layout',
			),

			array(
				'from' 			=> 'custom_data',
				'from_custom' 	=> 'yes',
				'to' 			=> 'show_related_post_in_archive',
			),

			array(
				'from' 			=> 'custom_data',
				'from_custom' 	=> '5',
				'to' 			=> 'cm_auto_refresh',
			),
		) ,
	);