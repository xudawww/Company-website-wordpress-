<?php
/**
 * Whiteboard64 Theme Customizer
 *
 * @package Whiteboard64
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function whiteboard64_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';


	$wp_customize->add_panel( 'theme_option', array(
        'priority' => 60,
        'title' => __( 'Whiteboard64 Theme Option', 'whiteboard64' ),
        'description' => __( 'Lets configure your site with Whiteboard64 Theme Option', 'whiteboard64' ),
    ));    


    /**********************************************/
    /********** SOCIAL ICON LINKS SECTION ***********/
    /**********************************************/

    $wp_customize->add_section('whiteboard64_social_section',array(
        'priority' => 1,
        'title' => __('Social Media Section','whiteboard64'),
        'description' => __('Customize Social Section in Homepage. Make sure that you have filled all the social links, blank field will not be displayed in site and it will be hidden by default.', 'whiteboard64'),
        'panel' => 'theme_option'
    ));

    $wp_customize->add_setting(
        'facebook_link',
            array(
            'sanitize_callback' => 'esc_url_raw',
            'capability' => 'edit_theme_options',
            'default' => '',
    ));
    $wp_customize->add_control(
        'facebook_link',
            array(
            'label' => __('Facebook link URL', 'whiteboard64'),
            'section' => 'whiteboard64_social_section',
            'settings' => 'facebook_link',
            'type' => 'url',
    ));

    $wp_customize->add_setting(
        'twitter_link',
            array(
            'sanitize_callback' => 'esc_url_raw',
            'capability' => 'edit_theme_options',
            'default' => '',
    ));
    $wp_customize->add_control(
        'twitter_link',
            array(
            'label' => __('Twitter link URL', 'whiteboard64'),
            'section' => 'whiteboard64_social_section',
            'settings' => 'twitter_link',
            'type' => 'url',
    ));

    $wp_customize->add_setting(
        'googleplus_link',
            array(
            'sanitize_callback' => 'esc_url_raw',
            'capability' => 'edit_theme_options',
            'default' => '',
    ));
    $wp_customize->add_control(
        'googleplus_link',
            array(
            'label' => __('Googleplus link URL', 'whiteboard64'),
            'section' => 'whiteboard64_social_section',
            'settings' => 'googleplus_link',
            'type' => 'url',
    ));

    $wp_customize->add_setting(
        'linkedin_link',
            array(
            'sanitize_callback' => 'esc_url_raw',
            'capability' => 'edit_theme_options',
            'default' => '',
    ));
    $wp_customize->add_control(
        'linkedin_link',
            array(
            'label' => __('LinkedIn link URL', 'whiteboard64'),
            'section' => 'whiteboard64_social_section',
            'settings' => 'linkedin_link',
            'type' => 'url',
    ));

    $wp_customize->add_setting(
        'youtube_link',
            array(
            'sanitize_callback' => 'esc_url_raw',
            'capability' => 'edit_theme_options',
            'default' => '',
    ));      
    $wp_customize->add_control(
        'youtube_link',
            array(
            'label' => __('You Tube link URL', 'whiteboard64'),
            'section' => 'whiteboard64_social_section',
            'settings' => 'youtube_link',
            'type' => 'url',
    )); 



    /**********************************************/
    /****** HOMEPAGE SLIDER CATEGORY SECTION ******/
    /**********************************************/

    $wp_customize->add_section('whiteboard64_slider_section',array(
        'priority' => 2,
        'title' => __('Slider Section','whiteboard64'),
        'description' => __('Customize Slider Section in Homepage. Make sure that slider images must be minimum of 1400px width and 650px height. The maximum no. of slides is 5.','whiteboard64'),
        'panel' => 'theme_option'
    ));

    $wp_customize->add_setting('slider_category_display',array(
        'sanitize_callback' => 'whiteboard64_sanitize_category',
        'default' => ''
    ));

    $wp_customize->add_control(new whiteboard64_Category_Dropdown_Custom_Control($wp_customize,'slider_category_display',array(
        'label' => __('Choose slider category to display in homepage','whiteboard64'),
        'section' => 'whiteboard64_slider_section',
        'settings' => 'slider_category_display',
        'type'=> 'dropdown-taxonomies',
        )  
    ));



    /**********************************************/
    /****** HOMEPAGE TABBED NEWS CATEGORY SECTION ******/
    /**********************************************/

    $wp_customize->add_section('whiteboard64_tabbed_section',array(
        'priority' => 3,
        'title' => __('Tabbed News / Blog Section','whiteboard64'),
        'description' => __('Customize News / Blog Section in Homepage. The maximum no. of tabs is 5.','whiteboard64'),
        'panel' => 'theme_option'
    ));

    $wp_customize->add_setting('news1_category_display',array(
        'sanitize_callback' => 'whiteboard64_sanitize_category',
        'default' => ''
    ));

    $wp_customize->add_control(new whiteboard64_Category_Dropdown_Custom_Control($wp_customize,'news1_category_display',array(
        'label' => __('Choose 1st news / blog category to display in homepage','whiteboard64'),
        'section' => 'whiteboard64_tabbed_section',
        'settings' => 'news1_category_display',
        'type'=> 'dropdown-taxonomies',
        )  
    ));
    $wp_customize->add_setting('category1_no',array(
        'sanitize_callback' => 'whiteboard64_sanitize_text',
        'capability' => 'edit_theme_options',
        'default' => ''
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize,'category1_no',array(
          'label' => __('No of News Posts in 1st Category to display','whiteboard64'),
          'section' => 'whiteboard64_tabbed_section',
          'settings' => 'category1_no',
          'type'=> 'text',
          ))
    );


    $wp_customize->add_setting('news2_category_display',array(
        'sanitize_callback' => 'whiteboard64_sanitize_category',
        'default' => ''
    ));

    $wp_customize->add_control(new whiteboard64_Category_Dropdown_Custom_Control($wp_customize,'news2_category_display',array(
        'label' => __('Choose 2nd news / blog category to display in homepage','whiteboard64'),
        'section' => 'whiteboard64_tabbed_section',
        'settings' => 'news2_category_display',
        'type'=> 'dropdown-taxonomies',
        )  
    ));
    $wp_customize->add_setting('category2_no',array(
        'sanitize_callback' => 'whiteboard64_sanitize_text',
        'capability' => 'edit_theme_options',
        'default' => ''
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize,'category2_no',array(
          'label' => __('No of News Posts in 2nd Category to display','whiteboard64'),
          'section' => 'whiteboard64_tabbed_section',
          'settings' => 'category2_no',
          'type'=> 'text',
          ))
    );


    $wp_customize->add_setting('news3_category_display',array(
        'sanitize_callback' => 'whiteboard64_sanitize_category',
        'default' => ''
    ));

    $wp_customize->add_control(new whiteboard64_Category_Dropdown_Custom_Control($wp_customize,'news3_category_display',array(
        'label' => __('Choose 3rd news / blog category to display in homepage','whiteboard64'),
        'section' => 'whiteboard64_tabbed_section',
        'settings' => 'news3_category_display',
        'type'=> 'dropdown-taxonomies',
        )  
    ));
    $wp_customize->add_setting('category3_no',array(
        'sanitize_callback' => 'whiteboard64_sanitize_text',
        'capability' => 'edit_theme_options',
        'default' => ''
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize,'category3_no',array(
          'label' => __('No of News Posts in 3rd Category to display','whiteboard64'),
          'section' => 'whiteboard64_tabbed_section',
          'settings' => 'category3_no',
          'type'=> 'text',
          ))
    );


    $wp_customize->add_setting('news4_category_display',array(
        'sanitize_callback' => 'whiteboard64_sanitize_category',
        'default' => ''
    ));

    $wp_customize->add_control(new whiteboard64_Category_Dropdown_Custom_Control($wp_customize,'news4_category_display',array(
        'label' => __('Choose 4th news / blog category to display in homepage','whiteboard64'),
        'section' => 'whiteboard64_tabbed_section',
        'settings' => 'news4_category_display',
        'type'=> 'dropdown-taxonomies',
        )  
    ));
    $wp_customize->add_setting('category4_no',array(
        'sanitize_callback' => 'whiteboard64_sanitize_text',
        'capability' => 'edit_theme_options',
        'default' => ''
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize,'category4_no',array(
          'label' => __('No of News Posts in 4th Category to display','whiteboard64'),
          'section' => 'whiteboard64_tabbed_section',
          'settings' => 'category4_no',
          'type'=> 'text',
          ))
    );


    $wp_customize->add_setting('news5_category_display',array(
        'sanitize_callback' => 'whiteboard64_sanitize_category',
        'default' => ''
    ));

    $wp_customize->add_control(new whiteboard64_Category_Dropdown_Custom_Control($wp_customize,'news5_category_display',array(
        'label' => __('Choose 5th news / blog category to display in homepage','whiteboard64'),
        'section' => 'whiteboard64_tabbed_section',
        'settings' => 'news5_category_display',
        'type'=> 'dropdown-taxonomies',
        )  
    ));
    $wp_customize->add_setting('category5_no',array(
        'sanitize_callback' => 'whiteboard64_sanitize_text',
        'capability' => 'edit_theme_options',
        'default' => ''
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize,'category5_no',array(
          'label' => __('No of News Posts in 5th Category to display','whiteboard64'),
          'section' => 'whiteboard64_tabbed_section',
          'settings' => 'category5_no',
          'type'=> 'text',
          ))
    );

}
add_action( 'customize_register', 'whiteboard64_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function whiteboard64_customize_preview_js() {
	wp_enqueue_script( 'whiteboard64_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20170105', true );
}
add_action( 'customize_preview_init', 'whiteboard64_customize_preview_js' );



function whiteboard64_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

function whiteboard64_sanitize_category($input){
  $output=intval($input);
  return $output;
}