<?php

require_once( 'inc/classes/AppPresser_3_Theme_Setup.php' );

// Only include if it doesn't already exist in a child theme.
if ( ! class_exists( 'AppPresser_3_Theme_Settings' ) ) {

/**
 * AppPresser Theme Settings Setup
 *
 * @package Ion
 * @since   0.0.1
 */
class AppPresser_3_Theme_Settings extends AppPresser_Admin_Settings {

	private static $done = null;
	private $updater     = null;

	/**
	 * Setup AppPresser_3_Theme_Settings
	 * @since 1.0.1
	 */
	public function __construct() {
		if ( null !== self::$done )
			return;

		add_action( 'after_setup_theme', array( $this, 'updater' ) );
		// Add it late to be below extension options
		add_action( 'apppresser_add_settings', array( $this, 'theme_options' ), 50 );

		self::$done = true;
	}

	/**
	 * Add the updater to the theme
	 * @since  0.0.1
	 */
	public function updater() {
		if ( null !== $this->updater )
			return $this->updater;

		$this->updater = appp_theme_updater_add( AppPresser_3_Theme_Setup::THEME_SLUG, AppPresser_3_Theme_Setup::APPP_KEY, array(
			'item_name' => AppPresser_3_Theme_Setup::THEME_NAME,
			'version'   => AppPresser_3_Theme_Setup::VERSION,
		) );

		return $this->updater;
	}

	/**
	 * Adds a checkbox to disable the theme's ajax page loading on the AppPresser Core plugin's settings page
	 * @since  0.0.1
	 * @param  object $appp The AppPresser_Admin_Settings instance
	 */
	public function theme_options( $appp ) {
		// $appp->add_setting_tab( __( 'AppPresser Theme Settings', 'appp_ion' ), 'appp-theme' );
		
		$appp->add_setting( AppPresser_3_Theme_Setup::APPP_KEY, __( 'AP3 Theme License Key', 'ap3-ion-theme' ), array( 'type' => 'license_key', 'helptext' => __( 'Adding a license key enables automatic updates.', 'ap3-ion-theme' ) ) );

	}

}

$GLOBALS['AppPresser_3_Theme_Settings'] = new AppPresser_3_Theme_Settings();

} // end class_exists check
