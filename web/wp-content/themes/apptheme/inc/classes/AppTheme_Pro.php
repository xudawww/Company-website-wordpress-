<?php
/**
 * Premium functions that provide upgrades from the lite version
 *
 *
 * @package AppPresser Theme
 * @since   2.2.0
 */

class AppTheme_Pro {

	public static $instance = null;

	public function __construct() {

	}

	public function hooks() {
		
		add_filter( 'show_admin_bar', '__return_false' );

		return array(
			array( 'wp_footer', 'footer_js_can_ajax', 100 ),
			array( 'after_setup_theme', 'after_setup_theme' ),
			array( 'tgmpa_register', 'required_plugins'),
			array( 'template_redirect', 'required_plugins_front' ),
		);
	}

	public function after_setup_theme() {

		/**
		 * Include the TGM_Plugin_Activation class.
		 */
		if( ! class_exists( 'TGM_Plugin_Activation' ) ) {
			require_once( APPP_THEME_PATH .'inc/classes/TGM_Plugin_Activation.php' );
		}
	}

	/**
	 * Show a message if the AppPresser plugin is not active
	 * @since  0.0.1
	 */
	public function required_plugins_front() {
		if ( ! class_exists( 'AppPresser' ) )
			wp_die( '<p style="text-align:center;font-size:1.1em">'. sprintf( __( 'The free %s is required for this theme to function properly.', 'apptheme' ), '<a href="http://wordpress.org/plugins/apppresser">'. __( 'AppPresser Plugin', 'apptheme' ) .'</a>' ) .'</p>' );
	}

	/**
	 * Reads the apppresser admin setting for 'Disable Dynamic Page Loading'.
	 * @since 2.2.0
	 * @return boolean
	 */
	public static function get_can_ajax_logic() {
		return class_exists( 'AppPresser' ) ? AppPresser::settings( 'disable_theme_ajax' ) != 'on' : true;
	}

	/**
	 * Adds option to disable ajax in admin AppPresser settings page
	 * @since 2.2.0
	 */
	public static function theme_ajax_settings( $appp ) {
		$appp->add_setting( 'disable_theme_ajax', __( 'Disable dynamic page loading', 'apptheme' ), array(
			'type' => 'checkbox',
			'helptext' => __( 'The AppPresser theme relies heavily on ajax to avoid page refreshes. Many WordPress plugins are not compatible with ajax, so disabling may help resolve some issues.', 'apptheme' ),
		) );
	}

	/**
	 * Overwrites the apppresser.canAjax function which only returns false for AppTheme lite
	 * @since 2.2.0
	 * 
	 * @return string JavaScript for wp_footer
	 */
	public function footer_js_can_ajax() {
		?><script type="text/javascript">

		window.apppresser.canAjax = function( $element ) {
			return ( apppresser.appp.can_ajax && ! $element.is('.menu-back, .external, .no-ajax, .menu .no-ajax > a, .nav-divider, .modal-toggle, .modal-toggle a') || $element.is('.back')  );
		}
		</script><?php
	}

	/**
	 * Register the required plugins for this theme.
	 * @since  0.0.1
	 */
	public function required_plugins() {

		$plugins = array( array(
			'name'     => 'AppPresser Plugin',
			'slug'     => 'apppresser',
			'required' => true,
		) );

		tgmpa( $plugins, array(
			'domain'       => 'appp',
			'menu'         => 'install-apppresser-plugins',
			'has_notices'  => true,
			'is_automatic' => true,
			'message'      => '',
		) );

	}
}
