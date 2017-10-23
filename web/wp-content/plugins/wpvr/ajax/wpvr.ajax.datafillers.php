<?php
	
	add_action( 'wp_ajax_nopriv_delete_all_fillers' , 'wpvr_delete_all_fillers_ajax_function' );
	add_action( 'wp_ajax_delete_all_fillers' , 'wpvr_delete_all_fillers_ajax_function' );
	function wpvr_delete_all_fillers_ajax_function() {
		update_option( 'wpvr_fillers' , '' );
		echo wpvr_get_json_response( 'done' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_add_fillers_from_preset' , 'wpvr_add_fillers_from_preset_ajax_function' );
	add_action( 'wp_ajax_add_fillers_from_preset' , 'wpvr_add_fillers_from_preset_ajax_function' );
	function wpvr_add_fillers_from_preset_ajax_function() {
		global $wpvr_datafillers_presets;
		$wpvr_fillers = get_option( 'wpvr_fillers' );
		if ( $wpvr_fillers == '' ) {
			$wpvr_fillers = array();
		}
		$preset       = $_POST[ 'preset' ];
		$preset_items = $wpvr_datafillers_presets[ $preset ][ 'items' ];
		foreach ( (array) $preset_items as $filler ) {
			if ( $filler[ 'from' ] == 'custom_data' ) {
				$wpvr_fillers[] = array(
					'from'        => 'custom_data' ,
					'from_custom' => trim( $filler[ 'from_custom' ] ) ,
					'to'          => trim( $filler[ 'to' ] ) ,
				);
				
			}elseif ( $filler[ 'from' ] == 'custom_data' ) {
				$wpvr_fillers[] = array(
					'from' => trim( $filler[ 'from' ] ) ,
					'to'   => trim( $filler[ 'to' ] ) ,
				);
            } else {
				$wpvr_fillers[] = array(
					'from' => trim( $filler[ 'from' ] ) ,
					'to'   => trim( $filler[ 'to' ] ) ,
				);
			}
		}
		//new dBug( $preset_items );
		
		update_option( 'wpvr_fillers' , $wpvr_fillers );
		echo wpvr_get_json_response( 'done' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_run_fillers' , 'wpvr_run_fillers_ajax_function' );
	add_action( 'wp_ajax_run_fillers' , 'wpvr_run_fillers_ajax_function' );
	function wpvr_run_fillers_ajax_function() {
		$r            = array(
			'found'     => 0 ,
			'processed' => 0 ,
			'errors'    => 0 ,
		);
		$wpvr_fillers = get_option( 'wpvr_fillers' );
		global $wpdb;
		$sql
			    = "
			select 
				P.ID
			from
				$wpdb->posts P 
			where
				P.post_type = '" . WPVR_VIDEO_TYPE . "'	
				
		";
		$videos = $wpdb->get_results( $sql );
		
		$r[ 'found' ] = count( $videos );
		if ( count( $videos ) != 0 ) {
			foreach ( (array) $videos as $video ) {
				
				$video_id = $video->ID;
				if ( is_array( $wpvr_fillers ) && count( $wpvr_fillers ) > 0 ) {
					foreach ( (array) $wpvr_fillers as $filler ) {
						
						//Get Data to fill With
						if ( $filler[ 'from' ] == 'wpvr_video_embed_code' ) {
							//Getting Embed Code
							$wpvr_video_id = get_post_meta( $video_id , 'wpvr_video_id' , TRUE );
							$wpvr_service  = get_post_meta( $video_id , 'wpvr_video_service' , TRUE );
							$data          = '<div class="wpvr_embed">' . wpvr_video_embed( $wpvr_video_id , $autoPlay = FALSE , $wpvr_service ) . '</div>';
						} elseif ( $filler[ 'from' ] == 'custom_data' ) {
							$data = $filler[ 'from_custom' ];
						} elseif ( $filler[ 'from' ] == 'wpvr_video_service_url_https' ) {
							$data = str_replace( 'http://' , 'https://' , get_post_meta( $video_id , 'wpvr_video_service_url' , TRUE ) );
							
						} elseif ( $filler[ 'from' ] == 'wpvr_video_service_duration' ) {
							//Getting String Duration
							$wpvr_video_duration = get_post_meta( $video_id , 'wpvr_video_duration' , TRUE );
							$data                = wpvr_get_duration_string( $wpvr_video_duration );
						} else {
							$data = get_post_meta( $video_id , $filler[ 'from' ] , TRUE );
						}
						
						if ( $filler[ 'from' ] != 'wpvr_dynamic_views' ) {
							//Fill The Custom Fields
							$ok = update_post_meta( $video_id , $filler[ 'to' ] , $data );
						} else {
							$ok = TRUE;
						}
						
						if ( $ok === FALSE ) {
							$r[ 'errors' ] ++;
						} else {
							$r[ 'processed' ] ++;
						}
					}
				}
				do_action( 'wpvr_event_run_dataFillers' , $video_id );
				
			}
		}
		echo wpvr_get_json_response( $r );
		die();
	}
	
	
	add_action( 'wp_ajax_nopriv_remove_filler' , 'wpvr_remove_filler_ajax_function' );
	add_action( 'wp_ajax_remove_filler' , 'wpvr_remove_filler_ajax_function' );
	function wpvr_remove_filler_ajax_function() {
		$wpvr_fillers = get_option( 'wpvr_fillers' );
		
		unset( $wpvr_fillers[ $_POST[ 'k' ] ] );
		update_option( 'wpvr_fillers' , $wpvr_fillers );
		echo wpvr_get_json_response( 'done' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_add_filler' , 'wpvr_add_filler_ajax_function' );
	add_action( 'wp_ajax_add_filler' , 'wpvr_add_filler_ajax_function' );
	function wpvr_add_filler_ajax_function() {
		$wpvr_fillers = get_option( 'wpvr_fillers' );
		if ( $wpvr_fillers == '' ) {
			$wpvr_fillers = array();
		}
		if ( $_POST[ 'filler_from' ] == 'custom_data' ) {
			$wpvr_fillers[] = array(
				'from'        => 'custom_data' ,
				'from_custom' => trim( $_POST[ 'filler_from_custom' ] ) ,
				'to'          => trim( $_POST[ 'filler_to' ] ) ,
			);
		} else {
			$wpvr_fillers[] = array(
				'from' => trim( $_POST[ 'filler_from' ] ) ,
				'to'   => trim( $_POST[ 'filler_to' ] ) ,
			);
		}
		
		update_option( 'wpvr_fillers' , $wpvr_fillers );
		echo wpvr_get_json_response( 'done' );
		die();
	}
	
	add_action( 'wp_ajax_nopriv_show_fillers' , 'wpvr_show_fillers_ajax_function' );
	add_action( 'wp_ajax_show_fillers' , 'wpvr_show_fillers_ajax_function' );
	function wpvr_show_fillers_ajax_function() {
		global $wpvr_filler_data;
		ob_start();
		$wpvr_fillers = get_option( 'wpvr_fillers' );
		if ( $wpvr_fillers == '' || count( $wpvr_fillers ) == 0 ) {
			?>
			<div class = "wpvr_manage_noResults">
				<i class = "fa fa-frown-o"></i><br/>
				<?php echo __( 'There is no fillers to show.' , WPVR_LANG ); ?>
			</div>
			
			<?php
			
			$output = ob_get_contents();
			ob_end_clean();
			
			echo wpvr_get_json_response( $output , 0 , '' , 0 );
			
			return FALSE;
		}
		?>
		<div class = "wpvr_filler_actions">
			
			<button
				type = "button"
				id = "wpvr_filler_run"
				class = "wpvr_button pull-right"
				url = "<?php echo WPVR_FILLERS_URL; ?>"
			>
				<i class = "fa fa-bolt"></i>
				<?php _e( 'RUN FILLERS ON EXISTANT VIDEOS' , WPVR_LANG ); ?>
			</button>
			
			<button
				type = "button"
				id = "wpvr_filler_delete_all"
				class = "wpvr_button wpvr_black_button pull-left"
				url = "<?php echo WPVR_FILLERS_URL; ?>"
				is_demo = "<?php echo WPVR_IS_DEMO ? 1 : 0; ?>"
			>
				<i class = "fa fa-close"></i>
				<?php _e( 'DELETE ALL FILLERS' , WPVR_LANG ); ?>
			</button>
			<div class = "wpvr_clearfix"></div>
			<br/>
		</div>
		
		
		<?php
		$countFillers = 0;
		foreach ( (array) $wpvr_fillers as $k => $filler ) {
			$countFillers ++;
			if ( $filler[ 'from' ] == 'custom_data' ) {
				$from = '"' . $filler[ 'from_custom' ] . '"';
			} else {
				$from = $wpvr_filler_data[ $filler[ 'from' ] ];
			}
			?>
			<li class = "filler">
				<div class = "pull-left">
					<?php echo $from ?>
					<i class = "fa fa-long-arrow-right"></i>
					<?php echo $filler[ 'to' ]; ?>
				</div>
				
				
				<button
					type = "button"
					id = ""
					class = "wpvr_button wpvr_red_button pull-right wpvr_filler_remove"
					title = "Remove this filler"
					url = "<?php echo WPVR_FILLERS_URL; ?>"
					k = "<?php echo $k; ?>"
				>
					<i class = "fa fa-remove"></i>
				</button>
				<div class = "wpvr_clearfix"></div>
			</li>
			
			<?php
		}
		?>
		<div class = "wpvr_clearfix"></div> <?php
		
		$output = ob_get_contents();
		ob_end_clean();
		echo wpvr_get_json_response( $output , 1 , '' , $countFillers );
		die();
	}