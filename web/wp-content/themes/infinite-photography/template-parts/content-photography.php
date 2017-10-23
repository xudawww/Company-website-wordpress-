<?php
/**
 * Template part for displaying posts in masonry.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Acme Themes
 * @subpackage Infinite Photography
 */
global $infinite_photography_customizer_all_values;
$infinite_photography_blog_archive_image_size = $infinite_photography_customizer_all_values['infinite-photography-blog-archive-image-size'];
$infinite_photography_blog_archive_click_image_size = $infinite_photography_customizer_all_values['infinite-photography-blog-archive-click-image-size']

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'acme-col-3 masonry-post' ); ?>>
	<?php
	if( has_post_thumbnail() ):
		$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $infinite_photography_blog_archive_image_size );
		$image_url_full = wp_get_attachment_image_src( get_post_thumbnail_id(), $infinite_photography_blog_archive_click_image_size );

	else:
		$image_url[0] = get_template_directory_uri().'/assets/img/no-image-840-480.jpg';
		$image_url_full[0] = get_template_directory_uri().'/assets/img/no-image-840-480.jpg';
	endif;
	?>
  <div class="masonry-item post-item" style="background-image: url('<?php echo esc_url( $image_url[0] );?>')">
	  <div class="post-content">
		  <div class="inner-content">
			  <div class="inner-content-middle">
				  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				  <div class='at-icon-link'>
					  <a class="image-link" href="<?php echo esc_url( $image_url_full[0] );?>"><i class="fa fa-eye"></i></a>
					  <a href="<?php the_permalink();?>"><i class="fa fa-external-link"></i></a>
				  </div>
			  </div>
		  </div>
	  </div>
  </div><!-- .masonry-thumbnail -->
</article><!-- #post-## -->