<?php
/*adding header options panel*/
$wp_customize->add_panel( 'infinite-photography-header-panel', array(
    'priority'       => 30,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Header Options', 'infinite-photography' ),
    'description'    => __( 'Customize your awesome site header ', 'infinite-photography' )
) );

/*
* file for header logo options
*/
$infinite_photography_customizer_header_logo_file_path = infinite_photography_file_directory('acmethemes/customizer/header-options/header-logo.php');
require $infinite_photography_customizer_header_logo_file_path;

require_once infinite_photography_file_directory('acmethemes/customizer/header-options/search-option.php');




