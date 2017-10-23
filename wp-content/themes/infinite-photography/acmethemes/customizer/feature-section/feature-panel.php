<?php
/*adding feature options panel*/
$wp_customize->add_panel( 'infinite-photography-feature-panel', array(
    'priority'       => 70,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Featured Section Options', 'infinite-photography' ),
    'description'    => __( 'Customize your awesome site feature section ', 'infinite-photography' )
) );

/*
* file for feature section enable
*/
$infinite_photography_customizer_feature_enable_file_path = infinite_photography_file_directory('acmethemes/customizer/feature-section/feature-enable.php');
require $infinite_photography_customizer_feature_enable_file_path;

/*adding header image inside this panel*/
$wp_customize->get_section( 'header_image' )->panel = 'infinite-photography-feature-panel';
$wp_customize->get_section( 'header_image' )->description = __( 'Applied to the header image on home/front page', 'infinite-photography' );
$wp_customize->remove_control( 'display_header_text' );


/* feature section height*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-header-height]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['infinite-photography-header-height'],
	'sanitize_callback' => 'infinite_photography_sanitize_number'
) );

$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-header-height]', array(
	'type'        => 'range',
	'priority'    => 1,
	'section'     => 'header_image',
	'label'		  => __( 'Inner Page Header Section Height( In)', 'infinite-photography' ),
	'description' => __( 'Control the height of Header section. The minimum height is 100px and maximium height is 500px', 'infinite-photography' ),
	'input_attrs' => array(
		'min'   => 100,
		'max'   => 500,
		'step'  => 1,
		'class' => 'infinite-photography-header-height',
		'style' => 'color: #0a0',
	),
) );