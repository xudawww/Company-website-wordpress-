<?php
/*adding sections for Search Placeholder*/
$wp_customize->add_section( 'infinite-photography-search', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Search', 'infinite-photography' ),
    'panel'          => 'infinite-photography-options'
) );

/*Search Placeholder*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-search-placeholder]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-search-placeholder'],
    'sanitize_callback' => 'sanitize_text_field',
) );
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-search-placeholder]', array(
    'label'		=> __( 'Search Placeholder', 'infinite-photography' ),
    'section'   => 'infinite-photography-search',
    'settings'  => 'infinite_photography_theme_options[infinite-photography-search-placeholder]',
    'type'	  	=> 'text',
    'priority'  => 10
) );