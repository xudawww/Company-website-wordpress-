<?php
/**
 * MeisterMag Customizer functionality
 *
 * @since MeisterMag 1.0
 */

if ( ! function_exists( 'tagdiv_customize_register' ) ) {
	/**
	 * add theme customizer options/functionality
	 * @param $wp_customize
	 */
	function tagdiv_customize_register( $wp_customize ) {

		/* Theme Options Section */
		$wp_customize->add_section( 'tagdiv_options_section',
			array(
				'title'          => __( 'MesiterMag Theme Options', 'meistermag' ),
				'priority'       => 1,
				'capability' 	 => 'edit_theme_options',
				'description' 	 => __( 'Allows you to customize the footer settings for MesiterMag Theme.', 'meistermag'),
			)
		);

		/* Theme Footer Logo */
		$wp_customize->add_setting( 'tagdiv_theme_options[tagdiv_footer_logo]',
			array(
				'capability' 		=> 'edit_theme_options',
				'theme_supports' 	=> array( 'custom-logo' ),
				'sanitize_callback' => 'tagdiv_sanitize_image',
			)
		);

		/* Theme Footer Logo uploader */
		$tagdiv_custom_logo_args = get_theme_support( 'custom-logo' );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'tagdiv_footer_logo',
				array(
					'label'    	  	=> __( 'Footer Logo', 'meistermag' ),
					'description' 	=> __( 'Upload the logo you want to use in the Footer section.', 'meistermag' ),
					'section'  	  	=> 'tagdiv_options_section',
					'priority'    	=> 1,
					'settings' 	  	=> 'tagdiv_theme_options[tagdiv_footer_logo]',
					'height'        => $tagdiv_custom_logo_args[0]['height'],
					'width'         => $tagdiv_custom_logo_args[0]['width'],
					'flex_height'   => $tagdiv_custom_logo_args[0]['flex-height'],
					'flex_width'    => $tagdiv_custom_logo_args[0]['flex-width'],
					'button_labels' =>
						array(
							'select'       => __( 'Select logo', 'meistermag' ),
							'change'       => __( 'Change logo', 'meistermag' ),
							'remove'       => __( 'Remove', 'meistermag' ),
							'default'      => __( 'Default', 'meistermag' ),
							'placeholder'  => __( 'No logo selected', 'meistermag' ),
							'frame_title'  => __( 'Select logo', 'meistermag' ),
							'frame_button' => __( 'Choose logo', 'meistermag' ),
						)
				)
			)
		);

		/* Theme Subfooter Copyright Text */
		$wp_customize->add_setting( 'tagdiv_theme_options[tagdiv_subfooter_copyright]',
			array(
				'capability' 		=> 'edit_theme_options',
				'default' 			=> sprintf( esc_html__( '%s MeisterMag Theme - Free <a href="http://wordpress.org">WordPress</a> Theme made with <i class="tagdiv-icon-heart"></i> by <b>WPion</b>.', 'meistermag' ), date('Y') ),
				'sanitize_callback' => 'force_balance_tags',
			)
		);

		$wp_customize->add_control( 'tagdiv_subfooter_copyright',
			array(
				'label'      	=> __( 'Sub-Footer Copyright Text', 'meistermag' ),
				'description' 	=> __( 'Add here the sub-footer copyright text', 'meistermag' ),
				'section'    	=> 'tagdiv_options_section',
				'priority'      => 4,
				'type' 		  	=> 'textarea',
				'settings' 		=> 'tagdiv_theme_options[tagdiv_subfooter_copyright]',
			)
		);

		/* Theme Accent Color */
		$wp_customize->add_setting( 'tagdiv_theme_options[tagdiv_accent_color]',
			array(
				'capability' 		=> 'edit_theme_options',
				'default' 			=> '#42bdcd',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tagdiv_accent_color',
				array(
					'label'    	  	=> __( 'Theme Accent Color', 'meistermag' ),
					'description' 	=> __( 'Change the theme accent color.', 'meistermag' ),
					'section'  	  	=> 'colors',
					'settings' 	  	=> 'tagdiv_theme_options[tagdiv_accent_color]'
				)
			)
		);

		/* Text Logo Color */
		$wp_customize->add_setting( 'tagdiv_theme_options[tagdiv_text_logo_color]',
			array(
				'capability' 		=> 'edit_theme_options',
				'default' 			=> '#2b2b2b',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tagdiv_text_logo_color',
				array(
					'label'    	  	=> __( 'Text Logo Color', 'meistermag' ),
					'description' 	=> __( 'Change the color of the text ( site title ) logo.', 'meistermag' ),
					'section'  	  	=> 'colors',
					'settings' 	  	=> 'tagdiv_theme_options[tagdiv_text_logo_color]'
				)
			)
		);

		/* Theme Subfooter Copyright Symbol */
		$wp_customize->add_setting( 'tagdiv_theme_options[tagdiv_subfooter_copyright_symbol]',
			array(
				'capability' 		=> 'edit_theme_options',
				'default'           => '1',
				'sanitize_callback' => 'tagdiv_sanitize_checkbox',
			)
		);

		$wp_customize->add_control( 'tagdiv_subfooter_copyright_symbol',
			array(
				'label'      	=> __( 'Copyright Symbol', 'meistermag' ),
				'description' 	=> __( 'Show/Hide the footer copyright symbol', 'meistermag' ),
				'section'    	=> 'tagdiv_options_section',
				'priority'      => 5,
				'type' 		  	=> 'checkbox',
				'settings' 		=> 'tagdiv_theme_options[tagdiv_subfooter_copyright_symbol]',
			)
		);

		/* Theme Home Blocks Titles Settings */
		$wp_customize->add_setting( 'tagdiv_theme_options[tagdiv_block_1_title]',
			array(
				'capability' 	 	=> 'edit_theme_options',
				'default'           => __( 'Block 1 Title', 'meistermag' ),
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control( 'tagdiv_block_1_title',
			array(
				'label'      	=> __( 'Homepage Block 1 Title', 'meistermag' ),
				'description' 	=> __( 'Use this option to set the Block 1 Title on all theme\'s homepages', 'meistermag' ),
				'section'  	  	=> 'tagdiv_options_section',
				'priority'    	=> 6,
				'settings' 	  	=> 'tagdiv_theme_options[tagdiv_block_1_title]',
			)
		);

		$wp_customize->add_setting( 'tagdiv_theme_options[tagdiv_block_2_title]',
			array(
				'capability' 	 	=> 'edit_theme_options',
				'default'           => __( 'Block 2 Title', 'meistermag' ),
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control( 'tagdiv_block_2_title',
			array(
				'label'      	=> __( 'Homepage Block 2 Title', 'meistermag' ),
				'description' 	=> __( 'Use this option to set the Block 2 Title on all theme\'s homepages', 'meistermag' ),
				'section'  	  	=> 'tagdiv_options_section',
				'priority'    	=> 6,
				'settings' 	  	=> 'tagdiv_theme_options[tagdiv_block_2_title]',
			)
		);

		$wp_customize->add_setting( 'tagdiv_theme_options[tagdiv_block_3_title]',
			array(
				'capability' 	 	=> 'edit_theme_options',
				'default'           => __( 'Block 3 Title', 'meistermag' ),
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control( 'tagdiv_block_3_title',
			array(
				'label'      	=> __( 'Homepage Block 3 Title', 'meistermag' ),
				'description' 	=> __( 'Use this option to set the Block 3 Title on all theme\'s homepages', 'meistermag' ),
				'section'  	  	=> 'tagdiv_options_section',
				'priority'    	=> 6,
				'settings' 	  	=> 'tagdiv_theme_options[tagdiv_block_3_title]',
			)
		);

		$wp_customize->add_setting( 'tagdiv_theme_options[tagdiv_block_4_title]',
			array(
				'capability' 	 	=> 'edit_theme_options',
				'default'           => __( 'Block 4 Title', 'meistermag' ),
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control( 'tagdiv_block_4_title',
			array(
				'label'      	=> __( 'Homepage Block 4 Title', 'meistermag' ),
				'description' 	=> __( 'Use this option to set the Block 4 Title on all theme\'s homepages', 'meistermag' ),
				'section'  	  	=> 'tagdiv_options_section',
				'priority'    	=> 6,
				'settings' 	  	=> 'tagdiv_theme_options[tagdiv_block_4_title]',
			)
		);

		$wp_customize->add_setting( 'tagdiv_theme_options[tagdiv_block_5_title]',
			array(
				'capability' 	 	=> 'edit_theme_options',
				'default'           => __( 'Block 5 Title', 'meistermag' ),
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control( 'tagdiv_block_5_title',
			array(
				'label'      	=> __( 'Homepage Block 5 Title', 'meistermag' ),
				'description' 	=> __( 'Use this option to set the Block 5 Title on all theme\'s homepages', 'meistermag' ),
				'section'  	  	=> 'tagdiv_options_section',
				'priority'    	=> 6,
				'settings' 	  	=> 'tagdiv_theme_options[tagdiv_block_5_title]',
			)
		);

		$wp_customize->add_setting( 'tagdiv_theme_options[tagdiv_block_6_title]',
			array(
				'capability' 	 	=> 'edit_theme_options',
				'default'           => __( 'Block 6 Title', 'meistermag' ),
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control( 'tagdiv_block_6_title',
			array(
				'label'      	=> __( 'Homepage Block 6 Title', 'meistermag' ),
				'description' 	=> __( 'Use this option to set the Block 6 Title on all theme\'s homepages', 'meistermag' ),
				'section'  	  	=> 'tagdiv_options_section',
				'priority'    	=> 6,
				'settings' 	  	=> 'tagdiv_theme_options[tagdiv_block_6_title]',
			)
		);

		/* Theme Latest Posts Section Title Settings */
		$wp_customize->add_setting( 'tagdiv_theme_options[tagdiv_latest_section_title]',
			array(
				'capability' 	 	=> 'edit_theme_options',
				'default'           => __( 'Latest Articles', 'meistermag' ),
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control( 'tagdiv_latest_section_title',
			array(
				'label'      	=> __( 'Homepage Latest Articles Section Title', 'meistermag' ),
				'description' 	=> __( 'Use this option to set the latest articles section title for theme\'s homepages', 'meistermag' ),
				'section'  	  	=> 'tagdiv_options_section',
				'priority'    	=> 7,
				'settings' 	  	=> 'tagdiv_theme_options[tagdiv_latest_section_title]',
			)
		);

	}
}
add_action( 'customize_register', 'tagdiv_customize_register', 11 );