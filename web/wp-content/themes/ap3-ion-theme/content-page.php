<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Ion
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content padding">
		<?php the_content(); ?>
		
		<?php edit_post_link( __( 'Edit', 'ap3-ion-theme' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
	</div><!-- .entry-content -->

	<?php get_template_part( 'content', 'below_page' ); ?>

</article><!-- #post-## -->
