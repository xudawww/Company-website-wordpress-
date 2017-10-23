<?php get_header(); ?>
	<!-- BEGIN PAGE -->
	<div id="page">
	   <div id="page-inner" class="clearfix">
	<div id="content">
			<?php digital_breadcrumbs(); ?>
			<?php if (have_posts()) : ?>
			
			<?php while(have_posts())  : the_post(); ?>
<div class="imag"><?php get_template_part('/includes/post'); ?>	</div>
			<?php endwhile; ?>
			<?php else : ?>
				<div class="post">
					<div class="posttitle">
						<h2><?php esc_attr('404 Error&#58; Not Found', 'digital'); ?></h2>
						<span class="posttime"></span>
					</div>
				</div>
			<?php endif; ?>
			
				<?php get_template_part('includes/pagenav'); ?>
	      										
		</div> <!-- end div #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
