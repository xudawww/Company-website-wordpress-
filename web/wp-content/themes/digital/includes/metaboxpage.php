<?php
/**
 * Add meta box
 *
 */
function digitalpage_add_meta_boxes( $post ){
	add_meta_box( 'food_meta_box', __( '<span class="dashicons dashicons-layout"></span> Page Layout Select [Pro Only]', 'digital' ), 'digitalpage_build_meta_box', 'page', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'digitalpage_add_meta_boxes' );
/**
 * Build custom field meta box
 *
 * @param post $post The post object
 */
function digitalpage_build_meta_box( $post ){
	// make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), 'digitalpagemeta_meta_box_nonce' );
	// retrieve the _food_digitalpagemeta current value
	$current_digitalpagemeta = get_post_meta( $post->ID, '_food_digitalpagemeta', true );
	
	$upgradetopro = 'Layout Select for current Page only - for website layout please choose from theme options <a href="' . esc_url('http://www.insertcart.com/product/digital/','digital') . '" target="_blank">' . esc_attr__( 'Get Digital Pro', 'digital' ) . '</a>';

	?>
	<div class='inside'>

		<h4><?php echo $upgradetopro; ?></h4>
		<p>
			<input type="radio" name="digitalpagemeta" value="rsd" <?php checked( $current_digitalpagemeta, 'rsd' ); ?> /> <?php _e('Right Sidebar - Default','digital'); ?><br />
			<input type="radio" name="digitalpagemeta" value="ls" <?php checked( $current_digitalpagemeta, 'ls' ); ?> /> <?php _e('Left Sidebar','digital'); ?><br/>
			<input type="radio" name="digitalpagemeta" value="lr" <?php checked( $current_digitalpagemeta, 'lr' ); ?> />     <?php _e('Left - Right Sidebars','digital'); ?> <br/>
			<input type="radio" name="digitalpagemeta" value="fc" <?php checked( $current_digitalpagemeta, 'fc' ); ?> /> <?php _e('Full Content - No Sidebar','digital'); ?>
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
function digitalpage_save_meta_box_data( $post_id ){
	// verify meta box nonce
	if ( !isset( $_POST['digitalpagemeta_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['digitalpagemeta_meta_box_nonce'], basename( __FILE__ ) ) ){
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
	// digitalpagemeta string
	if ( isset( $_REQUEST['digitalpagemeta'] ) ) {
		update_post_meta( $post_id, '_food_digitalpagemeta', sanitize_text_field( $_POST['digitalpagemeta'] ) );
	}

}
add_action( 'save_post', 'digitalpage_save_meta_box_data' );