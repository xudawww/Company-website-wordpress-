<?php
	
	/* Require Ajax WP load */
	if ( isset( $_GET[ 'wpvr_wpload' ] ) || isset( $_POST[ 'wpvr_wpload' ] ) ) {
		define( 'DOING_AJAX' , TRUE );
		//define('WP_ADMIN', true );
		$wpload = 'wp-load.php';
		while( ! is_file( $wpload ) ) {
			if ( is_dir( '..' ) ) {
				chdir( '..' );
			} else {
				die( 'EN: Could not find WordPress! FR : Impossible de trouver WordPress !' );
			}
		}
		@require_once( $wpload );
	}
	
	global $wpvr_datafillers_presets;

?>
<div id = "dashboard-widgets" class = "metabox-holder">
	<div id = "postbox-container-1" class = "postbox-container">
		<div id = "normal-sortables" class = "meta-box-sortables ui-sortable">
			<!-- Add from Presets -->
			<div id = "dashboard_right_now" class = "postbox ">
				<h3 class = "hndle"><span> <?php _e( 'Add from Presets' , WPVR_LANG ); ?></span></h3>
				<div class = "inside">
					<div class = "main">
						<label for = "filler_from"><?php _e( 'DataFiller Preset' , WPVR_LANG ); ?></label><br/>
						<select class = "wpvr_filler_input" name = "filler_preset" id = "filler_preset">
							<option value = ""> - <?php _e( 'Choose a preset' , WPVR_LANG ); ?> -</option>
							<?php foreach ( (array) $wpvr_datafillers_presets as $preset ) { ?>
								<option value = "<?php echo $preset[ 'id' ]; ?>">
									<?php echo $preset[ 'label' ]; ?>
								</option>
							<?php } ?>
						</select>
						
						<br/><br/>
						<div class = "wpvr_clearfix"></div>
						<button
							id = "wpvr_filler_add_from_preset"
							class = "pull-right wpvr_button"
							url = "<?php echo WPVR_FILLERS_URL; ?>"
						
						>
							<i class = "fa fa-plus"></i>
							<?php _e( 'ADD FILLERS FROM PRESET' , WPVR_LANG ); ?>
						</button>
						<div class = "wpvr_clearfix"></div>
					
					
					</div>
				</div>
			</div>
			
			
			<!-- Add Manually -->
			<div id = "dashboard_right_now" class = "postbox ">
				<h3 class = "hndle"><span> <?php _e( 'Add a new Filler' , WPVR_LANG ); ?></span></h3>
				<div class = "inside">
					<div class = "main">
						
						<form class = "wpvr_filler_form">
							<label for = "filler_from"><?php _e( 'Video Data to add' , WPVR_LANG ); ?></label><br/>
							<select class = "wpvr_filler_input" name = "filler_from">
								<option value = ""> - <?php _e( 'Choose a data' , WPVR_LANG ); ?> -</option>
								<option value = "wpvr_video_id">
									<?php _e( 'Video ID' , WPVR_LANG ); ?>
								</option>
								<option value = "wpvr_video_service">
									<?php _e( 'Video Service' , WPVR_LANG ); ?>
								</option>
								
								<option value = "wpvr_video_embed_code">
									<?php _e( 'Video Embed Code' , WPVR_LANG ); ?>
								</option>
								
								<option value = "wpvr_video_service_url">
									<?php _e( 'Video URL' , WPVR_LANG ); ?>
								</option>
								<option value = "wpvr_video_service_url_https">
									<?php _e( 'Video URL (https)' , WPVR_LANG ); ?>
								</option>
								<option value = "wpvr_video_service_duration">
									<?php _e( 'Video Duration' , WPVR_LANG ); ?>
								</option>
								<option value = "wpvr_video_service_thumb">
									<?php _e( 'Video Thumbnail' , WPVR_LANG ); ?>
								</option>
								<option value = "wpvr_video_service_views">
									<?php _e( 'Video Original Views' , WPVR_LANG ); ?>
								</option>
								<option value = "wpvr_dynamic_views">
									<?php _e( 'Dynamic Video Views' , WPVR_LANG ); ?>
								</option>
								<option value = "custom_data">
									<?php _e( 'Custom Data' , WPVR_LANG ); ?>
								</option>
							</select><br/>
							<input
								class = "wpvr_filler_input"
								id = "filler_from_custom"
								name = "filler_from_custom"
								type = "text"
								placeholder = "<?php _e( 'Custom String' , WPVR_LANG ); ?>"
								style = "display:none;"
							/>
							<br/><br/>
							
							<label for = "filler_to"><?php _e( 'Custom Field name to populate' , WPVR_LANG ); ?></label><br/>
							<input class = "wpvr_filler_input" name = "filler_to" type = "text" placeholder = "<?php _e( 'Custom Field Name' , WPVR_LANG ); ?>">
							<br/><br/>
							<div class = "wpvr_clearfix"></div>
							<button
								id = "wpvr_filler_add"
								class = "pull-right wpvr_button"
								url = "<?php echo WPVR_FILLERS_URL; ?>"
								form = "wpvr_filler_form"
							>
								<i class = "wpvr_button_icon fa fa-plus"></i>
								<?php _e( 'ADD SINGLE FILLER' , WPVR_LANG ); ?>
							</button>
							<div class = "wpvr_clearfix"></div>
							
							<input type = "hidden" name = "action" value = "add_filler"/>
						
						</form>
					
					</div>
				</div>
			</div>
		
		</div>
	</div>
	<div id = "postbox-container-2" class = "postbox-container">
		<div id = "normal-sortables" class = "meta-box-sortables ui-sortable">
			
			
			<div id = "dashboard_right_now" class = "postbox ">
				<h3 class = "hndle"><span> Fillers </span></h3>
				<div class = "inside">
					<div class = "main">
						<div id = "wpvr_filler_list"> LIST</div>
					</div>
				</div>
			</div>
		
		
		</div>
	</div>
</div>