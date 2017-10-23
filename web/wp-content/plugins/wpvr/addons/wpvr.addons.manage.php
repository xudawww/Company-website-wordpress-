<?php
	global $wpvr_colors , $wpvr_status , $wpvr_services , $wpvr_types_;
	global $wpvr_addons;
	$ca = $current_addon;
	
	//new dBug( $ca );
	
	$active = array(
		'dash'    => '' ,
		'options' => '' ,
		'infos'   => '' ,
	);
	if( isset( $ca[ 'infos' ][ 'other_tabs' ] ) ) {
		foreach( (array) $ca[ 'infos' ][ 'other_tabs' ] as $tab ) {
			$active[ $tab[ 'id' ] ] = '';
		}
	}
	
	if( ! isset( $_GET[ 'section' ] ) || ! isset( $active[ $_GET[ 'section' ] ] ) ) {
		if( $ca[ 'infos' ][ 'dashboard_enabled' ] === true )
			$active[ 'dash' ] = 'active';
		elseif( $ca[ 'infos' ][ 'options_enabled' ] === true )
			$active[ 'options' ] = 'active';
		elseif( $ca[ 'infos' ][ 'infos_enabled' ] === true )
			$active[ 'infos' ] = 'active';

	} else {
		$active[ $_GET[ 'section' ] ] = 'active';
	}

	$addons_obj = wpvr_get_addons( array() , false);
	$found_addons = (array) $addons_obj['items'];
	foreach( (array) $found_addons as $fa ){
		if( $ca['infos']['id'] == $fa->id ) {
			if( property_exists( $fa , 'doc' ) ) $addon_doc = $fa->doc ;
		}
	}

?>

<div class = "wpvr_nav_tabs pull-left">

		<span class = "wpvr_version_helper pull-right">
			<?php echo $ca[ 'infos' ][ 'title' ]; ?>
			v<?php echo $ca[ 'infos' ][ 'version' ]; ?>
		</span>

	<?php if( $ca[ 'infos' ][ 'dashboard_enabled' ] === true ) { ?>
		<div class = "wpvr_nav_tab pull-left noMargin <?php echo $active[ 'dash' ]; ?>" id = "a">
			<i class = "wpvr_tab_icon fa fa-dashboard"></i><br/>
			<?php _e( 'Dashboard' , WPVR_LANG ); ?>
		</div>
	<?php } ?>

	<?php if( $ca[ 'infos' ][ 'options_enabled' ] === true ) { ?>
		<div class = "wpvr_nav_tab pull-left noMargin <?php echo $active[ 'options' ]; ?>" id = "b">
			<i class = "wpvr_tab_icon fa fa-gear"></i><br/>
			<span><?php _e( 'Options' , WPVR_LANG ); ?></span>
		</div>
	<?php } ?>

	<?php if( $ca[ 'infos' ][ 'infos_enabled' ] === true ) { ?>
		<div class = "wpvr_nav_tab pull-left noMargin <?php echo $active[ 'infos' ]; ?>" id = "c">
			<i class = "wpvr_tab_icon fa fa-info-circle"></i><br/>
			<span><?php _e( 'About' , WPVR_LANG ); ?></span>
		</div>
	<?php } ?>

	<?php if( isset( $ca[ 'infos' ][ 'other_tabs' ] ) ) { ?>
		<?php foreach( (array) $ca[ 'infos' ][ 'other_tabs' ] as $tab ) { ?>
			<div
				class = "wpvr_nav_tab pull-left noMargin <?php echo $active[ 'infos' ]; ?>"
				id = "<?php echo $tab[ 'id' ]; ?>"
				>
				<i class = "wpvr_tab_icon fa <?php echo $tab[ 'icon' ]; ?>"></i><br/>
				<span><?php echo $tab[ 'label' ]; ?></span>
			</div>
		<?php } ?>
	<?php } ?>

	<?php if( isset( $ca[ 'infos' ][ 'doc' ] ) && $ca[ 'infos' ][ 'doc' ] != false ) { ?>
		<a href = "<?php echo $ca[ 'infos' ][ 'doc' ]; ?>" class="wpvr_nav_link" target="_blank" title = "Addon Tutorial">
			<div class = "wpvr_nav_tab pull-left noMargin"  id = "">
				<i class = "wpvr_tab_icon fa fa-question-circle"></i><br/>
				<span><?php _e( 'Tutorial' , WPVR_LANG ); ?></span>
			</div>
		</a>
	<?php } ?>

	<div class = "wpvr_clearfix"></div>
</div>
<div class = "wpvr_clearfix"></div>
<div>

	<!-- DASHBOARD -->
	<?php if( $ca[ 'infos' ][ 'dashboard_enabled' ] === true ) { ?>
		<div id = "dashboard-widgets-wrap" class = "wpvr_nav_tab_content tab_a" style = "display:none;">
			<?php include( $ca[ 'files' ][ 'dash' ] ); ?>
		</div>
	<?php } ?>

	<!-- OPTIONS -->
	<?php if( $ca[ 'infos' ][ 'options_enabled' ] === true ) { ?>
		<div id = "dashboard-widgets-wrap" class = "wpvr_nav_tab_content tab_b" style = "display:none;">
			<?php include( 'wpvr.addons.options.php' ); ?>
		</div>
	<?php } ?>


	<?php if( isset( $ca[ 'infos' ][ 'other_tabs' ] ) ) { ?>
		<?php foreach( (array) $ca[ 'infos' ][ 'other_tabs' ] as $tab ) { ?>
			<?php if( isset( $tab[ 'content' ] ) && $tab[ 'content' ] == 'options' ) { ?>
				<div id = "dashboard-widgets-wrap" class = "wpvr_nav_tab_content tab_<?php echo $tab[ 'id' ]; ?>" style = "display:none;">
					<?php
						global $wpvr_options_tab , $wpvr_options_tab_label;
						$wpvr_options_tab       = $tab[ 'id' ];
						$wpvr_options_tab_label = $tab[ 'label' ];
						include( 'wpvr.addons.options.php' ); ?>
				</div>
			<?php } else if( isset( $tab[ 'content' ] ) && $tab[ 'content' ] != '' ) { ?>
				<div id = "dashboard-widgets-wrap" class = "wpvr_nav_tab_content tab_<?php echo $tab[ 'id' ]; ?>" style = "display:none;">
					<?php include( $tab[ 'content' ] ); ?>
				</div>
			<?php } ?>

		<?php } ?>
	<?php } ?>


	<!-- INFOS -->
	<?php if( $ca[ 'infos' ][ 'infos_enabled' ] === true ) { ?>
		<div id = "dashboard-widgets-wrap" class = "wpvr_nav_tab_content tab_c" style = "display:none;">
			<?php include( $ca[ 'files' ][ 'infos' ] ); ?>
		</div>
	<?php } ?>

</div>