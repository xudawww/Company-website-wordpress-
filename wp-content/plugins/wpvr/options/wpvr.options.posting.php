<!-- deferAdding *** -->
<?php wpvr_render_switch_option( array(
	'tab'          => 'posting',
	'id'           => 'deferAdding',
	'label'        => __( 'Defer video adding', WPVR_LANG ),
	'desc'         => __( 'Deferring video adding is very useful to avoid a server overload during the automation execution.', WPVR_LANG ) . '<br />' .
	                  __( 'You can set here the defer buffer which is the maximum number of videos to be added at once.', WPVR_LANG ) . '<br/>' .
	                  __( 'When the CRON is configured properly, the deferred videos will be added each 10 minutes.', WPVR_LANG ),
	'function_out' => function () {
		
		//echo wpvr_render_wake_up_hours();
	 
		global $wpvr_options;
		?>
        <div class="wpvr_switch_conditional_content">
            <div class="wpvr_sub_option full">
                <label class="wpvr_option_title wpvr_conditional_label">
					<?php echo __( 'Defer Adding Buffer', WPVR_LANG ); ?>
                </label>
                
                <br/><br/><br/>


                <div class="wpvr_option_value_wrap">
                    <input type="hidden" class="wpvr_option_value_input a" name="deferBuffer"
                           value="<?php echo $wpvr_options['deferBuffer']; ?>"/>
                    <div
                            class="wpvr_option_value_slider"
                            data-min="1"
                            data-max="30"
                            data-step="1"
                    ></div>
                </div>
                
                

            </div>
        </div>

        <div class="wpvr_clearfix"></div>
		<?php
	},
), $wpvr_options['deferAdding'] ); ?>


<!-- downloadThumb *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'fetching',
	'id'    => 'downloadThumb',
	'label' => __( 'Default Download Thumbnails', WPVR_LANG ),
	'desc'  => __( 'Choose whether to download or not the video thumbnail on your site and set it as the imported video featured image.', WPVR_LANG ) . '<br/>' .
	           __( 'Using external thumbnails will enhance the plugin performances considerably.', WPVR_LANG ) .
	           '<br/>' . '<em>' . __( 'This is the default setting value for all sources.', WPVR_LANG ) . '</em>',
), $wpvr_options['downloadThumb'] ); ?>

<?php global $wpvr_post_statuses; ?>

<!-- autoPublish *** -->
<?php wpvr_render_select_option( array(
	'tab'   => 'fetching',
	'id'    => 'postStatus',
	'label' => __( 'Default Post Status', WPVR_LANG ),
	'desc'  => __( 'Choose what post status the imported videos should automatically have.', WPVR_LANG ) . '<br/>' .
	           //__( 'If you turn off this option, imported videos will be posted as drafts until you review and publish them manually.', WPVR_LANG ).
	           '<br/>' . '<em>' . __( 'This is the default setting value for all sources.', WPVR_LANG ) . '</em>',
	'options' => $wpvr_post_statuses,
), $wpvr_options['postStatus'] ); ?>

<!-- getPostDate -->
<?php wpvr_render_select_option( array(
	'tab'     => 'posting',
	'id'      => 'getPostDate',
	'label'   => __( 'Default Post Date', WPVR_LANG ),
	'desc'    => __( 'When posting imported videos, you can either use the original video service publishing date, or the actual import date.', WPVR_LANG )
	             . '<br/>' . '<em>' . __( 'This is the default setting value for all sources.', WPVR_LANG ) . '</em>',
	'options' => array(
		'original' => __( 'Use Original Post Date', WPVR_LANG ),
		'new'      => __( 'Use Import Date ', WPVR_LANG ),
	),
), $wpvr_options['getPostDate'] ); ?>


<!-- postContent -->
<?php wpvr_render_select_option( array(
	'tab'     => 'posting',
	'id'      => 'postContent',
	'label'   => __( 'Default Post Content', WPVR_LANG ),
	'desc'    => __( 'Choose whether to import and use the video description as the post content, or import the video player only.', WPVR_LANG )
	             . '<br/>' . '<em>' . __( 'This is the default setting value for all sources.', WPVR_LANG ) . '</em>',
	'options' => array(
		'on'  => __( 'Import & Post Video Text Content', WPVR_LANG ),
		'off' => __( 'Skip Video Text Content', WPVR_LANG ),
	),
), $wpvr_options['postContent'] ); ?>


<!-- postFormat -->
<?php if ( WPVR_ENABLE_POST_FORMATS ) { ?>
	<?php wpvr_render_select_option( array(
		'tab'     => 'posting',
		'id'      => 'postFormat',
		'label'   => __( 'Default Post Format', WPVR_LANG ),
		'desc'    => __( 'Choose the default WP Post Format to assign to your imported videos.', WPVR_LANG )
		             . '<br/>' . '<em>' . __( 'This is the default setting value for all sources.', WPVR_LANG ) . '</em>',
		'options' => array(
			'0'       => __( 'Standard', WPVR_LANG ),
			'aside'   => __( 'Aside', WPVR_LANG ),
			'image'   => __( 'Image', WPVR_LANG ),
			'video'   => __( 'Video', WPVR_LANG ),
			'audio'   => __( 'Audio', WPVR_LANG ),
			'quote'   => __( 'Quote', WPVR_LANG ),
			'link'    => __( 'Link', WPVR_LANG ),
			'gallery' => __( 'Gallery', WPVR_LANG ),
		),
	), $wpvr_options['postFormat'] ); ?>
<?php } ?>


<!-- postAuthor -->
<?php $authorsArray = wpvr_get_authors( $invert = true, $default = false, $restrict = false ); ?>
<?php wpvr_render_select_option( array(
	'tab'     => 'posting',
	'id'      => 'postAuthor',
	'label'   => __( 'Default Posting Author', WPVR_LANG ),
	'desc'    => __( 'Choose the WP user that should be the author of the imported videos. ', WPVR_LANG )
	             . '<br/>' . '<em>' . __( 'This is the default setting value for all sources.', WPVR_LANG ) . '</em>',
	'options' => $authorsArray,
), $wpvr_options['postAuthor'] ); ?>

<!-- postTags *** -->
<?php wpvr_render_textarea_option( array(
	'tab'        => 'posting',
	'id'         => 'postTags',
	'attributes' => array(
		// 'style' => 'width:400px; height:200px;',
		'cols' => 70,
		'rows' => 4,
	),
	'label'      => __( 'Default Post Tags', WPVR_LANG ),
	'desc'       => __( 'Define the WP tags that should be automatically assigned to your imported videos.', WPVR_LANG ) . '<br />' .
	                __( 'Enter a comma-separated list of tags.', WPVR_LANG )
	                . '<br/>' . '<em>' . __( 'This is the default setting value for all sources.', WPVR_LANG ) . '</em>',
), $wpvr_options['postTags'] ); ?>


<!-- startWithServiceViews *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'fetching',
	'id'    => 'startWithServiceViews',
	'label' => __( 'Start local views count with Video Service views count ?', WPVR_LANG ),
	'desc'  => __( 'Enable this option to start your imported views count with the real video service views count.', WPVR_LANG ) . '<br/>' .
	           __( 'If you disable this option, the local views count will start at 0.', WPVR_LANG ),
), $wpvr_options['startWithServiceViews'] ); ?>


