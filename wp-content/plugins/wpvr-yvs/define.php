<?php
	
	global $wpvr_addons , $wpvr_dynamics;
	global $wpvryvs_options;
	
	// Constants
	define( 'WPVRYVS_MAIN_FILE' , __FILE__ );
	define( 'WPVRYVS_PATH' , plugin_dir_path( WPVRYVS_MAIN_FILE ) );
	define( 'WPVRYVS_URL' , plugin_dir_url( WPVRYVS_MAIN_FILE ) );
	define( 'WPVRYVS_ID' , 'wpvr-yvs' );
	define( 'WPVRYVS_SLOT_NAME' , 'wpvr-yvs-options' );
	
	define( 'WPVRYVS_DEFAULT_CLIENT_ID' , 'b4cb7f858efacea5' );
	define( 'WPVRYVS_DEFAULT_CLIENT_SECRET' , 'd418fbb04a6295ae16ae185702aad342' );
	
	
	//Defining The Addon Data	
	$addon_infos = array(
		'id'                => WPVRYVS_ID ,
		'slot_name'         => WPVRYVS_SLOT_NAME ,
		'title'             => 'Youku Video Service' ,
		'description'       => 'Import videos from youku.com.' ,
		'excerpt'           => 'Import videos from youku.com.' ,
		'version'           => WPVRYVS_VERSION ,
		'wpvr_version'      => WPVRYVS_MIN_VERSION ,
		//'thumbnail_url' 		=> WPVRYVS_URL.'wpvr-dms.jpg',
		'addon_url'         => 'https://store.wpvideorobot.com/addons/youku-video-service/' ,
		'doc'         => 'http://support.wpvideorobot.com/tutorials/youku-video-service-tutorial/' ,
		'dashboard_enabled' => false ,
		'options_enabled'   => true ,
		'infos_enabled'     => false ,
		'free_addon'        => true ,
	);
	
	$addon_files = array(
		'infos' => WPVRYVS_PATH . 'includes/infos.php' ,
		'dash'  => WPVRYVS_PATH . 'includes/dash.php' ,
	);
	
	$addon_urls = array(
		'infos' => WPVRYVS_URL . 'includes/infos.php' ,
		'dash'  => WPVRYVS_URL . 'includes/dash.php' ,
	);
	
	
	//Defining Default Options
	$addon_defaults = array(
		'addon_enabled' => false ,
		'client_id'     => WPVRYVS_DEFAULT_CLIENT_ID ,
		'client_secret' => WPVRYVS_DEFAULT_CLIENT_SECRET ,
	);
	$addon_options  = array(
		
		'addon_enabled' => array(
			'id'          => 'addon_enabled' ,
			'order'       => 0 ,
			'label'       => sprintf( __( 'Enable %s' , WPVRYVS_ID ) , $addon_infos[ 'title' ] ) ,
			'desc'        => __( 'You can enable or disable the addon from this option.' , WPVRYVS_ID ) ,
			'type'        => 'switch' ,
			'masterOf'    => array(
				'client_id' ,
				'client_secret' ,
			) ,
			'masterValue' => '1' ,
		) ,
		
		
		'client_id'     => array(
			'id'    => 'client_id' ,
			'order' => 2 ,
			'label' => __( 'Youku API Client ID' , WPVRYVS_ID ) ,
			'desc'  => __( "Your Youku API client ID." , WPVRYVS_ID ) ,
			'type'  => 'text' ,
		) ,
		
		'client_secret' => array(
			'id'    => 'client_secret' ,
			'order' => 2 ,
			'label' => __( 'Youku API Client Secret' , WPVRYVS_ID ) ,
			'desc'  => __( "Your Youku API client Secret." , WPVRYVS_ID ) ,
			'type'  => 'text' ,
		) ,


	);
	
	$wpvr_addons[ WPVRYVS_ID ] = array(
		'infos'    => $addon_infos ,
		'options'  => $addon_options ,
		'defaults' => $addon_defaults ,
		'files'    => $addon_files ,
		'urls'     => $addon_urls ,
	);

	
	/* Throw error if WPVR not installed */
	if( ! defined( 'WPVR_IS_ON' ) ) {
		?>
		<div class = "error">
			<p>
				<b><?php _e( 'WP Video Robot ERROR' , 'wpvr' ); ?></b> : <br/>
				<?php printf( __( 'In order to work properly, <strong>%s</strong> needs WP Video Robot.' , WPVRYVS_ID ) , $addon_infos[ 'title' ] ); ?>
			</p>
		</div>
		<?php
		return false;
	}
	
	
	/* Throw error if WPVR version not updated */
	if( version_compare( WPVR_VERSION , WPVRYVS_MIN_VERSION , '<' ) ) {
		?>
		<div class = "error">
			<p>
				<b><?php _e( 'WP Video Robot ERROR' , 'wpvr' ); ?></b> : <br/>
				<?php printf( __( 'In order to work properly, <strong>%s</strong> needs WP Video Robot version <strong>%s</strong> at least.' , WPVRYVS_ID ) , $addon_infos[ 'title' ] , WPVRYVS_MIN_VERSION ); ?>
			</p>
		</div>
		<?php
		return false;
	}
	
	/* DEFINE ADDON MENU ITEMS */
	add_action( 'admin_menu' , 'wpvryvs_admin_actions' );
	function wpvryvs_admin_actions() {
		add_submenu_page(
			'wpvr-addons' ,
			__( 'Youku Video Service | WP video Robot' , WPVRYVS_ID ) ,
			' + Youku VS' ,
			'read' ,
			WPVRYVS_ID ,
			'wpvryvs_render'
		);

		function wpvryvs_render() {
			if( ! WPVR_NONADMIN_CAP_MANAGE && ! current_user_can( WPVR_USER_CAPABILITY ) ) {
				wpvr_refuse_access();
				return false;
			}
			global $addon_id;
			$addon_id = WPVRYVS_ID;
			include( WPVR_PATH . 'addons/wpvr.addons.php' );
		}
	}
	
	


