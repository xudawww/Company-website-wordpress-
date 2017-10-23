<?php
/*adding sections for sidebar options */
$wp_customize->add_section( 'infinite-photography-design-sidebar-layout-option', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Default Singe Page/Post Sidebar Layout', 'infinite-photography' ),
    'panel'          => 'infinite-photography-design-panel'
) );

/*Sidebar Layout*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-sidebar-layout]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-sidebar-layout'],
    'sanitize_callback' => 'infinite_photography_sanitize_select'
) );
$choices = infinite_photography_sidebar_layout();
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-sidebar-layout]', array(
    'choices'  	=> $choices,
    'label'		=> __( 'Default Sidebar Layout', 'infinite-photography' ),
    'section'   => 'infinite-photography-design-sidebar-layout-option',
    'settings'  => 'infinite_photography_theme_options[infinite-photography-sidebar-layout]',
    'type'	  	=> 'select'
) );