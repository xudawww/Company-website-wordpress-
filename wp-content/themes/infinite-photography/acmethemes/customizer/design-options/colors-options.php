<?php
/*customizing default colors section and adding new controls-setting too*/
$wp_customize->add_section( 'colors', array(
    'priority'       => 40,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Colors', 'infinite-photography' ),
    'panel'          => 'infinite-photography-design-panel'
) );
/*Primary color*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-primary-color]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-primary-color'],
    'sanitize_callback' => 'sanitize_hex_color'
) );


$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'infinite_photography_theme_options[infinite-photography-primary-color]',
		array(
			'label'		=> __( 'Primary Color', 'infinite-photography' ),
			'section'   => 'colors',
			'settings'  => 'infinite_photography_theme_options[infinite-photography-primary-color]',
			'type'	  	=> 'color' 
		)
	)
);