<?php
/**
 * Main include functions ( to support child theme )
 *
 * @since infinite-photography 1.0.0
 *
 * @param string $file_path, path from the theme
 * @return string full path of file inside theme
 *
 */
if( !function_exists('infinite_photography_file_directory') ){

    function infinite_photography_file_directory( $file_path ){
        if( file_exists( trailingslashit( get_stylesheet_directory() ) . $file_path) ){
            return trailingslashit( get_stylesheet_directory() ) . $file_path;
        }
        else{
            return trailingslashit( get_template_directory() ) . $file_path;
        }
    }
}

/**
 * Check empty or null
 *
 * @since infinite-photography  1.0.0
 *
 * @param string $str, string
 * @return boolean
 *
 */
if( !function_exists('infinite_photography_is_null_or_empty') ){
	function infinite_photography_is_null_or_empty( $str ){
		return ( !isset($str) || trim($str)==='' );
	}
}

/*file for library*/
require_once infinite_photography_file_directory('acmethemes/library/tgm/class-tgm-plugin-activation.php');

/*
* file for customizer theme options
*/
$infinite_photography_customizer_file_path = infinite_photography_file_directory('acmethemes/customizer/customizer.php');
require $infinite_photography_customizer_file_path;


/*
* file for additional functions files
*/
$infinite_photography_functions_file_path = infinite_photography_file_directory('acmethemes/functions.php');
require $infinite_photography_functions_file_path;

/*
* files for hooks
*/
require_once infinite_photography_file_directory('acmethemes/hooks/tgm.php');

$infinite_photography_slider_selection_file_path = infinite_photography_file_directory('acmethemes/hooks/slider-selection.php');
require $infinite_photography_slider_selection_file_path;

$infinite_photography_hooks_header_file_path = infinite_photography_file_directory('acmethemes/hooks/header.php');
require $infinite_photography_hooks_header_file_path;

$infinite_photography_hooks_dynamic_css_file_path = infinite_photography_file_directory('acmethemes/hooks/dynamic-css.php');
require $infinite_photography_hooks_dynamic_css_file_path;

$infinite_photography_hooks_footer_file_path = infinite_photography_file_directory('acmethemes/hooks/footer.php');
require $infinite_photography_hooks_footer_file_path;

$infinite_photography_social_links_file_path = infinite_photography_file_directory('acmethemes/hooks/social-links.php');
require $infinite_photography_social_links_file_path;

$infinite_photography_comment_form_file_path = infinite_photography_file_directory('acmethemes/hooks/comment-forms.php');
require $infinite_photography_comment_form_file_path;

$infinite_photography_excerpts_form_file_path = infinite_photography_file_directory('acmethemes/hooks/excerpts.php');
require $infinite_photography_excerpts_form_file_path;

$infinite_photography_photography_file_path = infinite_photography_file_directory('acmethemes/hooks/photography.php');
require $infinite_photography_photography_file_path;

require_once infinite_photography_file_directory('acmethemes/hooks/related-posts.php');

require_once infinite_photography_file_directory('acmethemes/hooks/acme-demo-setup.php');



/*
* file for sidebar and widgets
*/
$infinite_photography_acme_author_widget = infinite_photography_file_directory('acmethemes/sidebar-widget/author-widget.php');
require $infinite_photography_acme_author_widget;

$infinite_photography_sidebar = infinite_photography_file_directory('acmethemes/sidebar-widget/sidebar.php');
require $infinite_photography_sidebar;

/*
* file for core functions imported from functions.php while downloading Underscores
*/
$infinite_photography_sidebar = infinite_photography_file_directory('acmethemes/core.php');
require $infinite_photography_sidebar;

/**
 * Implement Custom Metaboxes
 */
require_once infinite_photography_file_directory('acmethemes/metabox/metabox.php');

/*themes info*/
require_once infinite_photography_file_directory('acmethemes/at-theme-info/class-at-theme-info.php');