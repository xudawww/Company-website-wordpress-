<?php
/*adding sections for footer social options */
$wp_customize->add_section( 'infinite-photography-footer-social', array(
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Social Options', 'infinite-photography' ),
    'panel'          => 'infinite-photography-footer-panel'
) );


/*enable social*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-enable-social]', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['infinite-photography-enable-social'],
	'sanitize_callback' => 'infinite_photography_sanitize_checkbox',
) );
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-enable-social]', array(
	'label'		=> __( 'Enable social', 'infinite-photography' ),
	'section'   => 'infinite-photography-footer-social',
	'settings'  => 'infinite_photography_theme_options[infinite-photography-enable-social]',
	'type'	  	=> 'checkbox',
	'priority'  => 10
) );

/*facebook url*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-facebook-url]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-facebook-url'],
    'sanitize_callback' => 'esc_url_raw',
) );
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-facebook-url]', array(
    'label'		=> __( 'Facebook url', 'infinite-photography' ),
    'section'   => 'infinite-photography-footer-social',
    'settings'  => 'infinite_photography_theme_options[infinite-photography-facebook-url]',
    'type'	  	=> 'url',
    'priority'  => 20
) );

/*twitter url*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-twitter-url]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-twitter-url'],
    'sanitize_callback' => 'esc_url_raw',
) );
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-twitter-url]', array(
    'label'		=> __( 'Twitter url', 'infinite-photography' ),
    'section'   => 'infinite-photography-footer-social',
    'settings'  => 'infinite_photography_theme_options[infinite-photography-twitter-url]',
    'type'	  	=> 'url',
    'priority'  => 25
) );

/*youtube url*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-youtube-url]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-youtube-url'],
    'sanitize_callback' => 'esc_url_raw',
) );
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-youtube-url]', array(
    'label'		=> __( 'Youtube url', 'infinite-photography' ),
    'section'   => 'infinite-photography-footer-social',
    'settings'  => 'infinite_photography_theme_options[infinite-photography-youtube-url]',
    'type'	  	=> 'url',
    'priority'  => 25
) );

/*Instagram url*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-instagram-url]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-instagram-url'],
    'sanitize_callback' => 'esc_url_raw',
) );
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-instagram-url]', array(
    'label'		=> __( 'Instagram url', 'infinite-photography' ),
    'section'   => 'infinite-photography-footer-social',
    'settings'  => 'infinite_photography_theme_options[infinite-photography-instagram-url]',
    'type'	  	=> 'url',
    'priority'  => 30
) );


/*@since 1.1.3
 * plus.google url*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-google-plus-url]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-google-plus-url'],
    'sanitize_callback' => 'esc_url_raw'
) );
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-google-plus-url]', array(
    'label'		=> __( 'Google Plus Url', 'infinite-photography' ),
    'section'   => 'infinite-photography-footer-social',
    'settings'  => 'infinite_photography_theme_options[infinite-photography-google-plus-url]',
    'type'	  	=> 'url',
    'priority'  => 40
) );

/*Pinterest  url*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-pinterest-url]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-pinterest-url'],
    'sanitize_callback' => 'esc_url_raw',
) );
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-pinterest-url]', array(
    'label'		=> __( 'Pinterest url', 'infinite-photography' ),
    'section'   => 'infinite-photography-footer-social',
    'settings'  => 'infinite_photography_theme_options[infinite-photography-pinterest-url]',
    'type'	  	=> 'url',
    'priority'  => 50
) );
