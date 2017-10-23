<?php
/**
 * The main template file.
 *
 * @package Ion
 */

get_header(); ?>

<div class="content">

	<?php if ( have_posts() ) : ?>
	
		<?php if( apptheme_get_list_type() ) : ?>
			
			<?php apptheme_get_slider(); ?>
			
		    <ul id="app-post-list" class="list list-full">
			
				<?php while ( have_posts() ) : the_post(); ?>
				
					<?php get_template_part( 'content', apptheme_get_list_type() ); ?>
				
				<?php endwhile; ?>

				<?php // appp_content_nav( 'nav-below' ); ?>
	
		    </ul>
				
		<?php endif; ?>

		
		
	<?php endif; ?>

</div><!-- .content -->

<?php get_footer(); ?>