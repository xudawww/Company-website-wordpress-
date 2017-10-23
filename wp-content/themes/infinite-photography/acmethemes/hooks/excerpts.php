<?php
/**
 * Excerpt length 90 return
 *
 * @since infinite-photography 1.1.0
 *
 * @param null
 * @return null
 *
 */
if ( !function_exists('infinite_photography_alter_excerpt') ) :
    function infinite_photography_alter_excerpt( $length ){
		if( is_admin() ){
			return $length;
		}
        return 90;
    }
endif;

add_filter('excerpt_length', 'infinite_photography_alter_excerpt');

/**
 * Add ... for more view
 *
 * @since infinite-photography 1.1.0
 *
 * @param null
 * @return null
 *
 */

if ( !function_exists('infinite_photography_excerpt_more') ) :
    function infinite_photography_excerpt_more($more) {
		if( is_admin() ){
			return $more;
		}
        return '&hellip;';
    }
endif;
add_filter('excerpt_more', 'infinite_photography_excerpt_more');