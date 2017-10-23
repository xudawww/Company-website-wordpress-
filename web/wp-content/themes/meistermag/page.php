<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @since MeisterMag 1.0
 */

get_header(); ?>

	<div class="tagdiv-main-content-wrap">
		<div class="tagdiv-container">
			<div class="tagdiv-row">
				<div class="tagdiv-span8" role="main">

					<?php if ( have_posts() ) {

						while ( have_posts() ) : the_post(); // Start the loop.

							// Include the page content template.
							get_template_part( 'template-parts/content', 'page' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}

						endwhile; // End of the loop.

					} else {
						get_template_part( 'template-parts/content', 'none' );
					} ?>

				</div>

				<div class="tagdiv-span4 tagdiv-sidebar" role="complementary">
					<?php get_sidebar(); ?>
				</div>
			</div> <!-- /.tagdiv-row -->
		</div> <!-- /.tagdiv-container -->
	</div> <!-- /.tagdiv-main-content-wrap -->

<?php
get_footer();
