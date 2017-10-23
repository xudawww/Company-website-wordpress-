<?php
/*adding sections for default layout options panel*/
$wp_customize->add_section( 'infinite-photography-front-page-sidebar-layout', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Front/Home Sidebar Layout', 'infinite-photography' ),
    'panel'          => 'infinite-photography-design-panel'
) );

/*Sidebar Layout*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-front-page-sidebar-layout]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-front-page-sidebar-layout'],
    'sanitize_callback' => 'infinite_photography_sanitize_select'
) );
$choices = infinite_photography_sidebar_layout();
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-front-page-sidebar-layout]', array(
    'choices'  	=> $choices,
    'label'		=> __( 'Front/Home Sidebar Layout', 'infinite-photography' ),
    'section'   => 'infinite-photography-front-page-sidebar-layout',
    'settings'  => 'infinite_photography_theme_options[infinite-photography-front-page-sidebar-layout]',
    'type'	  	=> 'select'
) );