<?php
/**
 * Add meta box
 *
 */
function digitalsingle_add_meta_boxes( $post ){
	add_meta_box( 'food_meta_box', __( '<span class="dashicons dashicons-layout"></span> Post Layout Select [Pro Only]', 'digital' ), 'digitalsingle_build_meta_box', 'post', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'digitalsingle_add_meta_boxes' );
/**
 * Build custom field meta box
 *
 * @param post $post The post object
 */
function digitalsingle_build_meta_box( $post ){
	// make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), 'digitalsinglemeta_meta_box_nonce' );
	// retrieve the _food_digitalsinglemeta current value
	$current_digitalsinglemeta = get_post_meta( $post->ID, '_food_digitalsinglemeta', true );
$upgradetopro = 'Layout Select for current post only - for website layout please choose from theme options <a href="' . esc_url('http://www.insertcart.com/product/digital-wp-theme/','digital') . '" target="_blank">' . esc_attr__( 'Get Digital Pro', 'digital' ) . '</a>';

	?>
	<div class='inside'>

		<h4><?php echo $upgradetopro; ?></h4>
		<p>
			<input type="radio" name="digitalsinglemeta" value="rsd" <?php checked( $current_digitalsinglemeta, 'rsd' ); ?> /> <?php _e('Right Sidebar - Default','digital'); ?><br />
			<input type="radio" name="digitalsinglemeta" value="ls" <?php checked( $current_digitalsinglemeta, 'ls' ); ?> /> <?php _e('Left Sidebar','digital'); ?><br/>
			<input type="radio" name="digitalsinglemeta" value="lr" <?php checked( $current_digitalsinglemeta, 'lr' ); ?> /> <?php _e('Left - Right Sidebars','digital'); ?> <br/>
			<input type="radio" name="digitalsinglemeta" value="fc" <?php checked( $current_digitalsinglemeta, 'fc' ); ?> /> <?php _e('Full Content - No Sidebar','digital'); ?>
		</p>

		

	</div>
	<?php
}
/**
 * Store custom field meta box data
 *
 * @param int $post_id The post ID.
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/save_post
 */
function food_save_meta_box_data( $post_id ){
	// verify meta box nonce
	if ( !isset( $_POST['digitalsinglemeta_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['digitalsinglemeta_meta_box_nonce'], basename( __FILE__ ) ) ){
		return;
	}
	// return if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
  // Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}
	// store custom fields values
	// digitalsinglemeta string
	if ( isset( $_REQUEST['digitalsinglemeta'] ) ) {
		update_post_meta( $post_id, '_food_digitalsinglemeta', sanitize_text_field( $_POST['digitalsinglemeta'] ) );
	}

}
add_action( 'save_post', 'food_save_meta_box_data' );