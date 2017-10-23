<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Acme Themes
 * @subpackage Infinite Photography
 */

/**
 * infinite_photography_action_before_head hook
 * @since infinite-photography 1.0.0
 *
 * @hooked infinite_photography_set_global -  0
 * @hooked infinite_photography_doctype -  10
 */
do_action( 'infinite_photography_action_before_head' );?>
	<head>

		<?php
		/**
		 * infinite_photography_action_before_wp_head hook
		 * @since infinite-photography 1.0.0
		 *
		 * @hooked infinite_photography_before_wp_head -  10
		 */
		do_action( 'infinite_photography_action_before_wp_head' );

		wp_head();
		?>
	</head>
<body <?php body_class();?>>

<?php
/**
 * infinite_photography_action_before hook
 * @since infinite-photography 1.0.0
 *
 * @hooked infinite_photography_page_start - 10
 * @hooked infinite_photography_page_start - 15
 */
do_action( 'infinite_photography_action_before' );

/**
 * infinite_photography_action_before_header hook
 * @since infinite-photography 1.0.0
 *
 * @hooked infinite_photography_skip_to_content - 10
 */
do_action( 'infinite_photography_action_before_header' );


/**
 * infinite_photography_action_header hook
 * @since infinite-photography 1.0.0
 *
 * @hooked infinite_photography_after_header - 10
 */
do_action( 'infinite_photography_action_header' );


/**
 * infinite_photography_action_after_header hook
 * @since infinite-photography 1.0.0
 *
 * @hooked null
 */
do_action( 'infinite_photography_action_after_header' );


/**
 * infinite_photography_action_before_content hook
 * @since infinite-photography 1.0.0
 *
 * @hooked infinite_photography_before_content - 10
 */
do_action( 'infinite_photography_action_before_content' );
