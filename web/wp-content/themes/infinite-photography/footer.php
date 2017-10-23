<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Acme Themes
 * @subpackage Infinite Photography
 */

/**
 * infinite_photography_action_after_content hook
 * @since infinite-photography 1.0.0
 *
 * @hooked infinite_photography_after_content - 10
 */
do_action( 'infinite_photography_action_after_content' );

/**
 * infinite_photography_action_before_footer hook
 * @since infinite-photography 1.0.0
 *
 * @hooked null
 */
do_action( 'infinite_photography_action_before_footer' );

/**
 * infinite_photography_action_footer hook
 * @since infinite-photography 1.0.0
 *
 * @hooked infinite_photography_footer - 10
 */
do_action( 'infinite_photography_action_footer' );

/**
 * infinite_photography_action_after_footer hook
 * @since infinite-photography 1.0.0
 *
 * @hooked null
 */
do_action( 'infinite_photography_action_after_footer' );

/**
 * infinite_photography_action_after hook
 * @since infinite-photography 1.0.0
 *
 * @hooked infinite_photography_page_end - 10
 */
do_action( 'infinite_photography_action_after' );
wp_footer();
?>
</body>
</html>