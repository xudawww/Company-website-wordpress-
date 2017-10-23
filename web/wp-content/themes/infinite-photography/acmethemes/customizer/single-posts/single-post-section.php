<?php
/*adding sections for Single post options*/
$wp_customize->add_section( 'infinite-photography-single-post', array(
    'priority'       => 90,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Single Post Options', 'infinite-photography' )
) );


/*single image size*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-single-image-size]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-single-image-size'],
    'sanitize_callback' => 'infinite_photography_sanitize_select'
) );
$choices = infinite_photography_get_image_sizes_options();
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-single-image-size]', array(
    'choices'  	=> $choices,
    'label'		=> __( 'Image Layout Options', 'infinite-photography' ),
    'section'   => 'infinite-photography-single-post',
    'settings'  => 'infinite_photography_theme_options[infinite-photography-single-image-size]',
    'type'	  	=> 'select',
    'priority'  => 20
) );


/*show related posts*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-show-related]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-show-related'],
    'sanitize_callback' => 'infinite_photography_sanitize_checkbox'
) );
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-show-related]', array(
    'label'		=> __( 'Show Related Posts In Single Post', 'infinite-photography' ),
    'section'   => 'infinite-photography-single-post',
    'settings'  => 'infinite_photography_theme_options[infinite-photography-show-related]',
    'type'	  	=> 'checkbox',
    'priority'  => 30
) );

/*Related title*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-related-title]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['infinite-photography-related-title'],
	'sanitize_callback' => 'sanitize_text_field'
) );
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-related-title]', array(
	'label'		=> __( 'Related Posts title', 'infinite-photography' ),
	'section'   => 'infinite-photography-single-post',
	'settings'  => 'infinite_photography_theme_options[infinite-photography-related-title]',
	'type'	  	=> 'text',
	'priority'  => 40
) );

/*related post by tag or category*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-related-post-display-from]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['infinite-photography-related-post-display-from'],
	'sanitize_callback' => 'infinite_photography_sanitize_select'
) );
$choices = infinite_photography_related_post_display_from();
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-related-post-display-from]', array(
	'choices'  	=> $choices,
	'label'		=> __( 'Related Post Display From Options', 'infinite-photography' ),
	'section'   => 'infinite-photography-single-post',
	'settings'  => 'infinite_photography_theme_options[infinite-photography-related-post-display-from]',
	'type'	  	=> 'select',
	'priority'  => 50
) );