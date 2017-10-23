<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @since MeisterMag 1.0
 */

get_header(); ?>

	<div class="tagdiv-main-content-wrap">
		<div class="tagdiv-container">
			<div class="tagdiv-row">
				<div class="tagdiv-span8" role="main">

					<?php
						// Start the Loop
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/content', get_post_format() );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}

						endwhile; // //End of the Loop
				 	?>

				</div>

				<div class="tagdiv-span4 tagdiv-sidebar" role="complementary">
					<?php get_sidebar(); ?>
				</div>
			</div> <!-- /.tagdiv-row -->
		</div> <!-- /.tagdiv-container -->
	</div> <!-- /.tagdiv-main-content-wrap -->

<?php get_footer(); ?>
