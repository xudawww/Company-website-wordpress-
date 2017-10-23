<?php
/**
 * The template for displaying archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
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

					<?php if ( have_posts() ) { ?>

						<header class="tagdiv-page-header">
							<?php
							the_archive_title( '<h1 class="tagdiv-entry-title tagdiv-page-title">', '</h1>' );
							the_archive_description( '<div class="tagdiv-category-description">', '</div>' );
							?>
						</header><!-- .tagdiv-page-header -->

						<div class="tagdiv-modules-container">
							<?php

							$tagdiv_current_column = 1;
							$row_is_open = false;

							// Start the Loop.
							while ( have_posts() ) : the_post();

								if ( false === $row_is_open ) {
									$row_is_open = true;
									echo '<div class="tagdiv-row">'; // open a grid row
								} ?>

								<div class="tagdiv-span6">
									<?php get_template_part( 'template-parts/content', get_post_format() ); ?>
								</div>

								<?php if ( 2 == $tagdiv_current_column and true === $row_is_open ) {
									$row_is_open = false;
									echo '</div>'; // close the grid row
								}

								if ( 2 == $tagdiv_current_column ) {
									$tagdiv_current_column = 1;
								} else {
									$tagdiv_current_column++;
								}

							endwhile; //End of the Loop

							if ( true === $row_is_open ) {
								$row_is_open = false;
								echo '</div>'; // close the grid row
							} ?>

						</div>

						<div class="page-nav">

							<?php
							// Previous/next page navigation.
							the_posts_pagination( array(
								'prev_text'          => __( 'Previous page', 'meistermag' ),
								'next_text'          => __( 'Next page', 'meistermag' ),
								'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'meistermag' ) . ' </span>',
							) );
							?>

						</div>

					<?php
					// If no content, include the "No posts found" template.
					} else {
						get_template_part( 'template-parts/content', 'none' );
					}
					?>

				</div>

				<div class="tagdiv-span4 tagdiv-sidebar" role="complementary">
					<?php get_sidebar(); ?>
				</div>
			</div> <!-- /.tagdiv-row -->
		</div> <!-- /.tagdiv-container -->
	</div> <!-- /.tagdiv-main-content-wrap -->

<?php get_footer(); ?>

