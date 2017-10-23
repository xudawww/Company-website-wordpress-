<?php
global $wp_version;
// Return if wp version less than 4.5
if ( version_compare( $wp_version, '4.5', '<' ) ){
    /*header logo*/
    $wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-header-logo]', array(
        'capability'		=> 'edit_theme_options',
        'default'			=> $defaults['infinite-photography-header-logo'],
        'sanitize_callback' => 'esc_url_raw'
    ) );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'infinite_photography_theme_options[infinite-photography-header-logo]',
            array(
                'label'		=> __( 'Logo', 'infinite-photography' ),
                'section'   => 'title_tagline',
                'settings'  => 'infinite_photography_theme_options[infinite-photography-header-logo]',
                'type'	  	=> 'image',
                'priority'  => 10
            )
        )
    );
}

/*header logo/text display options*/
$wp_customize->add_setting( 'infinite_photography_theme_options[infinite-photography-header-id-display-opt]', array(
    'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['infinite-photography-header-id-display-opt'],
    'sanitize_callback' => 'infinite_photography_sanitize_select'
) );
$choices = infinite_photography_header_id_display_opt();
$wp_customize->add_control( 'infinite_photography_theme_options[infinite-photography-header-id-display-opt]', array(
    'choices'  	=> $choices,
    'label'		=> __( 'Logo/Site Title-Tagline Display Options', 'infinite-photography' ),
    'section'   => 'title_tagline',
    'settings'  => 'infinite_photography_theme_options[infinite-photography-header-id-display-opt]',
    'type'	  	=> 'radio',
    'priority'  => 20
) );