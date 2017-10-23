<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @since MeisterMag 1.0
 */
?>


<?php if ( is_single() ) { ?>
	<div class="tagdiv-post-template">
<?php } else {  ?>
	<div class="tagdiv-module-wrap">
<?php } ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( is_single() ) { ?>
		<?php tagdiv_post_header(); // Post header. ?>
		<?php tagdiv_post_thumbnail(); // Post thumbnail. ?>
		<?php } else { ?>
		<?php tagdiv_post_thumbnail(); // Post thumbnail. ?>
		<?php tagdiv_post_header(); // Post header. ?>
	<?php } ?>

		<?php if ( is_single() ) { ?>
			<div class="tagdiv-post-content">
				<?php the_content(); ?>
			</div> <!-- /.tagdiv-post-content -->

			<footer class="tagdiv-post-footer">
				<?php
				wp_link_pages( array(
					'before' 	  => '<div class="page-nav">',
					'after' 	  => '</div>',
					'link_before' => '<div>',
					'link_after'  => '</div>',
					'separator'   => '<span class="screen-reader-text">, </span>',
					'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'meistermag' ) . ' </span>%',
				) );
				?>
				<div class="tagdiv-post-tags">
					<?php echo tagdiv_post_tags(); ?>
				</div>
			<?php echo tagdiv_next_prev_posts(); ?>
			<?php echo tagdiv_author_box(); ?>
			</footer> <!-- /.tagdiv-post-footer -->
		<?php } else { ?>
				<?php tagdiv_excerpt(); ?>
		<?php } ?>


</article><!-- #post-## -->
</div> <!-- .tagdiv-module /.tagdiv-post-template -->