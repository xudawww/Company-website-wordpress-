<?php
/**
 * AppPresser Extension Compatibility
 *
 * @package Ion
 * @since   0.0.1
 */

class AppPresser_AP3_Extension_Compatibility {

	public static $errorpath = 'php-error-log.php';

	/**
	 * Hooks
	 */
	public function hooks() {

		return array(
			array( 'after_setup_theme', 'after_setup_theme' ),
			array( 'wp_enqueue_scripts', 'extension_scripts_styles' ),
			//array( 'init', 'add_remove_hooks' )
		);

	}

	public function add_remove_hooks() {

		
	}

	/**
	 * New markup for appbuddy activity modal button
	 */
	function after_setup_theme() {

		// Add classes to menu items
		add_filter('nav_menu_css_class' , array( $this, 'special_nav_class'), 10 , 2);

		// AppShare
		add_filter( 'appshare_default_classes', array( $this, 'appshare_button_classes') );

		/**
		 * Check if AppBuddy is active
		 **/
		if ( in_array( 'appbuddy/appbuddy.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

			// BuddyPress/AppBuddy
			add_filter( 'appbuddy_modal_button', array($this, 'appbuddy_new_button') );
			add_filter( 'appbuddy_login_screen', array( $this, 'appbuddy_new_login' ) );
			remove_action( 'wp_footer', 'appbuddy_post_modal_template' );
			add_action( 'wp_footer', array( $this, 'appbuddy_new_activity_modal') );
			include_once( APPP_ION_PATH . 'buddypress/email-settings.php');

		}

		/**
		 * Check if AppCamera is active
		 **/
		if ( in_array( 'appcamera/appp-camera.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

			// AppCamera
			add_filter( 'appcamera_btn_classes', array($this, 'appcamera_new_btn_classes') );
			add_filter( 'appcamera_icon_camera', array($this, 'appcamera_icon_camera') );
			add_filter( 'appcamera_icon_gallery', array($this, 'appcamera_icon_gallery') );
		}


		// AppWoo 
		add_theme_support( 'woocommerce' );

		/**
		 * Check if WooCommerce is active
		 **/
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

		    //Remove Woo CSS
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
			add_filter( 'appp_woo_profile_icon_classes', array( $this, 'new_woo_profile_icon') );
			add_filter( 'apppresser_replace_woo_styles', '__return_false' );

		}

		/**
		 * Check if AppGeo is active
		 **/
		if ( in_array( 'appgeo/apppresser-geolocation.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

			// AppGeo
			add_action( 'wp_footer', array( $this, 'appp_ion_checkin_modal') );
			add_action( 'appp_header_right', array( $this, 'appp_ion_geo_header_btn' ) );
			add_filter( 'appgeo_button_class', array( $this, 'appgeo_button_class') );
			// Remove toolbar so we can add our own markup
			define('REMOVE_GEO_TOOLBAR', true);

		}

	}

	public function new_woo_profile_icon( $classes ) {
		return 'icon ion-ios-cart';
	}

	/*
	 * New default classes for appshare
	 */
	public function appshare_button_classes( $classes ) {
		return 'button icon-left ion-share';
	}

	/*
	 * Replace appgeo header icon
	 */
	public function appp_ion_checkin_modal() {

	?>
		<aside class="io-modal" id="geo-checkin-form" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="bar bar-header bar-white">
				<button class="button button-icon ion-location" onclick="AppGeo_center_Marker()"></button>
				<i class="io-modal-close icon ion-close-round"></i>
			</div>
			<div class="io-modal-content">
			<?php if ( is_user_logged_in() ) : ?>
				<?php $user_ID = get_current_user_id(); ?>
				<div id="map-canvas"></div>
				<a href="#" class="button button-primary button-block noajax btn-checkin" onclick="AppGeo_checkin( <?php echo $user_ID; ?> );"><?php _e('Check In', 'ap3-ion-theme') ; ?></a>
				<?php wp_nonce_field( 'ajax-geo-nonce', 'security' ); ?>
			<?php else: ?>
				<?php echo '<p>Please login.</p>';
					
					wp_login_form(); ?>
			<?php endif; ?>
			</div>
		</aside>
	<?php

	}

	/*
	 * Replace appgeo header icon
	 */
	public function appp_ion_geo_header_btn() {

		if ( is_user_logged_in() ) {
			echo '<a onclick="AppGeo_getLoc()" class="button button-icon ion-location io-modal-open" href="#geo-checkin-form"></a>';
		}

	}

	/*
	 * Default appgeo button classes
	 */
	public function appgeo_button_class( $classes ) {

		return 'button';

	}

	/*
	 * New login template for appbuddy
	 */
	public function appbuddy_new_login() {
		$template = APPP_ION_PATH . 'buddypress/appbuddy-login.php';

		return $template;
	}

	/*
	 * Add class of .item to all menu items. Needed for left menu
	 */
	public function special_nav_class($classes, $item){

		$classes[] = "item";

		return $classes;
	}

	/*
	 * Add .button class to appcamera buttons
	 */
	public function appcamera_new_btn_classes( $classes ) {

		$classes = 'button';

		return $classes;
	}

	public function appcamera_icon_camera( $classes ) {
		return 'icon ion-camera';
	}

	public function appcamera_icon_gallery( $classes ) {
		return 'icon ion-images';
	}

	/*
	 * Handle extension scripts/styles
	 */
	public function extension_scripts_styles() {
		wp_dequeue_style( 'bp-legacy-css' );
		wp_dequeue_style( 'idangerous-swiper' );
	}

	/*
	 * New Ionic style modal button
	 */
	public function appbuddy_new_button() {

		if ( is_user_logged_in() ) {

			return '<a id="activity-modal-icon" class="button button-icon ion-ios-compose-outline io-modal-open" href="#activity-post-form"></a>';

		} else {

			return '<a id="activity-modal-icon" class="button button-icon ion-ios-person io-modal-open" href="#loginModal"></a>';

		}

	}

	/*
	 * New Ionic style modal
	 */
	public function appbuddy_new_activity_modal() {
		?>
		<aside class="io-modal" id="activity-post-form" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="bar bar-header bar-white">
				<div class="title"></div>
				<i class="io-modal-close icon ion-close-round"></i>
			</div>
			<div class="io-modal-content">
			<?php if ( is_user_logged_in() ) : ?>
				<?php get_template_part( 'buddypress/content-bp_activity_form' ); ?>

			<?php else :

				echo '<a href="#loginModal" class="button button-block  button-primary io-modal-open">' . __('Click here to login', 'ap3-ion-theme') . '</a>';

			endif; ?>
			</div>
		</aside>
		<?php
	}

}