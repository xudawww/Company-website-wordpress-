<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Ion
 */

get_header(); ?>

<div id="content" class="site-content page-not-found 404" role="main">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content padding">

		<h2>Page Not Found</h2>

		<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'ap3-ion-theme' ); ?></p>

		<?php get_search_form(); ?>

		<?php
		/* translators: %1$s: smiley */
		$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'ap3-ion-theme' ), convert_smilies( ':)' ) ) . '</p>';
		the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
		?>

	</div>

	</article>
	
</div><!-- #content -->

<?php get_footer(); ?>