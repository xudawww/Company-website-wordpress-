<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Whiteboard64
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="col-xs-12 col-sm-12 listings wow fadeInUp" data-wow-duration="2s">
		<!-- Add Banner -->
		<?php if ( is_active_sidebar( 'innerpage-ad-block' ) ) : ?>
			<?php dynamic_sidebar( 'innerpage-ad-block' ); ?>
		<?php endif; ?>


		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			}

			if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php whiteboard64_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php
			endif; 
		?>

		<div class="entry-content">
	  		<?php if (has_post_thumbnail()) : ?>
	  			<div class="featured-image">
	  				<div class="image">
	    				<?php the_post_thumbnail('full'); ?>
	    			</div>
	    		</div>
	  		<?php endif; ?>
 			
 			<?php
				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'whiteboard64' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<?php if ( get_edit_post_link() ) : ?>
			<footer class="entry-footer">
				<?php
					edit_post_link(
						sprintf(
							/* translators: %s: Name of current post */
							esc_html__( 'Edit %s', 'whiteboard64' ),
							the_title( '<span class="screen-reader-text">"', '"</span>', false )
						),
						'<span class="edit-link">',
						'</span>'
					);
				?>
			</footer><!-- .entry-footer -->
		<?php endif; ?>
	</div>
</article><!-- #post-## -->