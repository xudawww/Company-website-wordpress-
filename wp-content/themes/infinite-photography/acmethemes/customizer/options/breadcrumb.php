<?php
/*adding sections for breadcrumb */
$wp_customize->add_section( 'infinite-photography-breadcrumb-options', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Breadcrumb Options', 'infinite-photography' ),
    'panel'          => 'infinite-photography-options'
) );

/*show breadcrumb*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-show-breadcrumb]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-show-breadcrumb'],
    'sanitize_callback' => 'infinite_photography_sanitize_checkbox'
) );

$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-show-breadcrumb]', array(
    'label'		=> __( 'Enable Breadcrumb', 'infinite-photography' ),
    'section'   => 'infinite-photography-breadcrumb-options',
    'settings'  => 'infinite_photography_theme_options[infinite-photography-show-breadcrumb]',
    'type'	  	=> 'checkbox',
    'priority'  => 7
) );