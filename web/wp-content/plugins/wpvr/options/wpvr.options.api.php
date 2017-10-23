<?php
	
	
	$api_option_desc =
		__( 'You can choose whether to grant access to Video Services through the API Wizard,', WPVR_LANG ) . ' <br/>' .
		__( 'or use the crendentials defined below to connect to Video Services APIs.', WPVR_LANG ) . '<br/>' .
		'<strong>' . __( 'Important Notice', WPVR_LANG ) . '</strong> :<br/>' .
		__( 'All API accesses granted manually through the API wizard, are revoked within 24 up to 48 hours by video services APIs.', WPVR_LANG ) . '<br/>';

?>


<!-- apiConnect *** -->
<?php wpvr_render_select_option( array(
	'tab'     => 'api_keys',
	'id'      => 'apiConnect',
	'class'   => 'wpvr_api_connection',
	'label'   => __( 'API Connection', WPVR_LANG ),
	'desc'    => $api_option_desc,
	'options' => array(
		'advanced' => __( 'Use API Advanced Credentials', WPVR_LANG ),
		'wizzard'  => __( 'Use API Wizard', WPVR_LANG ),
	),
), $wpvr_options['apiConnect'] ); ?>

<div class="wpvr_option on <?php echo $wpvr_options['apiConnect']; ?>" id="wpvr_api_connection_target">
	<div class="wpvr_api_wrap">
		
		<div class="advanced_wrap">
			
			<!-- youtube_apiKey -->
			<div class="wpvr_option_inside  first_option tabFix">
				<div class="pull-right align-right">
					<label for="wpvr_options_apiKey">Youtube Api Key</label><br/>
					<input
						type="text"
						class="wpvr_options_input wpvr_large pull-right"
						id="apiKey"
						name="apiKey"
						value="<?php echo $wpvr_options['apiKey']; ?>"
					/>
					
					<div class="wpvr_clearfix"></div>
				</div>
				<div>
								<span
									class="wpvr_option_title"><?php _e( 'Youtube API Credentials', WPVR_LANG ); ?></span><br/>
					
					<p class="wpvr_option_desc">
						<?php _e( 'Enter your Youtube API Key to make the plugin work.', WPVR_LANG ); ?>
						<br/><br/>
						
						<a class="link" target="_blank"
						   href="http://support.wpvideorobot.com/tutorials/where-to-find-youtube-api-key/"
						   title="Click here">
							<?php _e( 'WHERE TO FIND MY YOUTUBE API KEY', WPVR_LANG ); ?>
						</a>
						
						<br/>
						<a
							class="wpvr_api_get_from_default"
							href="javascript:;"
							title="Use the plugin default api credentials values"
							data-key_target="apiKey"
							data-key="<?php echo WPVR_DEFAULT_YOUTUBE_API_KEY; ?>"
						><?php _e( 'SET FROM DEFAULT', WPVR_LANG ); ?></a>
					
					</p>
				</div>
				<div class="wpvr_clearfix"></div>
			</div>
			<!-- /youtube_apiKey -->
			
			
			<!-- vimeo_apiKey -->
			<div class="wpvr_option_inside tabFix">
				<div class="pull-right align-right">
					<label for="wpvr_options_voClientId">Vimeo Client ID</label><br/>
					<input
						type="text"
						class="wpvr_options_input wpvr_large pull-right"
						id="voClientId"
						name="voClientId"
						value="<?php echo $wpvr_options['voClientId']; ?>"
					/>
					
					<div class="wpvr_clearfix"></div>
					<label for="wpvr_options_voClientSecret">Vimeo Client Secret</label><br/>
					<input
						type="text"
						class="wpvr_options_input wpvr_large pull-right"
						id="voClientSecret"
						name="voClientSecret"
						value="<?php echo $wpvr_options['voClientSecret']; ?>"
					/>
					
					<div class="wpvr_clearfix"></div>
				
				</div>
				<div>
								<span
									class="wpvr_option_title"><?php _e( 'Vimeo API Credentials', WPVR_LANG ); ?></span><br/>
					
					<p class="wpvr_option_desc">
						<?php _e( 'Enter your Vimeo Credentials to make the plugin work with Vimeo.', WPVR_LANG ); ?>
						<br/><br/>
						<a class="link" target="_blank"
						   href="http://support.wpvideorobot.com/tutorials/where-to-find-vimeo-crendentials"
						   title="Click here">
							<?php _e( 'WHERE TO FIND MY VIMEO CREDENTIALS', WPVR_LANG ); ?>
						</a>
						<br/>
						<a
							class="wpvr_api_get_from_default"
							href="javascript:;"
							title="Use the plugin default api credentials values"
							data-client_target="voClientId"
							data-client="<?php echo WPVR_VIMEO_CLIENT_ID; ?>"
							data-secret_target="voClientSecret"
							data-secret="<?php echo WPVR_VIMEO_CLIENT_SECRET; ?>"
						><?php _e( 'SET FROM DEFAULT', WPVR_LANG ); ?></a>
					</p>
				</div>
				<div class="wpvr_clearfix"></div>
			</div>
			<!-- /vimeo_apiKey -->
			
			<!-- dm_apiKey -->
			<div class="wpvr_option_inside tabFix">
				<div class="pull-right align-right">
					<label for="wpvr_options_dmClientId">DailyMotion Client ID</label><br/>
					<input
						type="text"
						class="wpvr_options_input wpvr_large pull-right"
						id="dmClientId"
						name="dmClientId"
						value="<?php echo $wpvr_options['dmClientId']; ?>"
					/>
					
					<div class="wpvr_clearfix"></div>
					<label for="wpvr_options_dmClientSecret">DailyMotion Client Secret</label><br/>
					<input
						type="text"
						class="wpvr_options_input wpvr_large pull-right"
						id="dmClientSecret"
						name="dmClientSecret"
						value="<?php echo $wpvr_options['dmClientSecret']; ?>"
					/>
					
					<div class="wpvr_clearfix"></div>
				</div>
				<div>
								<span
									class="wpvr_option_title"><?php _e( 'DailyMotion API Credentials', WPVR_LANG ); ?></span><br/>
					
					<p class="wpvr_option_desc">
						<?php _e( 'Enter your DailyMotion Credentials to make the plugin work with DailyMotion.', WPVR_LANG ); ?>
						<br/><br/>
						<a class="link" target="_blank"
						   href="http://support.wpvideorobot.com/tutorials/where-to-find-dailymotion-crendentials/"
						   title="Click here"
						><?php _e( 'WHERE TO FIND MY DAILYMOTION CREDENTIALS', WPVR_LANG ); ?></a>
						<br/>
						<a
							class="wpvr_api_get_from_default"
							href="javascript:;"
							title="Use the plugin default api credentials values"
							data-client="<?php echo WPVR_DAILYMOTION_CLIENT_ID; ?>"
							data-client_target="dmClientId"
							data-secret="<?php echo WPVR_DAILYMOTION_CLIENT_SECRET; ?>"
							data-secret_target="dmClientSecret"
						><?php _e( 'SET FROM DEFAULT', WPVR_LANG ); ?></a>
					</p>
				</div>
				<div class="wpvr_clearfix"></div>
			</div>
			<!-- /dm_apiKey -->
		</div>
		
		<div class="wizard_wrap">
			<?php if ( count( $wpvr_vs ) != 0 ) { ?>
				<?php foreach ( (array) $wpvr_vs as $service ) { ?>
					<?php if ( isset( $service['disable_manual_authentication'] ) && $service['disable_manual_authentication'] === true ) {
						continue;
					} ?>
					
					<!-- access -->
					<?php $vs_access = $service['validate_token'](); ?>
					<?php $on = ( $vs_access === false ) ? 'off' : 'on'; ?>
					
					<div class="wpvr_grid_option <?php echo $on; ?>" service="<?php echo $service['id']; ?>">
						<div class="wpvr_grid_option_icon on">
							<i class="fa fa-check"></i>
						</div>
						
						<div class="wpvr_grid_option_icon off">
							<i class="fa fa-ban"></i>
						</div>
						
						<div class="wpvr_grid_option_head">
							<div class="wpvr_option_title">
								<?php //printf( __( '%s API Access', WPVR_LANG ), ucfirst( $service['label'] ) ); ?>
								<?php //echo( ucfirst( $service['label'] ) ); ?>
								<img
									src="<?php echo WPVR_URL . 'assets/images/services/' . $service['id'] . '.png'; ?>"/>
							</div>
							<br/>
							
							<p class="wpvr_option_desc">
								<?php printf( __( 'Grant Access to %s to use its official API.', WPVR_LANG ), ucfirst( $service['label'] ) ); ?>
								<br/><br/>
							</p>
						</div>
						<div class="wpvr_grid_option_buttons">
							<div
								class="wpvr_token_state <?php echo $on; ?>"
								service="<?php echo $service['id']; ?>"
							>
								
								
								<div class="is_false">
									<?php
										$auth_url = wpvr_capi_build_query( WPVR_AUTH_URL, array(
											'key'           => WPVR_AUTH_KEY,
											'service'       => $service['id'],
											'url_back'      => WPVR_ACTIONS_URL,
											'url_back_args' => base64_encode( wpvr_json_encode( array(
												'wpvr_wpload'   => 1,
												'set_api_token' => 1,
												'',
											) ) ),
											'list'          => WPVR_AUTH_CUSTOM_LIST,
											'first_call'    => 1,
										
										) );
									?>
									<button
										service="<?php echo $service['id']; ?>"
										class="wpvr_grid_button wpvr_button wpvr_get_token wpvr_black_button"
										local="<?php echo urlencode( WPVR_ACTIONS_URL ); ?>"
										auth_url="<?php echo $auth_url; ?>"
									>
										<i class="fa fa-unlock"></i>
										<?php echo __( 'Grant Access' ); ?>
									</button>
								
								</div>
								<div class="is_true">
									<button
										service="<?php echo $service['id']; ?>"
										class="wpvr_grid_button wpvr_button cancel wpvr_remove_token wpvr_black_button "
										local="<?php echo urlencode( WPVR_ACTIONS_URL ); ?>">
										<i class="fa fa-remove"></i>
										<?php _e( 'Cancel This Access', WPVR_LANG ); ?>
									</button>
								</div>
							</div>
							<div class="wpvr_clearfix"></div>
						</div>
						
						<div class="wpvr_clearfix"></div>
					</div>
					<!-- /access -->
				<?php } ?>
			<?php } ?>
			<div class="wpvr_clearfix"></div>
		</div>
	
	
	</div>
</div>