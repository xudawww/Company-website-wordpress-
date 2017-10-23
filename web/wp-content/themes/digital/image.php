<?php get_header(); ?>
<div id="page">
	<div id="page-inner" class="clearfix">
		<div id="content"><?php digital_breadcrumbs(); ?>
<?php if(have_posts()) : ?>
<?php while(have_posts())  : the_post(); ?>

<h1><?php the_title(); ?></h1>
<div class="entry" class="clearfix"><?php if (of_get_option('digital_ad2') <> "" ) { echo stripslashes(of_get_option('digital_ad2')); } ?>
<div class="entry-meta">
								<?php
								$metadata = wp_get_attachment_metadata();
								printf( __( '<span class="meta-prep meta-prep-entry-date">Published </span> <span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%8$s</a>.', 'digital' ),
									esc_attr( get_the_date( 'c' ) ),
									esc_html( get_the_date() ),
									esc_url( wp_get_attachment_url() ),
									$metadata['width'],
									$metadata['height'],
									esc_url( get_permalink( $post->post_parent ) ),
									esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
									get_the_title( $post->post_parent )
								);
							?>
								<?php edit_post_link( __( 'Edit', 'digital' ), '<span class="edit-link">', '</span>' ); ?>
								</div><!-- .entry-meta -->
							<div class="entry-content">

						<div class="entry-attachment">
							<div class="attachment">
<?php
/**
 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
 */
$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
foreach ( $attachments as $k => $attachment ) :
	if ( $attachment->ID == $post->ID )
		break;
endforeach;

$k++;
// If there is more than 1 attachment in a gallery
if ( count( $attachments ) > 1 ) :
	if ( isset( $attachments[ $k ] ) ) :
		// get the URL of the next image attachment
		$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
	else :
		// or get the URL of the first image attachment
		$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	endif;
else :
	// or, if there's only 1 image, get the URL of the image
	$next_attachment_url = wp_get_attachment_url();
endif;
?>
								<a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php
								$attachment_size = apply_filters( 'digital_attachment_size', array( 960, 960 ) );
								echo wp_get_attachment_image( $post->ID, $attachment_size );
								?></a>

								<?php if ( ! empty( $post->post_excerpt ) ) : ?>
								<div class="entry-caption">
									<?php the_excerpt(); ?>
								</div>
								<?php endif; ?>
							</div><!-- .attachment -->

						</div><!-- .entry-attachment -->

						<div class="entry-description">
							<?php the_content(); ?>
							<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'digital' ), 'after' => '</div>' ) ); ?>
						</div><!-- .entry-description -->

					</div><!-- .entry-content -->
							</div> <!-- end div .entry -->
<span class="postmeta_box">
		<ul class="auth"> <?php digital_post_meta_data(); ?>, in <?php the_category(', '); ?>
</ul>
<ul class="tags">			
<?php if("the_tags") the_tags('Tags: ', ', ', ' - '); ?><?php edit_post_link('Edit', ' &#124; ', ''); ?>
	</ul>

</span>		

<div class="gap"></div><?php if (of_get_option('digital_author' ) =='1' ) {load_template(get_template_directory() . '/includes/author.php'); } ?>

<?php if ( of_get_option('digital_links' ) =='on') { ?>
		<div id="single-nav" class="clearfix">
			<div id="single-nav-left"><?php previous_image_link('thumbnail'); ?></div>
		<div id="single-nav-right"><?php next_image_link('thumbnail'); ?></div>
        </div>		<?php } ?>
        <!-- END single-nav -->
		
			<div class="comments">	<?php comments_template(); ?>	</div> <!-- end div .comments -->	
			<?php endwhile; ?>
			<?php else : ?>
				<div class="post">
					<h3><?php _e('404 Error&#58; Not Found', 'digital' ); ?></h3>
				</div>
			<?php endif; ?>
		</div> <!-- end div #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>