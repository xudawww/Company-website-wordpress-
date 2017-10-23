<?php
/**
 * Infinite Photography Theme Customizer.
 *
 * @package Acme Themes
 * @subpackage Infinite Photography
 */

/*
* file for customizer core functions
*/
$infinite_photography_custom_controls_file_path = infinite_photography_file_directory('acmethemes/customizer/customizer-core.php');
require $infinite_photography_custom_controls_file_path;

/*
* file for customizer sanitization functions
*/
$infinite_photography_sanitize_functions_file_path = infinite_photography_file_directory('acmethemes/customizer/sanitize-functions.php');
require $infinite_photography_sanitize_functions_file_path;

/**
 * Adding different options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function infinite_photography_customize_register( $wp_customize ) {

    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

    /*saved options*/
    $options  = infinite_photography_get_theme_options();

    /*defaults options*/
    $defaults = infinite_photography_get_default_theme_options();

    /*
    * file for customizer custom controls classes
    */
    $infinite_photography_custom_controls_file_path = infinite_photography_file_directory('acmethemes/customizer/custom-controls.php');
    require $infinite_photography_custom_controls_file_path;

    /*
     * file for feature panel of home page
     */
    $infinite_photography_customizer_feature_option_file_path = infinite_photography_file_directory('acmethemes/customizer/feature-section/feature-panel.php');
    require $infinite_photography_customizer_feature_option_file_path;

    /*
    * file for header panel
    */
    $infinite_photography_customizer_header_options_file_path = infinite_photography_file_directory('acmethemes/customizer/header-options/header-panel.php');
    require $infinite_photography_customizer_header_options_file_path;

    /*
    * file for customizer footer panel
    */
    $infinite_photography_customizer_footer_options_file_path = infinite_photography_file_directory('acmethemes/customizer/footer-section/footer-panel.php');
    require $infinite_photography_customizer_footer_options_file_path;

    /*
    * file for design/layout panel
    */
    $infinite_photography_customizer_design_options_file_path = infinite_photography_file_directory('acmethemes/customizer/design-options/design-panel.php');
    require $infinite_photography_customizer_design_options_file_path;

	/*
   * file for single post sections
   */
	require_once infinite_photography_file_directory('acmethemes/customizer/single-posts/single-post-section.php');

    /*
     * file for options panel
     */
    $infinite_photography_customizer_options_panel_file_path = infinite_photography_file_directory('acmethemes/customizer/options/options-panel.php');
    require $infinite_photography_customizer_options_panel_file_path;

    /*
  * file for options reset
  */
    $infinite_photography_customizer_options_reset_file_path = infinite_photography_file_directory('acmethemes/customizer/options/options-reset.php');
    require $infinite_photography_customizer_options_reset_file_path;

    /*removing*/
    $wp_customize->remove_panel('header_image');
    $wp_customize->remove_control('header_textcolor');
}
add_action( 'customize_register', 'infinite_photography_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function infinite_photography_customize_preview_js() {
    wp_enqueue_script( 'infinite-photography-customizer', get_template_directory_uri() . '/acmethemes/core/js/customizer.js', array( 'customize-preview' ), '1.1.0', true );
}
add_action( 'customize_preview_init', 'infinite_photography_customize_preview_js' );


/**
 * Enqueue scripts for customizer
 */
function infinite_photography_customizer_js() {
    wp_enqueue_script('infinite-photography-customizer', get_template_directory_uri() . '/assets/js/infinite-photography-customizer.js', array('jquery'), '1.3.0', 1);

    wp_localize_script( 'infinite-photography-customizer', 'infinite_photography_customizer_js_obj', array(
        'pro' => __('Upgrade To Pro','infinite-photography')
    ) );
    wp_enqueue_style( 'infinite-photography-customizer', get_template_directory_uri() . '/assets/css/infinite-photography-customizer.css');
}
add_action( 'customize_controls_enqueue_scripts', 'infinite_photography_customizer_js' );
