<?php
	$rewrite_helper = '
		<div class="wpvr_switch_conditional_content">
			<br />
			<strong>No Permalink Base </strong> : domain.com/my-imported-video-title <br/>
			<strong>Category Permalink Base </strong> : domain.com/my-category/my-imported-video-title <br/>
			<strong>Custom Permalink Base </strong> : domain.com/my-custom-text/my-imported-video-title <br/>
		</div>
	';


?>
<!-- videoType -->
<?php wpvr_addon_option_render( array(
	'id'          => 'videoType',
	'order'       => 11,
	'label'       => __( 'Imported Videos Post Type', WPVR_LANG ),
	'placeholder' => __( 'Pick one post type', WPVR_LANG ),
	'values'      => wpvr_get_available_post_types(),
	'desc'        => __( 'Select which WP Post Type should be used to store your imported videos.', WPVR_LANG ),
	'type'        => 'select',
	'tab_class'   => 'tab_d',
), $wpvr_options['videoType'] ); ?>

<!-- addVideoType *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'addVideoType',
	'label' => __( 'Auto-include videos in your site queries', WPVR_LANG ),
	'desc'  => __( 'Enable this option to automatically join your imported videos to all your existent WP Queries.', WPVR_LANG ) . '<br/>' .
	           __( 'Note that this works only when the Imported Videos Post Type option is not set on regular post', WPVR_LANG ),
), $wpvr_options['addVideoType'] ); ?>

<!-- enableVideoComments *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'enableVideoComments',
	'label' => __( 'Enable Comments on Imported Videos', WPVR_LANG ),
	'desc'  => __( 'Enable this option to add comments support to the imported videos.', WPVR_LANG ),
), $wpvr_options['enableVideoComments'] ); ?>

<!-- enableVideoControls *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'enableVideoControls',
	'label' => __( 'Enable Player Controls on Imported Videos', WPVR_LANG ),
	'desc'  => __( 'Choose whether to show or hide the video player controls when watching the imported videos.', WPVR_LANG ) . '<br/>' .
	           __( 'Note that this feature works only for Youtube videos.', WPVR_LANG ),
), $wpvr_options['enableVideoControls'] ); ?>


<!-- enableRewriteRule *** -->
<?php wpvr_render_switch_option( array(
	'tab'         => 'integration',
	'id'          => 'enableRewriteRule',
	'function_in' => function () {
		
		global $wpvr_options;
		
		$isSelected = array(
			'none'     => '',
			'category' => '',
			'custom'   => '',
		);
		
		$isSelected[ $wpvr_options['permalinkBase'] ] = ' selected="selected" ';
		
		$hideIt = $wpvr_options['permalinkBase'] != 'custom' ? 'display:none;' : '';
		
		
		?>

        <div class="wpvr_switch_conditional_content wpvr_rewrite_mode">

            <select
                    class="wpvr_option_select pull-right "
                    name="permalinkBase"
                    id="permalinkBase"
            >
                <option value="none" <?php echo $isSelected['none']; ?>>
					<?php _e( 'No Permalink Base', WPVR_LANG ); ?>
                </option>
                <option value="category" <?php echo $isSelected['category']; ?>>
					<?php _e( 'Category Permalink Base', WPVR_LANG ); ?>
                </option>
                <option value="custom" <?php echo $isSelected['custom']; ?>>
					<?php _e( 'Custom Permalink Base', WPVR_LANG ); ?>
                </option>
            </select>

            <div class="wpvr_clearfix"><br/></div>

            <input
                    type="text"
                    class="wpvr_options_input wpvr_large pull-right"
                    id="customPermalinkBase"
                    name="customPermalinkBase"
                    value="<?php echo $wpvr_options['customPermalinkBase']; ?>"
                    style="<?php echo $hideIt; ?>"
                    placeholder="Custom Permalink Base"
            />

            <div class="wpvr_clearfix"><br/></div>

        </div>
		<?php
	},
	'label'       => __( 'Enable Permalink Rewrite', WPVR_LANG ),
	'desc'        => __( 'Enable this option to activate videos permalink rewrite.', WPVR_LANG ) . '<br/>' .
	                 __( 'Turn off this option to handle permalinks from the WP Permalink Settings screen.', WPVR_LANG ) . $rewrite_helper,
), $wpvr_options['enableRewriteRule'] ); ?>


<!-- forceExternalThumb *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'forceExternalThumb',
	'label' => __( 'Force the use of external thumbnails', WPVR_LANG ) . ' (beta)',
	'desc'  => __( 'Enable this option when you import videos without downloading the thumbnails to your site.', WPVR_LANG ) . '<br/>' .
	           __( 'When enabled, the plugin will automatically load the external video thumbnails as featured images.', WPVR_LANG ) . '<br/>' .
	           __( 'This is still in BETA version. Turn it off if you have any trouble with the featured images on your site.', WPVR_LANG ) . '<br/>',
), $wpvr_options['forceExternalThumb'] ); ?>

<!-- videoThumb *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'videoThumb',
	'label' => __( 'Embed Video Instead of Image Thumbnail', WPVR_LANG ),
	'desc'  => __( 'Enable this option to replace the video thumbnails by their respective embedded video players.', WPVR_LANG ) . '<br/>' .
	           __( 'Note that in order to have more traffic and a better page load time, we strongly recommend not using this feature.', WPVR_LANG ),
), $wpvr_options['videoThumb'] ); ?>


<!-- autoEmbed *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'autoEmbed',
	'label' => __( 'AutoEmbed Videos Player in Content', WPVR_LANG ),
	'desc'  => __( 'By default, the plugin will try to automatically implement the video player in your post content during the frontend rendering.', WPVR_LANG ) . '<br/>' .
	           __( 'Turn this option off if you want to embed the player by editing your theme files, or if you\'re having double player on your videos.', WPVR_LANG ),
), $wpvr_options['autoEmbed'] ); ?>

<!-- removeVideoContent *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'removeVideoContent',
	'label' => __( 'Remove Video Text Content', WPVR_LANG ),
	'desc'  => __( 'Turn this on to disable rendering the video text content below the video player.', WPVR_LANG ),
), $wpvr_options['removeVideoContent'] ); ?>

<!-- playerAutoPlay *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'playerAutoPlay',
	'label' => __( 'AutoPlay Embedded Player in Content', WPVR_LANG ),
	'desc'  => __( 'Choose whether to start the video players automatically or not.', WPVR_LANG ),
), $wpvr_options['playerAutoPlay'] ); ?>

<!-- hidePlayerTitle *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'hidePlayerTitle',
	'label' => __( 'Hide Player Title', WPVR_LANG ),
	'desc'  => __( 'You can define whether to show or hide the video title inside the player.', WPVR_LANG ) . ' ' .
	           __( 'Works only with Youtube.', WPVR_LANG ) . '<br/>' .
	           '<em>' . __( 'This is the default setting value for all videos and sources.', WPVR_LANG ) . '</em>',
), $wpvr_options['hidePlayerTitle'] ); ?>

<!-- hidePlayerRelated *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'hidePlayerRelated',
	'label' => __( 'Hide Player Related', WPVR_LANG ),
	'desc'  => __( 'You can define whether to show or hide the related videos inside the player when the video ends or gets paused.', WPVR_LANG ) . ' ' .
	           __( 'Works only with Youtube.', WPVR_LANG ) . '<br/>' .
	           '<em>' . __( 'This is the default setting value for all videos and sources.', WPVR_LANG ) . '</em>',
), $wpvr_options['hidePlayerRelated'] ); ?>

<!-- hidePlayerAnnotations *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'hidePlayerAnnotations',
	'label' => __( 'Hide Player Annotations', WPVR_LANG ),
	'desc'  => __( 'You can define whether to show or hide the video annotations inside the player.', WPVR_LANG ) . ' ' .
	           __( 'Works only with Youtube.', WPVR_LANG ) . '<br/>' .
	           '<em>' . __( 'This is the default setting value for all videos and sources.', WPVR_LANG ) . '</em>',
), $wpvr_options['hidePlayerAnnotations'] ); ?>

<!-- adminOverride *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'integration',
	'id'    => 'adminOverride',
	'label' => __( 'Override videos admin columns', WPVR_LANG ),
	'desc'  => __( 'Choose whether to use the WP Video Robot columns styling or the WordPress admin columns for on your videos listing screen.', WPVR_LANG ),
), $wpvr_options['adminOverride'] ); ?>


<!-- privateCPT -->

<?php wpvr_render_hybrid_option( array(
	'tab'        => 'integration',
	'id'         => 'privateCPT',
	'label'      => __( 'Private Custom Post Types', WPVR_LANG ),
	'desc'       => __( 'Choose which other custom post types the plugin should not conflict with.', WPVR_LANG ),
	'render_fct' => function () {
		global $wpvr_options;
		$values        = array();
		$internal_cpts = array(
			//'page' ,
			'post',
			WPVR_VIDEO_TYPE,
			'attachment',
			'revision',
			WPVR_SOURCE_TYPE,
			'nav_menu_item',
		);
		// GET ALL POST TYPES
		$post_types = get_post_types( array() );
		foreach ( (array) $post_types as $cpt ) {
			if ( ! in_array( $cpt, $internal_cpts ) ) {
				$values[ $cpt ] = $cpt;
			}
		}
		
		wpvr_render_selectized_field( array(
			'name'        => 'privateCPT',
			'placeholder' => __( 'Pick one or more custom post type.', WPVR_LANG ),
			'values'      => $values,
			'maxItems'    => 255,
		
		), $wpvr_options['privateCPT'] );
		
		echo '<div class="wpvr_clearfix"></div>';
	},
), $wpvr_options['privateCPT'] ); ?>
