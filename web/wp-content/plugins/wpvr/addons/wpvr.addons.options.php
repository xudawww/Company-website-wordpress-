<?php
	
	if( isset( $_GET[ 'wpvr_wpload' ] ) || isset( $_POST[ 'wpvr_wpload' ] ) ) {
		$t = explode( 'wp-content' , dirname( __FILE__ ) );
		require_once( $t[ 0 ] . '/wp-load.php' );
		
		global $wpvr_addons;
		if( isset( $_GET[ 'id' ] ) ) {
			$ca = $wpvr_addons[ $_GET[ 'id' ] ];
		} else {
			echo "no addon id defined. Exit.";

			return FALSE;
		}
		
		
		//new dBug( $ca );
		
	}
	
	global $wpvr_options_tab , $wpvr_options_tab_label , $wpvr_pages;
	$wpvr_pages = TRUE;
	if( $wpvr_options_tab_label == null ) $wpvr_options_tab_label = __( 'options' , WPVR_LANG );
	
	$slot_name = $ca[ 'infos' ][ 'slot_name' ];
	
	
	$addon_id   = $ca[ 'infos' ][ 'id' ];
	$action_url = WPVR_URL . 'addons/wpvr.addons.options.php';
	//new dBug( $ca['options'] ); 
	//$slot = get_option( $slot_name );
	$slot = wpvr_get_addon_options( $addon_id );
	
	//d( $slot );
	
	//SAVING OPTIONS
	if( isset( $_GET[ 'save_addon_options' ] ) ) {
		$old_options = $slot ;
		$new_options = $slot;
		if( ! isset( $_GET[ 'tab' ] ) ) $tab = '_main';
		else $tab = $_GET[ 'tab' ];
		
		foreach ( (array) $ca[ 'options' ] as $name => $option ) {
			
			if( ! isset( $option[ 'tab' ] ) ) $option[ 'tab' ] = '_main';
			if( $tab == $option[ 'tab' ] ) {
				if( $option[ 'type' ] == 'multiselect' ) {
					
					if( ! isset( $_POST[ $name ] ) || $_POST[ $name ] == array() ) unset( $new_options[ $name ] );
					else $new_options[ $name ] = $_POST[ $name ];


				} elseif( $option[ 'type' ] == 'switch' ) {
					if( isset( $_POST[ $name ] ) ) {
						$new_options[ $name ] = TRUE;
					} elseif( ! isset( $option[ 'tab' ] ) || $option[ 'tab' ] == '' ) {
						$new_options[ $name ] = FALSE;
					} else {
						$new_options[ $name ] = FALSE;
					}
				} else {
					if( isset( $_POST[ $name ] ) ) $new_options[ $name ] = $_POST[ $name ];
					// $new_options[ $name ] = $slot[ $name ] ;
				}
			}
		}


		do_action( 'wpvr_event_addon_options_saved' , $addon_id , $new_options , $old_options );

		update_option( $slot_name , $new_options );
		echo wpvr_get_json_response( null , 1 , 'Addon Options Saved.' );


		return FALSE;
	}
	
	//RESETING OPTIONS
	if( false && isset( $_GET[ 'reset_addon_options' ] ) ) {
		update_option( $slot_name , $ca[ 'defaults' ] );

		return FALSE;
	}
	
	
	//Ordering OPTIONS
	
	if( ! is_array( $ca[ 'options' ] ) || count( $ca[ 'options' ] ) == 0 ) $has_options = FALSE;
	else {
		$has_options   = TRUE;
		$addon_options = $ca[ 'options' ];
		foreach ( (array) $addon_options as $key => $row ) {
			$d[ $key ] = $row[ 'order' ];
		}
		array_multisort( $d , SORT_ASC , $addon_options );
	}
	
	if( $wpvr_options_tab == null ) $wpvr_options_tab = '_main';
	
	//new dBug( $slot );
?>

<div class = "wpvr_addon_options_wrapper" addon_id = "<?php echo $addon_id; ?>">
	<div class = "wpvr_addons_header">
		
		<?php do_action( 'wpvr_screen_addon_options_top' , $addon_id , $ca ); ?>
		
		<button
			id = "wpvr_save_addon_options"
			tab = "<?php echo $wpvr_options_tab; ?>"
			url = "<?php echo $action_url; ?>"
			type = "submit"
			class = "wpvr_save_addon_options pull-right wpvr_button"
		>
			<i class = "wpvr_button_icon fa fa-save"></i>
			<?php echo __( 'Save' , WPVR_LANG ) . ' ' . $wpvr_options_tab_label; ?>
		</button>
		
		<div class="wpvr_clearfix"></div>
		
	</div>
	<div class = "wpvr_addons_options">
		<form class = "wpvr_addons_options_form">
			<?php
				if( $has_options === FALSE ) {
					echo "There is no option defined for this addon.";
				} else {
					foreach ( (array) $addon_options as $option ) {
						$option[ 'addon_id' ] = $addon_id;
						if( ! isset( $option[ 'tab' ] ) ) $option[ 'tab' ] = '_main';

						if( $wpvr_options_tab == $option[ 'tab' ] ) {
							if( ! isset( $slot[ $option[ 'id' ] ] ) ) $slot[ $option[ 'id' ] ] = null;
							wpvr_addon_option_render( $option , $slot[ $option[ 'id' ] ] );
						}
					}
				}
			?>
		</form>
	</div>
	<div class = "wpvr_addons_footer">
		<?php do_action( 'wpvr_screen_addon_options_bottom' , $addon_id , $ca ); ?>
		<button
			url = "<?php echo $action_url; ?>"
			id = "wpvr_reset_addon_options"
			class = "pull-left wpvr_button wpvr_small wpvr_reset_addon_options wpvr_red_button"
		>
			<i class = "wpvr_button_icon fa fa-ban"></i><?php _e( 'Reset to default' , WPVR_LANG ); ?>
		</button>
		<button
			id = "wpvr_save_addon_options_bis"
			tab = "<?php echo $wpvr_options_tab; ?>"
			url = "<?php echo $action_url; ?>"
			type = "submit"
			class = "wpvr_save_addon_options pull-right wpvr_button"
		>
			<i class = "wpvr_button_icon fa fa-save"></i>
			<?php echo __( 'Save' , WPVR_LANG ) . ' ' . $wpvr_options_tab_label; ?>
		</button>
		<div class = "wpvr_clearfix"></div>

	</div>
	<div class = "wpvr_clearfix"></div>
</div>