<?php
/*adding theme options panel*/
$wp_customize->add_panel( 'infinite-photography-options', array(
    'priority'       => 210,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Theme Options', 'infinite-photography' ),
    'description'    => __( 'Customize your awesome site with theme options ', 'infinite-photography' )
) );

/*
* file for header breadcrumb options
*/
$infinite_photography_customizer_options_breadcrumb_file_path = infinite_photography_file_directory('acmethemes/customizer/options/breadcrumb.php');
require $infinite_photography_customizer_options_breadcrumb_file_path;

/*
* file for header search options
*/
$infinite_photography_customizer_options_search_file_path = infinite_photography_file_directory('acmethemes/customizer/options/search.php');
require $infinite_photography_customizer_options_search_file_path;