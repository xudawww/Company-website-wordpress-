<?php
/*adding sections for default layout options panel*/
$wp_customize->add_section( 'infinite-photography-archive-sidebar-layout', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Category/Archive Sidebar Layout', 'infinite-photography' ),
    'panel'          => 'infinite-photography-design-panel'
) );

/*Sidebar Layout*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-archive-sidebar-layout]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-archive-sidebar-layout'],
    'sanitize_callback' => 'infinite_photography_sanitize_select'
) );
$choices = infinite_photography_sidebar_layout();
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-archive-sidebar-layout]', array(
    'choices'  	    => $choices,
    'label'		    => __( 'Category/Archive Sidebar Layout', 'infinite-photography' ),
    'description'   => __( 'Sidebar Layout for listing pages like category, author etc', 'infinite-photography' ),
    'section'       => 'infinite-photography-archive-sidebar-layout',
    'settings'      => 'infinite_photography_theme_options[infinite-photography-archive-sidebar-layout]',
    'type'	  	    => 'select'
) );