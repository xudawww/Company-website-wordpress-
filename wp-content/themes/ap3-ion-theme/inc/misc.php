<?php

/**
 * apptheme_get_list_type function.
 * 
 * @access public
 * @return void
 */
function apptheme_get_list_type() {

	if( get_theme_mod( 'list_control' ) ) {
	
		// if( 'default' === get_theme_mod( 'list_control' ) ) return false;
	
		return get_theme_mod( 'list_control', 'medialist' );
	}
	
	return 'medialist';

}

/**
 * apptheme_get_slider function.
 * 
 * @access public
 * @return void
 */
function apptheme_get_slider() {
	
	if( !class_exists('AppPresser_Swipers')  ) return;
		
	if( get_theme_mod( 'slider_control') != '' ) {
		$category = get_theme_mod( 'slider_category_control', '' );

		if( $category ) {
			echo do_shortcode( '[swiper category="'.$category.'"]' );
		} else {
			echo do_shortcode( '[swiper]' );
		}
	}
	
}


/**
 * apptheme_excerpt_length function.
 * 
 * @access public
 * @param mixed $length
 * @return void
 */
function apptheme_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'apptheme_excerpt_length', 999 );