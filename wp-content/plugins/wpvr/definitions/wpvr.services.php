<?php
	
	global $wpvr_vs, $wpvr_vs_ids;
	
	$wpvr_vs_ids = array(
		'ids'  => array(),
		'gids' => array(),
	);
	
	/* Load Video Services from their files definitions */
	$wpvr_found_services = array();
	if ( WPVR_ENABLE_YOUTUBE ) {
		require_once( WPVR_PATH . 'services/youtube/init.php' );
	}
	if ( WPVR_ENABLE_VIMEO ) {
		require_once( WPVR_PATH . 'services/vimeo/init.php' );
	}
	if ( WPVR_ENABLE_DAILYMOTION ) {
		require_once( WPVR_PATH . 'services/dailymotion/init.php' );
	}
	
	$wpvr_vs = $wpvr_found_services;
	
	do_action( 'wpvr_init_extended_video_services' );
	
	//Add by hooks other services
	$wpvr_vs = apply_filters( 'wpvr_extend_video_services', $wpvr_vs );
	
	foreach ( (array) $wpvr_vs as $vs ) {
		
		$wpvr_vs_ids['ids'][] = $vs['id'];
		
		/* Extending Video Services Options */
		add_filter(
			'wpvr_extend_video_services_options',
			function ( $video_service_options ) use ( $vs ) {
				$video_service_options[] = array(
					'name'  => '<span class="wpvr_service_icon ' . $vs['id'] . '">' . $vs['label'] . '</span>',
					'value' => $vs['id'],
				);
				
				return $video_service_options;
			}, 12, 1
		);
		
		
		/* Extending Video Services Video ID Field */
		add_filter(
			'wpvr_extend_video_fields',
			function ( $video_fields ) use ( $vs ) {
				if ( ! isset( $vs['manual_type'] ) ) {
					$vs['manual_type'] = 'text';
				}
				$video_fields[] = array(
					'name'        => $vs['manual_name'],
					'desc'        => $vs['manual_desc'],
					'id'          => $vs['manual_id'],
					'type'        => $vs['manual_type'],
					'description' => $vs['manual_desc'],
					'wpvrService' => $vs['id'],
					'wpvrClass'   => 'wpvrArgs direct',
					'wpvrStyle'   => 'display:none;',
				);
				
				return $video_fields;
			}, 12, 1
		);
		
		/* Extending Video Services DEfault Tokens*/
		add_filter(
			'wpvr_extend_default_tokens',
			function ( $wpvr_default_tokens ) use ( $vs ) {
				$wpvr_default_tokens[ $vs['id'] ] = array(
					'access_token'  => '',
					'refresh_token' => '',
				);
				
				return $wpvr_default_tokens;
			}, 12, 1
		);
		
		/* Extending Video Services DEfault Unwanted*/
		//add_filter(
		//	'wpvr_extend_default_unwanted' ,
		//	function ( $wpvr_default_unwanted ) use ( $vs ) {
		//		$wpvr_default_unwanted[ $vs[ 'id' ] ] = array();
		//		return $wpvr_default_unwanted;
		//	} , 12 , 1
		//);
		
		/* Extending Video Services DEfault Tokens*/
		add_filter(
			'wpvr_extend_dynamics',
			function ( $wpvr_dynamics ) use ( $vs ) {
				$wpvr_dynamics['player_options'][ $vs['id'] ] = array(
					'access_token'  => '',
					'refresh_token' => '',
				);
				
				return $wpvr_dynamics;
			}, 12, 1
		);
		
		//Hook other Types
		$vs['types'] = apply_filters( 'wpvr_extend_video_services_types', $vs['types'] );
		
		if ( count( $vs['types'] ) > 0 ) {
			foreach ( (array) $vs['types'] as $vs_type ) {
				
				$wpvr_vs_ids['gids'][] = $vs_type['global_id'];
				
				/* Extending Video Services Types Options */
				add_filter(
					'wpvr_extend_video_services_types_options',
					function ( $video_service_types_options ) use ( $vs, $vs_type ) {
						if ( ! function_exists( 'wpvr_render_vs_source_type' ) ) {
							return $video_service_types_options;
						}
						$video_service_types_options[] = array(
							'name'    => wpvr_render_vs_source_type( $vs_type, $vs ),
							'value'   => $vs_type['id'],
							'service' => $vs['id'],
						);
						
						return $video_service_types_options;
					}, 12, 1
				);
				
				/* Extending Video Services Types Fields*/
				if ( isset( $vs_type['fields'] ) && count( $vs_type['fields'] ) > 0 ) {
					foreach ( (array) $vs_type['fields'] as $vs_type_field ) {
						//_d( $vs_type_field );
						/* Extending Video Services Types Fields*/
						add_filter(
							'wpvr_extend_video_services_types_fields',
							function ( $video_service_types_fields, $prefix ) use ( $vs, $vs_type, $vs_type_field ) {
								$field = $vs_type_field;
								
								if ( ! isset( $field['wpvrClass'] ) ) {
									$field['wpvrClass'] = '';
								}
								if ( ! isset( $field['wpvr_attributes'] ) ) {
									$field['wpvr_attributes'] = array();
								}
								
								$field['wpvr_attributes']['prefix'] = $prefix;
								$field['id']                        = $prefix . $vs_type_field['id'];
								$field['wpvrStyle']                 = 'display:none;';
								
								if ( ! isset( $field['hidden_field'] ) || ! $field['hidden_field'] ) {
									$field['wpvrClass'] .= ' wpvrArgs ';
								}
								
								$video_service_types_fields[] = $field;
								
								return $video_service_types_fields;
							}, 12, 2
						);
					}
				}
			}
		}
	}


