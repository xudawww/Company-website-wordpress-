<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Whiteboard64
 */

?>

<div class="col-xs-12 col-sm-12 listings wow fadeInUp" data-wow-duration="2s">
	<div class="col-md-4 img-list">
		<div class="image">
			<?php if (has_post_thumbnail()) : ?>
	  		<?php the_post_thumbnail('full', 'img-responsive'); ?>
			<?php else : ?>
				<div class="no-img"><i class="fa fa-camera-retro fa-5x"></i></div>
			<?php endif; ?>
		</div>

		<div class="post-date">
      		<div class="month-day"><?php echo get_the_date('d M');?></div>
      		<div class="year"><?php echo get_the_date('Y');?></div>
  		</div>
	</div><!--col-sm-4 img-list end--> 
      
	<div class="col-md-8 list-content">    
		<h4><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
		<?php the_excerpt(); ?>
		<a class="btn btn-default" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">Full Details</a>
	</div><!-- list content end--> 
</div> <!--listings end--> 