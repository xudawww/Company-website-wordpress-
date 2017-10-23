<?php
/*adding sections for custom css options */
$wp_customize->add_section( 'infinite-photography-design-custom-css-option', array(
    'priority'       => 60,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Custom CSS', 'infinite-photography' ),
    'panel'          => 'infinite-photography-design-panel'
) );

/*custom-css*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-custom-css]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-custom-css'],
    'sanitize_callback'    => 'wp_filter_nohtml_kses',
    'sanitize_js_callback' => 'wp_filter_nohtml_kses'
) );
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-custom-css]', array(
    'label'		=> __( 'Custom CSS', 'infinite-photography' ),
    'section'   => 'infinite-photography-design-custom-css-option',
    'settings'  => 'infinite_photography_theme_options[infinite-photography-custom-css]',
    'type'	  	=> 'textarea',
    'priority'  => 2
) );