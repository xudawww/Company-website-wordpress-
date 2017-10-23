<?php
	global
		$wpvr_colors,
		$wpvr_status,
		$wpvr_services,
		$wpvr_types_ ,
		$wpvr_addons ,
		$current_addon ,
		$addon_id ,
		$is_reloading
	;
	
	$browse_url = admin_url().'admin.php?page=wpvr-addons';
	$browse_addons_url = WPVR_URL.'addons/wpvr.addons.browse.php?wpvr_wpload' ;
	$current_addon = null;
	if( isset($_GET['addon_id']) ) {
		//echo "<br/> addon_id set";
		if( isset( $wpvr_addons[ $_GET['addon_id'] ] ) ) {
			//echo "<br/> addon installed";
			$current_addon = $wpvr_addons[ $_GET['addon_id'] ];
		}
	}elseif( isset($addon_id) && $addon_id != '') {
		//echo "<br/> addon_id set";
		if( isset( $wpvr_addons[ $addon_id ] ) ) {
			//echo "<br/> addon installed";
			$current_addon = $wpvr_addons[ $addon_id ];
		}
	}
	
	if( isset( $_GET['activate_addon'] ) ){
		$addon_dir = $_GET['activate_addon'] ;
		$result = activate_plugin( $addon_dir );
		if ( is_wp_error( $result ) ) {
			//new dBug( $result );
		}
	}
	
	if( isset( $_GET['deactivate_addon'] ) ){
		$addon_path = $_GET['deactivate_addon'] ;
		$result = deactivate_plugins( $addon_path );
		//new dBug( $result );
		//return false;
	}
	
	if( isset( $_GET['reload_addons_list'] ) ){
		$is_reloading = TRUE;
	}else{
		$is_reloading = FALSE;
	}
	
	
	
?>
<div class="wrap wpvr_wrap wpvr_addons" style="visibility:hidden;">
	<?php wpvr_show_logo(); ?>
	
	
	<?php if( $current_addon == null ){ ?>
		<h2 class="wpvr_title">
			<i class="wpvr_title_icon fa fa-cubes"></i>
			<?php echo  __( 'Browse Addons',  WPVR_LANG  ); ?>
		</h2>

		<?php if( $is_reloading === TRUE ){ ?>
		<div class="wpvr_load_asyncr" url ="<?php echo $browse_addons_url.'&is_reloading'; ?>" style="display:none;"></div>
		<?php }else{ ?>
		<div class="wpvr_show_after_load" style="display:none;">
			<?php include('wpvr.addons.browse.php'); ?>
		</div>
		<?php } ?>
		
		
	<?php }else{ ?>
		<h2 class="wpvr_title">
			<a href="<?php echo $browse_url; ?>"><i class="wpvr_title_icon fa fa-angle-left"></i></a>
			<?php echo  __( 'Manage Addon',  WPVR_LANG  ); ?> - <?php echo $current_addon['infos']['title']; ?>
		</h2>
		<?php include('wpvr.addons.manage.php'); ?>
	
	<?php } ?>