<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Infinite Photography
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses infinite_photography_header_style()
 */
function infinite_photography_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'infinite_photography_custom_header_args', array(
		'default-image'          => '',
		'width'                  => 1920,
		'height'                 => 620,
		'flex-height'            => true
	) ) );
}
add_action( 'after_setup_theme', 'infinite_photography_custom_header_setup' );