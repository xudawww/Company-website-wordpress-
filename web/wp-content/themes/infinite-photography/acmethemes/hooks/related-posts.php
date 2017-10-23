<?php
/**
 * Display related posts from same category
 *
 * @since Infinite Photography- 1.0.0
 *
 * @param int $post_id
 * @return void
 *
 */
if ( !function_exists('infinite_photography_related_post_below') ) :

    function infinite_photography_related_post_below( $post_id ) {
	    global $infinite_photography_customizer_all_values;
	    $infinite_photography_related_title = esc_html( $infinite_photography_customizer_all_values['infinite-photography-related-title'] );

	    if( 0 == $infinite_photography_customizer_all_values['infinite-photography-show-related'] ){
		    return;
	    }
	    $infinite_photography_cat_post_args = array(
		    'post__not_in' => array($post_id),
		    'post_type' => 'post',
		    'posts_per_page'      => 3,
		    'post_status'         => 'publish',
		    'ignore_sticky_posts' => true
	    );
	    if( 0 == $infinite_photography_customizer_all_values['infinite-photography-show-related'] ){
		    return;
	    }
	    $infinite_photography_related_post_display_from = $infinite_photography_customizer_all_values['infinite-photography-related-post-display-from'];

	    if( 'tag' == $infinite_photography_related_post_display_from ){

		    $tags = get_post_meta( $post_id, 'related-posts', true );
		    if ( !$tags ) {
			    $tags = wp_get_post_tags( $post_id, array('fields'=>'ids' ) );
			    $infinite_photography_cat_post_args['tag__in'] = $tags;
		    }
		    else {
			    $infinite_photography_cat_post_args['tag_slug__in'] = explode(',', $tags);
		    }

	    }
	    else{

		    $cats = get_post_meta( $post_id, 'related-posts', true );
		    if ( !$cats ) {
			    $cats = wp_get_post_categories( $post_id, array('fields'=>'ids' ) );
			    $infinite_photography_cat_post_args['category__in'] = $cats;
		    }
		    else {
			    $infinite_photography_cat_post_args['cat'] = $cats;
		    }

	    }
	    $infinite_photography_featured_query = new WP_Query($infinite_photography_cat_post_args);
	    if( $infinite_photography_featured_query->have_posts() ){
	        if( !empty( $infinite_photography_related_title ) ){
	            ?>
                <h2 class="widget-title text-center">
			        <?php echo esc_html( $infinite_photography_related_title ); ?>
                </h2>
                <?php
            }

		    $infinite_photography_photo_index = 1;

		    while ( $infinite_photography_featured_query->have_posts() ) :$infinite_photography_featured_query->the_post();
			    get_template_part( 'template-parts/content', 'related' );
			    $infinite_photography_photo_index++;
		    endwhile;
		    wp_reset_postdata();
		    ?>
            <div class="clearfix"></div>
            <?php
        }
    }
endif;

add_action( 'infinite_photography_related_posts', 'infinite_photography_related_post_below', 10, 1 );