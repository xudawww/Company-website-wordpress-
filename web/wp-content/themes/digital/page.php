<?php get_header(); ?>
	<!-- BEGIN PAGE -->
	<div id="page">
    <div id="page-inner" class="clearfix">
		<div id="pagecont">
			<?php if(have_posts()) : ?><?php while(have_posts())  : the_post(); ?>
					<div id="pagepost-<?php the_ID(); ?>" class="clearfix">					
						<h1><?php the_title(); ?></h1>
						<div id="metad"><span class="postmeta_box">
		<?php get_template_part('/includes/postmeta'); ?><?php edit_post_link('Edit', ' &#124; ', ''); ?>
	</span></div>
							<div class="entry" class="clearfix">
																
								<?php the_content(); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'digital' ), 'after' => '</div>' ) ); ?>
							</div> <!-- end div .entry -->
							
			<div class="gap"></div><?php if (of_get_option('digital_author' ) =='1' ) {get_template_part('includes/author'); } ?>				
 <?php if (!dynamic_sidebar('belowpagecontent') ) : endif; ?>
									<div class="comments">
								<?php comments_template(); ?>
							</div> <!-- end div .comments -->
					</div> <!-- end div .post -->

			<?php endwhile; ?>
			<?php else : ?>
				<div class="post">
					<h3><?php esc_attr('404 Error&#58; Not Found', 'digital'); ?></h3>
				</div>
			<?php endif; ?>
			  <div id="footerads">
<?php if ( of_get_option('digital_ad1') <> "" ) { echo stripslashes(of_get_option('digital_ad1')); } ?>
</div>    										
		</div> <!-- end div #content -->
			
<?php get_sidebar(); ?>
<?php get_footer(); ?>
