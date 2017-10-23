<?php 
$digital_argsl = array( 
'ignore_sticky_posts' => true,
 'ignore_sticky_posts' => true,
 'showposts' => 6,
 'orderby' => 'rand',  );
$the_query = new WP_Query( $digital_argsl );
 if ( $the_query->have_posts() ) :
while ( $the_query->have_posts() ) : $the_query->the_post();
			 ?>
<div class="latest-post">
	<a title="<?php esc_attr(the_title()); ?>" href="<?php esc_url(the_permalink()); ?>" rel="bookmark">
	<?php if ( has_post_thumbnail() ) {the_post_thumbnail('latestpost'); } 
		elseif (of_get_option( 'digital_defaulthumb')) { 
		echo'<img src="' . esc_url(of_get_option( 'digital_defaulthumb')).'" />' ; }
		else { 
		echo '<img src="'.esc_url(get_template_directory_uri().'/images/thumb.jpg" />'). "\n"; }
	  ?></a> 
									 <a title="<?php esc_attr(the_title()); ?>" href="<?php esc_url(the_permalink()); ?>" rel="bookmark"><?php esc_attr(the_title()); ?></a>
									 <div class="desc"><?php esc_attr(digital_excerpt('digital_excerptlength_index', 'digital_excerptmore')); ?></div>
									 <span class="authmt"> <?php digital_post_meta_data(); ?></span>
									 <div class="clear"></div></div>
							<?php endwhile; ?>
							<?php endif; ?>			 <?php wp_reset_postdata(); ?>
			<div style="clear:both;">
			</div>