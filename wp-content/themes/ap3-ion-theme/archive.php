<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ion
 */

get_header(); ?>

<div id="content" class="site-content" role="main">

	<?php if ( have_posts() ) : ?>
		
		<ul class="list">
			
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php get_template_part( 'content', apptheme_get_list_type() ); ?>
			
			<?php endwhile; ?>
	
		</ul>

	<?php appp_content_nav( 'nav-below' ); ?>

<?php else : ?>

	<?php get_template_part( 'no-results', 'archive' ); ?>

<?php endif; ?>

</div><!-- #content -->

<?php get_footer(); ?>