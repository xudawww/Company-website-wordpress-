<?php get_header(); ?>
<div id="page">
		<div id="page-inner" class="clearfix">	
		<div id="singlecontent"><?php digital_breadcrumbs(); ?>
			<?php if(have_posts()) : ?>
			<?php while(have_posts())  : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<h1><?php the_title(); ?></h1>
<div id="metad"><span class="postmeta_box">
		<?php get_template_part('/includes/postmeta'); ?><?php edit_post_link('Edit', ' &#124; ', ''); ?>
	</span></div>		<div class="entry clearfix">
			<div class="entry-content"><?php the_content(); ?></div> 
			<div class="gap"></div><?php if ( of_get_option('digital_tags' ) =='1') { ?>	<?php  if (get_the_tags()) :?> <span class="tags"><?php if("the_tags")	$before = '';
$seperator = ''; // blank instead of comma
$after = ''; the_tags("",$before, $seperator, $after ); 
			
		?></span><?php endif;?><?php } ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'digital' ), 'after' => '</div>' ) ); ?></div> 		
<div class="gap"></div><?php if (of_get_option('digital_author' ) =='1' ) {load_template(get_template_directory() . '/includes/author.php'); } ?>
<?php if ( of_get_option('digital_links' ) =='on') { ?>
		<div id="single-nav" class="clearfix">
			<div id="single-nav-left"><?php previous_post_link('&laquo; <strong>%link</strong>'); ?></div>
		<div id="single-nav-right"><?php next_post_link('<strong>%link</strong> &raquo;'); ?></div>
        </div>		<?php } ?>
		 <?php if (!dynamic_sidebar('belowsinglepost') ) : endif; ?>
        <!-- END single-nav -->
			<div class="comments">	<?php comments_template(); ?>	</div> <!-- end div .comments --></article>
			<?php endwhile; ?>
			<?php else : ?>
				<div class="post">
					<h3><?php esc_attr('404 Error&#58; Not Found', 'digital' ); ?></h3>
				</div>
			<?php endif; ?>
		</div> <!-- end div #content -->
			
<?php get_sidebar(); ?>
<?php get_footer(); ?>