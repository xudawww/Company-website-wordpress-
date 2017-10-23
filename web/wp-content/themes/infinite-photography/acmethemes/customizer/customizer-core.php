<?php
/**
 * Header logo/text display options alternative
 *
 * @since infinite-photography 1.0.2
 *
 * @param null
 * @return array $infinite_photography_header_id_display_opt
 *
 */
if ( !function_exists('infinite_photography_header_id_display_opt') ) :
    function infinite_photography_header_id_display_opt() {
        $infinite_photography_header_id_display_opt =  array(
            'logo-only'         => __( 'Logo Only ( First Select Logo Above )', 'infinite-photography' ),
            'title-only'        => __( 'Site Title Only', 'infinite-photography' ),
            'title-and-tagline' =>  __( 'Site Title and Tagline', 'infinite-photography' ),
            'disable'           => __( 'Disable', 'infinite-photography' )
        );
        return apply_filters( 'infinite_photography_header_id_display_opt', $infinite_photography_header_id_display_opt );
    }
endif;

/**
 * Sidebar layout options
 *
 * @since infinite-photography 1.0.0
 *
 * @param null
 * @return array $infinite_photography_sidebar_layout
 *
 */
if ( !function_exists('infinite_photography_sidebar_layout') ) :
    function infinite_photography_sidebar_layout() {
        $infinite_photography_sidebar_layout =  array(
            'right-sidebar' => __( 'Right Sidebar', 'infinite-photography' ),
            'left-sidebar'  => __( 'Left Sidebar' , 'infinite-photography' ),
            'no-sidebar'    => __( 'No Sidebar', 'infinite-photography' )
        );
        return apply_filters( 'infinite_photography_sidebar_layout', $infinite_photography_sidebar_layout );
    }
endif;


/**
 * Blog layout options
 *
 * @since infinite-photography 1.0.0
 *
 * @param null
 * @return array $infinite_photography_blog_layout
 *
 */
if ( !function_exists('infinite_photography_blog_layout') ) :
    function infinite_photography_blog_layout() {
        $infinite_photography_blog_layout =  array(
            'photography' => __( 'Photography', 'infinite-photography' ),
            'normal'   => __( 'Normal', 'infinite-photography' )
        );
        return apply_filters( 'infinite_photography_blog_layout', $infinite_photography_blog_layout );
    }
endif;

/**
 * Related posts layout options
 *
 * @since infinite-photography 1.1.0
 *
 * @param null
 * @return array
 *
 */
if ( !function_exists('infinite_photography_reset_options') ) :
    function infinite_photography_reset_options() {
        $infinite_photography_reset_options =  array(
            '0'                    => __( 'Do Not Reset', 'infinite-photography' ),
            'reset-color-options'  => __( 'Reset Colors Options', 'infinite-photography' ),
            'reset-all'            => __( 'Reset All', 'infinite-photography' )
        );
        return apply_filters( 'infinite_photography_reset_options', $infinite_photography_reset_options );
    }
endif;

/**
 * Related Post Display From Options
 *
 * @since SuperMag 1.5.0
 *
 * @param null
 * @return array
 *
 */
if ( !function_exists('infinite_photography_related_post_display_from') ) :
	function infinite_photography_related_post_display_from() {
		$infinite_photography_related_post_display_from =  array(
			'cat'  => __( 'Related Posts From Categories', 'infinite-photography' ),
			'tag'  => __( 'Related Posts From Tags', 'infinite-photography' )
		);
		return apply_filters( 'infinite_photography_related_post_display_from', $infinite_photography_related_post_display_from );
	}
endif;

/**
 * Blog layout options
 *
 * @since SuperMag 1.5.0
 *
 * @param null
 * @return array $infinite_photography_get_image_sizes_options
 *
 */
if ( !function_exists('infinite_photography_get_image_sizes_options') ) :
	function infinite_photography_get_image_sizes_options( $add_disable = false ) {
		global $_wp_additional_image_sizes;
		$choices = array();
		if ( true == $add_disable ) {
			$choices['disable'] = __( 'No Image', 'infinite-photography' );
		}
		foreach ( array( 'thumbnail', 'medium', 'large' ) as $key => $_size ) {
			$choices[ $_size ] = $_size . ' ('. get_option( $_size . '_size_w' ) . 'x' . get_option( $_size . '_size_h' ) . ')';
		}
		$choices['full'] = __( 'full (original)', 'infinite-photography' );
		if ( ! empty( $_wp_additional_image_sizes ) && is_array( $_wp_additional_image_sizes ) ) {

			foreach ($_wp_additional_image_sizes as $key => $size ) {
				$choices[ $key ] = $key . ' ('. $size['width'] . 'x' . $size['height'] . ')';
			}

		}
		return apply_filters( 'infinite_photography_get_image_sizes_options', $choices );
	}
endif;

/**
 *  Default Theme layout options
 *
 * @since infinite-photography 1.0.0
 *
 * @param null
 * @return array $infinite_photography_theme_layout
 *
 */
if ( !function_exists('infinite_photography_get_default_theme_options') ) :
    function infinite_photography_get_default_theme_options() {

        $default_theme_options = array(
            /*feature section options*/
            'infinite-photography-enable-feature'       => '',
            'infinite-photography-feature-text'       => __( 'Infinite Photography', 'infinite-photography' ),

            /*header options*/
            'infinite-photography-header-logo'          => '',
            'infinite-photography-header-id-display-opt'=> 'title-and-tagline',
            'infinite-photography-facebook-url'         => '',
            'infinite-photography-twitter-url'          => '',
            'infinite-photography-youtube-url'          => '',
            'infinite-photography-instagram-url'        => '',
            'infinite-photography-google-plus-url'      => '',
            'infinite-photography-pinterest-url'        => '',
            'infinite-photography-enable-social'        => '',
            'infinite-photography-show-search'          => 1,

	        /*footer options*/
            'infinite-photography-footer-copyright'     => __( 'All Right Reserved &copy; 2016', 'infinite-photography' ),

            /*layout/design options*/
            'infinite-photography-sidebar-layout'       => 'right-sidebar',
            'infinite-photography-front-page-sidebar-layout'  => 'no-sidebar',
            'infinite-photography-archive-sidebar-layout'  => 'right-sidebar',

            'infinite-photography-header-height'  => '180',

            'infinite-photography-blog-archive-image-size'  => 'post-thumbnail',
            'infinite-photography-blog-archive-click-image-size'  => 'full',

            'infinite-photography-blog-archive-layout'  => 'photography',
            'infinite-photography-primary-color'        => '#04BB9C',
            'infinite-photography-custom-css'           => '',

	        /*single related post options*/
            'infinite-photography-show-related'  => 1,
            'infinite-photography-related-title'  => __( 'Related posts', 'infinite-photography' ),
            'infinite-photography-related-post-display-from'  => 'cat',
            'infinite-photography-single-image-size'  => 'full',

	        /*theme options*/
            'infinite-photography-search-placeholder'    => __( 'Search', 'infinite-photography' ),
            'infinite-photography-show-breadcrumb'      => '',

            /*Reset*/
            'infinite-photography-reset-options'        => '0'

        );

        return apply_filters( 'infinite_photography_default_theme_options', $default_theme_options );
    }
endif;


/**
 *  Get theme options
 *
 * @since infinite-photography 1.0.0
 *
 * @param null
 * @return array infinite_photography_theme_options
 *
 */
if ( !function_exists('infinite_photography_get_theme_options') ) :

    function infinite_photography_get_theme_options() {
        $infinite_photography_default_theme_options = infinite_photography_get_default_theme_options();
        $infinite_photography_get_theme_options = get_theme_mod( 'infinite_photography_theme_options');
        if( is_array( $infinite_photography_get_theme_options ) ){
            return array_merge( $infinite_photography_default_theme_options ,$infinite_photography_get_theme_options );
        }
        else{
            return $infinite_photography_default_theme_options;
        }

    }
endif;