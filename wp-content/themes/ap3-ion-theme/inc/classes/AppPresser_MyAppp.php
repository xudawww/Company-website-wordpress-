<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Ion
 * @since   0.0.1
 */

if( !class_exists('AppPresser_MyAppp') ) {

	class AppPresser_MyAppp {

		public static $instance = null;

		/**
		* Creates or returns an instance of this class.
		* @since  1.0.0
		* @return A single instance of this class.
		*/
		public function run() {
			if ( self::$instance === null )
			  self::$instance = new self();

			$this->hooks();

			return self::$instance;
		}

		/**
		* Setup
		* @since  1.0.0
		*/
		public function __construct() {
		}

		public function hooks() {
			add_action( 'wp_head', array( $this, 'output_api_css') );
		}

		public function output_api_css() {

			$option = get_option('appp_settings');

			// get API data. Should be setting for site and app id
			// add_option( 'myapppresser_url', 'http://www.myapppresser.dev/', true );
			$api_url = get_option('myapppresser_url', 'https://myapppresser.com/');
			$site_slug = isset( $option['ap3_site_slug'] ) ? $option['ap3_site_slug'] : null;
			$app_id = isset( $option['ap3_app_id'] ) ? $option['ap3_app_id'] : null;

			if( empty( $site_slug ) || empty( $app_id ) )
				return;

			$data = wp_remote_retrieve_body( wp_remote_get( $api_url . $site_slug . '/wp-json/ap3/v1/app/' . $app_id ) );

			if( ! $data ) {
				return;
			} else if( substr($data, 0, 1) != '{' ) {
				return;
			}

			$data = json_decode( $data );

			$design = $data->meta->design;

			// format data and output to site
			echo "\n".'<style type="text/css" media="screen">'. "\n
			 body, body #page, .io-modal, #buddypress div.activity-comments form.ac-form { background-color: " . $design->body_bg . "; }\n
			 body, p, .item p, .entry-content p, .item, .input-label, .entry-meta, .list-group a, .list-group a:visited, .activity-list .activity-header p, .activity-list .activity-header a, .activity-list .acomment-meta, .activity-list .acomment-meta a, .activity-list .acomment-options a { color: " . $design->text_color . "; }\n
			 .button-primary, input[type=submit], #buddypress input[type=submit], .woocommerce .quantity .plus, .woocommerce .quantity .minus, .woocommerce .quantity input.qty, .woocommerce .single_add_to_cart_button, .woocommerce .checkout-button, .pager li a { background-color: " . $design->button_background . " !important; }\n
			 .button-primary, .menu-left a.button-primary, .button-primary i, .button-primary a, input[type=submit], #buddypress input[type=submit], .woocommerce .quantity .plus, .woocommerce .quantity .minus, .woocommerce .quantity input.qty, .woocommerce .single_add_to_cart_button, .woocommerce .checkout-button, .pager li a { color: " . $design->button_text . " !important; }\n
			 a,a:visited { color: " . $design->link_color . "; }\n
			 #main h1, #main h2, #main h3, #main h4, #main h1 a, #main h2 a, #main h3 a, #main h4 a, .item .item-title, .io-modal h4 { color: " . $design->headings_color . "; }\n

			 $design->custom_css;
			 
			 " . '</style>'."\n";

		}
	}

	$AppPresser_MyAppp = new AppPresser_MyAppp();
	$AppPresser_MyAppp->run();

}