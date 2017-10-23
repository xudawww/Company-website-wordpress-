<div id="author-bio">
<?php echo get_avatar( get_the_author_meta('ID'), 88 ); ?>
<h3><?php _e('About', 'digital'); ?> <?php the_author_posts_link(); ?></h3>    
	<?php the_author_meta('description'); ?>                        
</div>
