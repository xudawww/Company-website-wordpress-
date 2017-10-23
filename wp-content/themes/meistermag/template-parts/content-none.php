<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @since MeisterMag 1.0
 */
?>

<header class="tagdiv-page-header">
	<h1 class="tagdiv-page-title"><?php esc_html_e( 'Nothing Found', 'meistermag' ); ?></h1>
</header><!-- /.tagdiv-page-header -->

<div class="tagdiv-page-content">

	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) { ?>

		<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'meistermag' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

	<?php } elseif ( is_search() ) { ?>

		<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'meistermag' ); ?></p>

	<?php } elseif ( is_category() ) { ?>

		<p><?php esc_html_e( 'Sorry, but the chosen category dose not contain any posts to display. Perhaps searching can help.', 'meistermag' ); ?></p>
		<?php get_search_form(); ?>

	<?php } else { ?>

		<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'meistermag' ); ?></p>
		<?php get_search_form(); ?>

	<?php } ?>

</div><!-- /.tagdiv-page-content -->
