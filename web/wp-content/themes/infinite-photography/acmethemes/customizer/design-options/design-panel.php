<?php
/*adding theme options panel*/
$wp_customize->add_panel( 'infinite-photography-design-panel', array(
    'priority'       => 90,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
    'title'          => __( 'Layout/Design Option', 'infinite-photography' )
) );

/*
* file for sidebar layout
*/
$infinite_photography_customizer_sidebar_layout_file_path = infinite_photography_file_directory('acmethemes/customizer/design-options/sidebar-layout.php');
require $infinite_photography_customizer_sidebar_layout_file_path;

/*
* file for front page sidebar layout options
*/
$infinite_photography_customizer_front_page_sidebar_layout_file_path = infinite_photography_file_directory('acmethemes/customizer/design-options/front-page-sidebar-layout.php');
require $infinite_photography_customizer_front_page_sidebar_layout_file_path;

/*
* file for front archive sidebar layout options
*/
require infinite_photography_file_directory('acmethemes/customizer/design-options/archive-sidebar-layout.php');
/*
* file for blog layout
*/
$infinite_photography_customizer_blog_layout_file_path = infinite_photography_file_directory('acmethemes/customizer/design-options/blog-layout.php');
require $infinite_photography_customizer_blog_layout_file_path;

/*
* file for color options
*/
$infinite_photography_customizer_colors_options_file_path = infinite_photography_file_directory('acmethemes/customizer/design-options/colors-options.php');
require $infinite_photography_customizer_colors_options_file_path;

/*
* file for background image layout
*/
$infinite_photography_customizer_background_image_file_path = infinite_photography_file_directory('acmethemes/customizer/design-options/background-image.php');
require $infinite_photography_customizer_background_image_file_path;

/*
* file for custom css
*/
$infinite_photography_customizer_custom_css_file_path = infinite_photography_file_directory('acmethemes/customizer/design-options/custom-css.php');
require $infinite_photography_customizer_custom_css_file_path;
