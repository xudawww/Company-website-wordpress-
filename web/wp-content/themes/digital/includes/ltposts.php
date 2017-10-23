<?php if ( of_get_option('digital_latest' ) =='1') { ?>
<div class="productlist"><?php echo'<div class="posthd">'; digital_tiltechange(); echo'</div>';?>
<?php 
$digital_argsl = array( 
	'ignore_sticky_posts' => true,
	'showposts' => 4,
	'cat' => of_get_option( 'select_categories', '1' ),
	'orderby' => 'date',  );
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
			</div>
			<?php } ?>	
			
<?php if ( of_get_option('digital_latest2' ) =='1') { ?>
			<div class="productlist"><?php echo'<div class="posthd2">'; digital_tiltechange2(); echo'</div>';?>
<?php 
$digitalargs = array( 
 'ignore_sticky_posts' => true,
 'showposts' => 4,
 'cat' => of_get_option( 'select_categories2', '1' ),
'orderby' => 'date',  );
$the_query = new WP_Query( $digitalargs );
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
			</div><?php } ?>	