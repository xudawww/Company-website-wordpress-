<?php
/**
 * The template for displaying custom query lists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ion
 */

get_header(); ?>

<div id="content" class="site-content app-list" role="main">

	<?php $custom_query = apppresser_custom_query(); ?>

	<?php if ( $custom_query['query']->have_posts() ) : ?>
		
		<ul id="app-post-list" class="<?php echo $custom_query['list_type']; ?>">
			
			<?php while ( $custom_query['query']->have_posts() ) : $custom_query['query']->the_post(); ?>
			
				<?php get_template_part( 'content', isset( $custom_query['list_type'] ) ? $custom_query['list_type'] : 'medialist' ); ?>
			
			<?php endwhile; ?>
	
		</ul>

<?php else : ?>

	<?php get_template_part( 'no-results', 'archive' ); ?>

<?php endif; ?>

</div><!-- #content -->

<?php get_footer(); ?>