<?php
/*adding footer options panel*/
$wp_customize->add_panel( 'infinite-photography-footer-panel', array(
    'priority'       => 80,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Footer Options', 'infinite-photography' ),
    'description'    => __( 'Customize your awesome site footer ', 'infinite-photography' )
) );

/*adding sections for footer options*/
$wp_customize->add_section( 'infinite-photography-footer-option', array(
    'priority'       => 170,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Copyright Option', 'infinite-photography' ),
    'panel'          => 'infinite-photography-footer-panel'
) );

/*copyright*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-footer-copyright]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-footer-copyright'],
    'sanitize_callback' => 'wp_kses_post'
) );
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-footer-copyright]', array(
    'label'		=> __( 'Copyright Text', 'infinite-photography' ),
    'section'   => 'infinite-photography-footer-option',
    'settings'  => 'infinite_photography_theme_options[infinite-photography-footer-copyright]',
    'type'	  	=> 'text',
    'priority'  => 2
) );


/*
* file for footer logo options
*/
$infinite_photography_customizer_footer_logo_file_path = infinite_photography_file_directory('acmethemes/customizer/footer-section/social-options.php');
require $infinite_photography_customizer_footer_logo_file_path;