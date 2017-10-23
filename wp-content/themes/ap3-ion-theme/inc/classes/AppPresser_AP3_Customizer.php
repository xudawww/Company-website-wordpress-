<?php
/**
 * AppPresser Theme Theme Customizer
 *
 * @package Ion
 * @since   0.0.1
 */

class AppPresser_AP3_Customizer {

	public $colors = array();

	/**
	 * AppPresser_Customizer hooks
	 * @since 1.0.6
	 */
	public function hooks() {

		return array(
			array( 'customize_register', 'register', 20  ),
			// make Theme Customizer preview reload changes asynchronously.
			array( 'customize_preview_init', 'preview_js' ),
			// Now that the controls are set, add code to wp_head
			array( 'wp_head', 'customizer_css', 210 ), // run action late
		);
	}
	

	/**
	 * Add settings/controls to the Theme Customizer.
	 * @since 0.0.1
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function register( $wp_customize ) {

		$wp_customize->remove_section("static_front_page");

		/**
		 * Add Settings
		 */

		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		// $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
		$wp_customize->add_setting( 'appp_logo' ); // Add setting for logo uploader

		/**
		 * Custom Controls
		 */

		// Add control for logo uploader (actual uploader)
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'appp_logo', array(
			'label'    => __( 'Upload Logo (replaces text)', 'ap3-ion-theme' ),
			'section'  => 'title_tagline',
			'settings' => 'appp_logo',
		) ) );

		$wp_customize->add_setting( 'list_control' );
		$wp_customize->add_control( 'homepage_list_control', array(
			'type'     => 'select',
			'label'    => __( 'List Style', 'ap3-ion-theme' ),
			'section'  => 'static_mobile_front_page',
			'description'    => 'Choose a different list style for your app.',
			'priority' => 123,
			'settings' => 'list_control',
	        'choices' => array(
	            'medialist' => 'Thumbnail list',
	            'list' => 'No thumbnails',
	            'cardlist' => 'Card List',
	        ),
		) );

		if( class_exists('AppPresser_Swipers')  ) {
		
			// Homepage checkbox
			$wp_customize->add_setting( 'slider_control' );
			$wp_customize->add_control( 'homepage_slider_control', array(
				'type'     => 'checkbox',
				'label'    => __( 'Add slider to homepage?', 'ap3-ion-theme' ),
				'section'  => 'static_mobile_front_page',
				'priority' => 124,
				'settings' => 'slider_control',
			) );

			// Category dropdown
			$categories = get_categories( array(
			    'orderby' => 'name',
			    'order'   => 'ASC'
			) );

			$_cats = array('all'=>'All');

			foreach ( $categories as $cat ) {
				$_cats[$cat->slug] = $cat->name;
			}
		
			$wp_customize->add_setting( 'slider_category_control', array( 'default' => 'all' ) );
			$wp_customize->add_control( 'homepage_slider_category_control', array(
				'type'     => 'select',
				'label'    => __( 'What category?', 'ap3-ion-theme' ),
				'section'  => 'static_mobile_front_page',
				'priority' => 125,
				'choices'  => $_cats,
				'settings' => 'slider_category_control',
				'description' => __('Uses slides custom post type by default. To show all posts, select a category below.', 'ap3-ion-theme'),
			) );

		}
		
		
		do_action( 'apptheme_add_customizer_control', $wp_customize );

		/**
		 * Color customizations
		 */

		foreach ( $this->colors() as $color_mod => $opts ) {
			$this->migrate_to_theme_mod( $color_mod );
			// Settings
			$wp_customize->add_setting( $color_mod, array(
				'default' => $opts['default'],
				'capability' => 'edit_theme_options',
			) );
			// Controls
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color_mod,
					array(
						'label' => $opts['label'],
						'section' => 'colors',
						'settings' => $color_mod,
					)
				)
			);
		} // endforeach

	}

	/**
	 * Move theme colors out of options (the old way) and into theme mods
	 * @since  1.0.3
	 * @param  array  $color Color option/mod
	 */
	public function migrate_to_theme_mod( $color_mod ) {
		if ( ! is_admin() || ! isset( $color_mod ) )
			return;
		// Check if option exists
		if ( $mod = get_option( $color_mod ) ) {
			// If so, migrate the option to a theme mod
			set_theme_mod( $color_mod, $mod );
			// delete the option
			delete_option( $color_mod );
		}
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 * @since 0.0.1
	 */
	public function preview_js() {
		wp_enqueue_script( 'appp_customizer', APPP_ION_URL .'js/customizer.js', array( 'customize-preview' ), AppPresser_Ion_Theme_Functions::VERSION, true );
	}

	/**
	 * Applies the custom CSS for the theme.
	 * @since  0.0.1
	 */
	public function customizer_css() {

		// Build our css string
		$css = '';
		foreach ( $this->colors() as $color_mod => $opts ) {
			$css .= $this->$color_mod();
		}

		// If we have any css, add it to the <head>
		if ( $css ) {
			echo "\n".'<style type="text/css" media="screen">'. "\n" . $css . '</style>'."\n";
		}
	}

	/**
	 * All our color options and associated css selectors
	 * @since  1.0.3
	 * @return array  Array of color info
	 */
	public function colors() {
		if ( ! empty( $this->colors ) )
			return $this->colors;

		$colors = array(
			'body_bg' => array(
				'default' => '#ffffff',
				'label'   => __( 'Body Background', 'ap3-ion-theme' ),
				'sprintf' => 'body, body #page, .io-modal, #buddypress div.activity-comments form.ac-form { background-color: **color**; } .swiper-carousel .swiper-slide { border-color: **color**; }',
			),
			'text_color' => array(
				'default' => '#333333',
				'label'   => __( 'Text Color', 'ap3-ion-theme' ),
				'sprintf' => 'body, p, .item p, .entry-content p, .item, .input-label, .entry-meta, .list-group a, .list-group a:visited, .activity-list .activity-header p, .activity-list .activity-header a, .activity-list .acomment-meta, .activity-list .acomment-meta a, .activity-list .acomment-options a { color: **color**; }',
			),
			'link_color' => array(
				'default' => '',
				'label' => __( 'Link Color', 'ap3-ion-theme' ),
				'sprintf' => 'a,a:visited { color: **color**; }',
			),
			/* 'link_hover' => array(
				'default' => '#2d7639',
				'label' => __( 'Link Hover Color', 'appp_ion' ),
				'sprintf' => '#main a:hover, #main a:focus, #main a:active { color: **color**; }',
			), */
			'button_bg_primary' => array(
				'default' => '#1495cf',
				'label' => __( 'Primary Button Background', 'ap3-ion-theme' ),
				'sprintf' => '.button-primary, input[type="submit"], #buddypress input[type=submit], .woocommerce .quantity .plus, .woocommerce .quantity .minus, .woocommerce .quantity input.qty, .woocommerce .single_add_to_cart_button, .woocommerce .checkout-button, .pager li a { background-color: **color** !important; }',
			),
			'button_text_primary' => array(
				'default' => '#ffffff',
				'label' => __( 'Primary Button Text', 'ap3-ion-theme' ),
				'sprintf' => '.button-primary, .menu-left a.button-primary, .button-primary i, .button-primary a, input[type="submit"], #buddypress input[type=submit], .woocommerce .quantity .plus, .woocommerce .quantity .minus, .woocommerce .quantity input.qty, .woocommerce .single_add_to_cart_button, .woocommerce .checkout-button, .pager li a { color: **color** !important; }',
			),
			'button_bg_secondary' => array(
				'default' => '#eeeeee',
				'label' => __( 'Secondary Button Background', 'ap3-ion-theme' ),
				'sprintf' => '.button-secondary, .button.bp-secondary-action { background-color: **color** !important; }',
			),
			'button_text_secondary' => array(
				'default' => '#333333',
				'label' => __( 'Secondary Button Text', 'ap3-ion-theme' ),
				'sprintf' => '.button-secondary, .button-secondary i, .button-secondary a, .button.bp-secondary-action { color: **color** !important; }',
			),
			'headings_color' => array(
				'default' => '#333333',
				'label' => __( 'Headings Color', 'ap3-ion-theme' ),
				'sprintf' => '#main h1, #main h2, #main h3, #main h4, #main h1 a, #main h2 a, #main h3 a, #main h4 a, .item .item-title, .io-modal h4 { color: **color**; }',
			),
			'top_bar_bg_color' => array(
				'default' => '#1495cf',
				'label' => __( 'Header/Footer Bg Color', 'ap3-ion-theme' ),
				'sprintf' => 'body .bar-header, .bar-footer, .footer-menu, .tabs { background-color: **color**; }',
			),
			'top_bar_text_color' => array(
				'default' => '#ffffff',
				'label' => __( 'Header/Footer Text Color', 'ap3-ion-theme' ),
				'sprintf' => 'body .bar-header, .bar-footer, .footer-menu, .bar-header a, .footer-menu .tab-item, .footer-menu .tab-item a, .bar-header i, .footer-menu .tab-item i, .bar-header .button { color: **color** !important; }',
			),
			'left_menu_bg' => array(
				'default' => '#fafafa',
				'label' => __( 'Left Menu Background', 'ap3-ion-theme' ),
				'sprintf' => '.menu-left, .menu-left ul ul, .menu-left ul ul ul, .cart-items .cart-contents .amount { background-color: **color**; }',
			),
			'left_menu_text' => array(
				'default' => '#333333',
				'label' => __( 'Left Menu Text', 'ap3-ion-theme' ),
				'sprintf' => '.menu-left, .menu-left a, .cart-items, .cart-items a, .menu-left .nav-divider a, .menu-left .user-name { color: **color** !important; }',
			),
		);
		
		
		$this->colors = apply_filters( 'apptheme_customizer_color_filter', $colors );

		return $this->colors;
	}

	/**
	 * Fallback method.. Takes a color_mod key and creates css for the setting.
	 * @since  1.0.3
	 * @param  string  $color_mod Name of the method called, our color theme mods
	 * @param  array   $args      Arguments passed to the method
	 * @return string             CSS selectors
	 */
	public function __call( $color_mod, $args ) {
		// If not a color mod, then stop here
		if ( ! array_key_exists( $color_mod, $this->colors() ) )
			return '';
		// Ok, see if we have a stored setting
		$mod = get_theme_mod( $color_mod );
		
		// If so, and we have a css format, create the css selector
		if ( isset( $this->colors[ $color_mod ]['sprintf'] ) && $mod ) {
			return $this->format( $this->colors[ $color_mod ]['sprintf'], $mod );
		}
	}

	/**
	 * Format the css string with the mod data
	 * @since  1.0.3
	 * @param  string  $format Format string
	 * @param  string  $data   CSS color string
	 * @return string          Formatted css selector string
	 */
	public function format( $format, $data ) {
		$formatted = str_ireplace(
			array( '**color**', "\t", '; }', ' { ', '} ' ),
			array( $data, '', ";\n}", " {\n\t", "}\n" ),
			$format
		). "\n";
		return $formatted;
	}

	/**
	 * Returns color: value in array for use in the API. Unmodified colors = false
	 * @since  0.0.1
	 * @param  string  $format Format string
	 * @param  string  $data   CSS color string
	 * @return string          Formatted css selector string
	 */
	public function return_colors() {

		$colors = array();

		foreach ( $this->colors() as $color_mod => $value ) {
			$colors[ $color_mod ] = get_theme_mod($color_mod);
		}

		return $colors;
	}
}

function appp_customizer_live_preview() {
	// missing theme-customizer.js file
	wp_enqueue_script(
		'appp-theme-customizer',
		get_template_directory_uri() . '/js/theme-customizer.js',
		array( 'jquery', 'customize-preview' ),
		'',
		true
	);

} 
// add_action( 'customize_preview_init', 'appp_customizer_live_preview' );/ add_action( 'customize_preview_init', 'appp_customizer_live_preview' );