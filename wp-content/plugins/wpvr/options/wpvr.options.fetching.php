<?php
	
	
	//Defining wantedValues PArams
	if ( ! defined( 'WPVR_MAX_WANTED_VIDEOS' ) || WPVR_MAX_WANTED_VIDEOS === false ) {
		$wanted_limit   = __( 'Unlimited', WPVR_LANG );
		$wanted_maximum = '';
	} else {
		$wanted_limit   = __( 'Limited to', WPVR_LANG ) . ' : ' . WPVR_MAX_WANTED_VIDEOS;
		$wanted_maximum = WPVR_MAX_WANTED_VIDEOS;
	}


?>


<!-- wantedVideos *** -->
<?php wpvr_render_input_option( array(
	'tab'        => 'fetching',
	'id'         => 'wantedVideos',
	'class'      => 'small',
	'label'      => __( 'Default Wanted Videos', WPVR_LANG ),
	'desc'       => __( 'Define here how many videos you want to fetch and import at once.', WPVR_LANG ) . '<br/>' .
	                __( 'We strongly recommend that you set this to a low number to avoid crashing your server.', WPVR_LANG ) . '<br/>' .
	                '<em>' . __( 'This is the default setting value for all sources.', WPVR_LANG ) . '</em>',
	'attributes' => array(
		'max_value' => $wanted_maximum,
	),
), $wpvr_options['wantedVideos'] ); ?>


<!-- orderVideos -->
<?php wpvr_render_select_option( array(
	'tab'     => 'fetching',
	'id'      => 'orderVideos',
	'label'   => __( 'Default Order By', WPVR_LANG ),
	'desc'    => __( 'Define the the criterion that should be used to order the fetched videos.', WPVR_LANG ) . '<br/>' .
	             '<em>' . __( 'This is the default setting value for all sources.', WPVR_LANG ) . '</em>',
	'options' => array(
		'relevance' => __( 'Relevance', WPVR_LANG ),
		'date'      => __( 'Date', WPVR_LANG ),
		'viewCount' => __( 'Views', WPVR_LANG ),
		'title'     => __( 'Title', WPVR_LANG ),
	),
), $wpvr_options['orderVideos'] ); ?>


<!-- onlyNewVideos *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'fetching',
	'id'    => 'onlyNewVideos',
	'label' => __( 'Skip Duplicates', WPVR_LANG ),
	'desc'  => __( 'Choose whether to import only new videos, and skip already imported videos.', WPVR_LANG ) . '<br/>' .
	           __( 'Note that if you turn off this option, you will have several duplicates of the same video on your site.', WPVR_LANG ) . '<br/>' .
	           '<em>' . __( 'This is the default setting value for all sources.', WPVR_LANG ) . '</em>',
), $wpvr_options['onlyNewVideos'] ); ?>

<!-- getStats *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'fetching',
	'id'    => 'getStats',
	'label' => __( 'Default Statistics', WPVR_LANG ),
	//'desc'  => __( 'Grab Youtube views, duration and likes. You can improve performances by setting this option to off.', WPVR_LANG ),
	'desc'  => __( 'Choose whether to import video views, duration and likes too.', WPVR_LANG ) . '<br/>' .
	           __( 'Note that this feature is only supported by Youtube. Turn this off to improve the plugin performances.', WPVR_LANG ) . '<br/>' .
	           '<em>' . __( 'This is the default setting value for all sources.', WPVR_LANG ) . '</em>',

), $wpvr_options['getStats'] ); ?>

<!-- getTags *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'fetching',
	'id'    => 'getTags',
	'label' => __( 'Default Video Tags', WPVR_LANG ),
	'desc'  => __( 'Choose whether to import and assign the video tags while importing the video.', WPVR_LANG ) . '<br/>' .
	           __( 'Note that this feature is only supported by Youtube. Turn this off to improve the plugin performances.', WPVR_LANG ) . '<br/>' .
	           '<em>' . __( 'This is the default setting value for all sources.', WPVR_LANG ) . '</em>',

), $wpvr_options['getTags'] ); ?>


<!-- publishedAfter *** -->
<?php wpvr_render_input_option( array(
	'tab'         => 'fetching',
	'id'          => 'publishedAfter',
	'label'       => __( 'Default Published After Date', WPVR_LANG ),
	'desc'        => __( 'Import only videos published after this date.', WPVR_LANG ) . ' ' .
	                 __( 'Leave empty to ignore this criterion.', WPVR_LANG ) . '<br/>' .
	                 __( 'Note that this feature is only supported by Youtube and Dailymotion. Supported Format: mm/dd/YYYY', WPVR_LANG ) . '<br/>' .
	                 '<em>' . __( 'This is the default setting value for all sources.', WPVR_LANG ) . '</em>',
	'placeholder' => 'Format : mm/dd/YYYY',
), $wpvr_options['publishedAfter'] ); ?>

<!-- publishedBefore *** -->
<?php wpvr_render_input_option( array(
	'tab'         => 'fetching',
	'id'          => 'publishedBefore',
	'label'       => __( 'Default Published Before Date', WPVR_LANG ),
	'desc'        => __( 'Import only videos published before this date.', WPVR_LANG ) . ' ' .
	                 __( 'Leave empty to ignore this criterion.', WPVR_LANG ) . '<br/>' .
	                 __( 'Note that this feature is only supported by Youtube and Dailymotion. Supported Format: mm/dd/YYYY', WPVR_LANG ) . '<br/>' .
	                 '<em>' . __( 'This is the default setting value for all sources.', WPVR_LANG ) . '</em>',
	'placeholder' => 'Format : mm/dd/YYYY',
), $wpvr_options['publishedBefore'] ); ?>

<!-- videoDuration -->
<?php wpvr_render_select_option( array(
	'tab'     => 'fetching',
	'id'      => 'videoDuration',
	'label'   => __( 'Default Video Duration', WPVR_LANG ),
	'desc'  => __( 'Filter fetched videos by their duration.', WPVR_LANG ) . '<br/>' .
	           __( 'Note that this feature is only supported by Search sources and works only for Youtube, Vimeo and Dailymotion videos.', WPVR_LANG ) . '<br/>' .
	           '<em>' . __( 'This is the default setting value for all sources.', WPVR_LANG ) . '</em>',
	
	'options' => array(
		'any'    => __( 'All Videos', WPVR_LANG ),
		'short'  => __( 'Videos less than 4min.', WPVR_LANG ),
		'medium' => __( 'Videos between 4min. and 20min.', WPVR_LANG ),
		'long'   => __( 'Videos longer than 20min.', WPVR_LANG ),
	),
), $wpvr_options['videoDuration'] ); ?>

<!-- videoQuality -->
<?php wpvr_render_select_option( array(
	'tab'   => 'fetching',
	'id'    => 'videoQuality',
	'label' => __( 'Default Video Quality', WPVR_LANG ),
	'desc'  => __( 'Filter fetched videos by their video definition.', WPVR_LANG ) . '<br/>' .
	           __( 'Note that this feature is only supported by Youtube, Vimeo and Dailymotion.', WPVR_LANG ) . '<br/>' .
	           '<em>' . __( 'This is the default setting value for all sources.', WPVR_LANG ) . '</em>',
	
	'options' => array(
		'any'      => __( 'All Videos', WPVR_LANG ),
		'high'     => __( 'Only High Definition Videos', WPVR_LANG ),
		'standard' => __( 'Only Standard Definitions Videos', WPVR_LANG ),
	),
), $wpvr_options['videoQuality'] ); ?>






<!-- getFullDesc *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'fetching',
	'id'    => 'getFullDesc',
	'label' => __( 'Import Video Full Description', WPVR_LANG ),
	
    'desc'  => __( 'Choose whether to import the video full description or not.', WPVR_LANG ) . '<br/>' .
	           __( 'Turn this off to improve the plugin performances.', WPVR_LANG ),

), $wpvr_options['getFullDesc'] ); ?>


<!-- enableAsync *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'fetching',
	'id'    => 'enableAsync',
	'label' => __( 'Asynchronous Execution', WPVR_LANG ),
	'desc'  => __( 'Once enabled, this feature allows WPVR to execute several sources at once.', WPVR_LANG ) . '<br/>' .
	           __( 'Unfortunately, it does not work on all server configurations. Turn it off if you have any troubles while executing sources.', WPVR_LANG ),
), $wpvr_options['enableAsync'] ); ?>



