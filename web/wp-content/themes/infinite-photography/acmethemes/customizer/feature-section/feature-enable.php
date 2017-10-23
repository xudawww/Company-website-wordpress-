<?php
/*adding sections for enabling feature section in front page*/
$wp_customize->add_section( 'infinite-photography-enable-feature', array(
    'priority'       => 30,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Enable Feature Section', 'infinite-photography' ),
    'panel'          => 'infinite-photography-feature-panel'
) );

/*enable feature section*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-enable-feature]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-enable-feature'],
    'sanitize_callback' => 'infinite_photography_sanitize_checkbox'
) );

$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-enable-feature]', array(
    'label'		    => __( 'Enable Feature Section', 'infinite-photography' ),
    'description'	=> __( 'Feature section will display on front/home page', 'infinite-photography' ),
    'section'       => 'infinite-photography-enable-feature',
    'settings'      => 'infinite_photography_theme_options[infinite-photography-enable-feature]',
    'type'	  	    => 'checkbox',
    'priority'      => 10
) );

/*feature text*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-feature-text]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-feature-text'],
    'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-feature-text]', array(
    'label'		    => __( 'Feature Text', 'infinite-photography' ),
    'section'       => 'header_image',
    'settings'      => 'infinite_photography_theme_options[infinite-photography-feature-text]',
    'type'	  	    => 'text',
    'priority'      => 0
) );