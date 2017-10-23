<?php
	
	
	global $wpvr_pages;
	$wpvr_pages = true;
	
	global
	$wpvr_timezones,
	$wpvr_options,
	$wpvr_vs,
	$wpvr_roles;
	
	$option_tabs = array(
		'general'     => array(
			'active' => '',
			'icon'   => 'rocket',
			'label'  => __( 'General', WPVR_LANG ),
		),
		'fetching'    => array(
			'active' => '',
			'icon'   => 'search',
			'label'  => __( 'Fetching', WPVR_LANG ),
		),
		'posting'     => array(
			'active' => '',
			'icon'   => 'cloud-download',
			'label'  => __( 'Posting', WPVR_LANG ),
		),
		'integration' => array(
			'active' => '',
			'icon'   => 'plug',
			'label'  => __( 'Integration', WPVR_LANG ),
		),
		'automation'  => array(
			'active' => '',
			'icon'   => 'gears',
			'label'  => __( 'Automation', WPVR_LANG ),
		),
		'api_keys'    => array(
			'active' => '',
			'icon'   => 'key',
			'label'  => __( 'API Access', WPVR_LANG ),
		),
	);
	
	if ( isset( $_GET['section'] ) && isset( $option_tabs[ $_GET['section'] ] ) ) {
		$option_tabs[ $_GET['section'] ]['active'] = 'active';
	} else {
		$option_tabs['general']['active'] = 'active';
	}
	//d( $wpvr_options );
?>
<div class="wrap wpvr_wrap wpvr_options_page" style="visibility:hidden;">
	
	<h2 class="wpvr_title">
		<?php wpvr_show_logo(); ?>
		<i class="wpvr_title_icon fa fa-wrench	"></i>
		<?php echo __( 'Manage Options', WPVR_LANG ); ?>
		
		<div class="wpvr_clearfix"></div>
	</h2>
	
	<div id="wpvr_options_wrapper">
		<form
			name="wpvr_options"
			id="wpvr_options"
			method="post"
			action="<?php //echo WPVR_OPTIONS_URL; ?>"
			is_demo="<?php echo WPVR_IS_DEMO ? 1 : 0; ?>"
		>
			
			<div class="wpvr_options_top">
				
				<div class="wpvr_options_top_menu wpvr_nav_tabs pull-left">
					
					<?php foreach ( (array) $option_tabs as $tab_id => $tab ) { ?>
						<div
							id="<?php echo $tab_id; ?>"
							title="<?php echo $tab['label']; ?>"
							class="wpvr_nav_tab pull-left noMargin <?php echo $tab['active']; ?>">
							<i class="wpvr_tab_icon fa fa-<?php echo $tab['icon']; ?>"></i>
							<br/>
							<span><?php echo $tab['label']; ?></span>
						</div>
					
					<?php } ?>
					<span class="wpvr_version_helper pull-right">
						<?php echo "v" . WPVR_VERSION; ?>
					</span>
					<div class="wpvr_clearfix"></div>
				</div>
				<div class="wpvr_clearfix"></div>
				<div class="result_options"></div>
				<div class="wpvr_options_top_actions">
					<input type="hidden" name="save_options" value="1"/>
					<input type="hidden" name="action" value="wpvr_save_options"/>
					<button
						url="<?php //echo WPVR_OPTIONS_URL; ?>"
						id="wpvr_system_infos"
						class="pull-left wpvr_button wpvr_black_button wpvr_medium"
					>
						<i class="fa fa-info-circle"></i>
						<?php _e( 'Show System Info', WPVR_LANG ); ?>
					</button>
					<button class="wpvr_button wpvr_medium wpvr_save_options pull-right ">
						<i class="wpvr_button_icon fa fa-save"></i>
						<?php _e( 'Save options', WPVR_LANG ); ?>
					</button>
					<?php do_action( 'wpvr_screen_options_top' ); ?>
				</div>
			</div>
			
			<div class="wpvr_clearfix"></div>
			<!-- GENERAL OPTIONS -->
			<div class="wpvr_options_content">
				<div class="wpvr_options_section" section="general">
					<?php require_once( WPVR_PATH . 'options/wpvr.options.general.php' ); ?>
				</div>
				<div class="wpvr_options_section" section="fetching">
					<?php require_once( WPVR_PATH . 'options/wpvr.options.fetching.php' ); ?>
				</div>
				<div class="wpvr_options_section" section="posting">
					<?php require_once( WPVR_PATH . 'options/wpvr.options.posting.php' ); ?>
				</div>
				<div class="wpvr_options_section" section="automation">
					<?php require_once( WPVR_PATH . 'options/wpvr.options.automation.php' ); ?>
				</div>
				<div class="wpvr_options_section" section="integration">
					<?php require_once( WPVR_PATH . 'options/wpvr.options.integration.php' ); ?>
				</div>
				<div class="wpvr_options_section" section="api_keys">
					<?php require_once( WPVR_PATH . 'options/wpvr.options.api.php' ); ?>
				</div>
			</div>
			<div class="wpvr_options_bottom_actions">
				<button class="wpvr_button wpvr_medium pull-right wpvr_save_options">
					<i class="wpvr_button_icon fa fa-save"></i>
					<?php _e( 'Save options', WPVR_LANG ); ?>
				</button>
				<button id="wpvr_reset_options" class="wpvr_button wpvr_medium pull-left wpvr_black_button">
					<i class="wpvr_button_icon fa fa-undo"></i>
					<?php _e( 'Reset To Default options', WPVR_LANG ); ?>
				</button>
				<button id="wpvr_export_options" class="wpvr_button wpvr_medium pull-left wpvr_black_button">
					<i class="wpvr_button_icon fa fa-upload"></i>
					<?php _e( 'Export options', WPVR_LANG ); ?>
				</button>
				<?php do_action( 'wpvr_screen_options_bottom' ); ?>
			</div>
			<div class="wpvr_clearfix"></div>
		</form>
	</div>
	<div class="wpvr_options_hidden" style="display:none; visibility:hidden;">
		<div id="wpvr_export" src=""></div>
		<div class="wpvr_diagnostic"></div>
		<div class="result_options"></div>
	</div>

</div><!-- /bootStyled -->
