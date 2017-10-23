<?php
/*adding sections for header options panel*/
$wp_customize->add_section( 'infinite-photography-search-menu', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Search Options', 'infinite-photography' ),
    'panel'          => 'infinite-photography-header-panel'
) );

/*header show search*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-show-search]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-show-search'],
    'sanitize_callback' => 'infinite_photography_sanitize_checkbox'
) );
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-show-search]', array(
    'label'		=> __( 'Show Search on Menu', 'infinite-photography' ),
    'section'   => 'infinite-photography-search-menu',
    'settings'  => 'infinite_photography_theme_options[infinite-photography-show-search]',
    'type'	  	=> 'checkbox',
    'priority'  => 45
) );