<?php
	global
	$wpvr_default_options,
	$current_user,
	$wpvr_roles,
	$wpvr_private_cpt,
	$wpvr_post_statuses,
	$wpvr_using_cpt;
	
	$wpvr_post_statuses = apply_filters('wpvr_extend_post_statuses' , array(
		'publish'      => __( 'Published', WPVR_LANG ),
		'pending'      => __( 'Pending', WPVR_LANG ),
		'draft'      => __( 'Draft', WPVR_LANG ),
		'private'      => __( 'Private', WPVR_LANG ),
	));
	
	/* DEfault Options Values */
	$wpvr_default_options = array(
		'videoType'                   => WPVR_VIDEO_TYPE_DEFAULT,
		'timeFormat'                  => 'standard',
		'unwanted'                    => array(),
		'findBestThumbnails'          => false,
		'smoothScreen'                => true,
		'autoRunMode'                 => true,
		'adminOverride'               => true,
		'apiConnect'                  => 'wizzard',
		'sourceDeactivationThreshold' => 10,
		'getPostDate'                 => 'new',
		
		'hidePlayerTitle'       => false,
		'hidePlayerRelated'     => false,
		'hidePlayerAnnotations' => false,
		
		'getStats'              => false,
		'getTags'               => false,
		'getFullDesc'           => false,
		'onlyNewVideos'         => true,
		'orderVideos'           => 'relevance',
		'postFormat'            => 'video',
		'autoPublish'           => true,
		'postStatus'           => 'draft',
		'postAuthor'            => 1,
		'postTags'              => '',
		'addVideoType'          => true,
		'videoThumb'            => false,
		'useCronTab'            => true,
		'enableManualAdding'    => true,
		'deferAdding'           => true,
		'deferBuffer'           => 10,
		'wantedVideos'          => 3,
		'randomize'             => false,
		'randomizeStep'         => 'empty',
		'autoEmbed'             => true,
		'playerAutoPlay'        => false,
		'wakeUpHours'           => false,
		'wakeUpHoursA'          => '00',
		'wakeUpHoursB'          => '23',
		'logsPerPage'           => 100,
		'videosPerPage'         => 30,
		'restrictVideos'        => false,
		'purchaseCode'          => '',
		'apiKey'                => WPVR_DEFAULT_YOUTUBE_API_KEY,
		'voClientId'            => WPVR_VIMEO_CLIENT_ID,
		'voClientSecret'        => WPVR_VIMEO_CLIENT_SECRET,
		'dmClientSecret'        => WPVR_DAILYMOTION_CLIENT_SECRET,
		'dmClientId'            => WPVR_DAILYMOTION_CLIENT_ID,
		'timeZone'              => 'UTC',
		'enableVideoComments'   => true,
		'enableVideoControls'   => true,
		'removeVideoContent'    => false,
		'enableRewriteRule'     => false,
		'startWithServiceViews' => false,
		'permalinkBase'         => 'none',
		'customPermalinkBase'   => '',
		'enableContentSuffix'   => true,
		'contentSuffix'         => ' -- SUFFIX ',
		'enableContentPrefix'   => true,
		'contentPrefix'         => ' PREFIX -- ',
		'showMenuFor'           => $wpvr_roles['default'],
		'videoQuality'          => 'any',
		'videoDuration'         => 'any',
		'privateCPT'            => $wpvr_private_cpt,
		'postContent'           => 'on',
		'publishedAfter'        => '',
		'publishedBefore'       => '',
		'unwantOnTrash'         => false,
		'unwantOnDelete'        => true,
		'enableAsync'           => true,
		
		'downloadThumb'      => true,
		'forceExternalThumb' => true,
		
		'ecoMode'          => true,
		'ecoModeThreshold' => 50,
		'ecoModeHibernate' => 50,
		
		'autoClean'             => false,
		'autoCleanSchedule'     => 'hourly',
		'autoCleanScheduleTime' => '',
		'autoCleanScheduleDay'  => '',
	
	);
	
	
	/* Getting WP Options to SGD */
	
	$wpvr_cron_token   = get_option( 'wpvr_cron_token' );
	$wpvr_options      = get_option( 'wpvr_options' );
	$wpvr_activation   = get_option( 'wpvr_activation' );
	$wpvr_deferred     = get_option( 'wpvr_deferred' );
	$wpvr_deferred_ids = get_option( 'wpvr_deferred_ids' );
	$wpvr_notices      = get_option( 'wpvr_notices' );
	$wpvr_unwanted     = get_option( 'wpvr_unwanted' );
	$wpvr_unwanted_ids = get_option( 'wpvr_unwanted_ids' );
	$wpvr_imported     = get_option( 'wpvr_imported' );
	
	
	//wpvr_ooo( $wpvr_imported );
	if ( $wpvr_notices == '' ) {
		$wpvr_notices = array();
	}
	/* Define Sanbox */
	if ( ! defined( 'WPVR_ENABLE_SANDBOX' ) ) {
		define( 'WPVR_ENABLE_SANDBOX', false );
	}
	
	
	if ( ! defined( 'WPVR_ENABLE_YOUTUBE' ) ) {
		define( 'WPVR_ENABLE_YOUTUBE', true );
	}
	if ( ! defined( 'WPVR_ENABLE_VIMEO' ) ) {
		define( 'WPVR_ENABLE_VIMEO', true );
	}
	if ( ! defined( 'WPVR_ENABLE_DAILYMOTION' ) ) {
		define( 'WPVR_ENABLE_DAILYMOTION', true );
	}
	
	//Trying to optimize execution time if safemode is not enabled
	if ( defined( 'WPVR_MAX_EXECUTION_TIME' ) && WPVR_MAX_EXECUTION_TIME ) {
		@ini_set( 'max_execution_time', WPVR_MAX_EXECUTION_TIME );
	}
	
	/* defining $wpvr_options */
	if (
		( is_bool( $wpvr_options ) && $wpvr_options === false )
		|| $wpvr_options == ''
		|| $wpvr_options == null
	) {
		update_option( 'wpvr_options', $wpvr_default_options );
		$wpvr_options = $wpvr_default_options;
	}
	
	$wpvr_options = wpvr_extend( $wpvr_options, $wpvr_default_options );
	
	/* DEfining $wpvr_deferred */
	if ( is_bool( $wpvr_deferred ) && $wpvr_deferred === false ) {
		update_option( 'wpvr_deferred', array() );
	}
	if ( is_bool( $wpvr_unwanted ) && $wpvr_unwanted === false ) {
		update_option( 'wpvr_unwanted', array() );
	}
	
	if ( is_bool( $wpvr_unwanted_ids ) && $wpvr_unwanted_ids === false ) {
		update_option( 'wpvr_unwanted_ids', array() );
	}
	
	if ( $wpvr_cron_token == '' ) {
		$wpvr_cron_token = md5( uniqid( rand(), true ) );
		update_option( 'wpvr_cron_token', $wpvr_cron_token );
	}
	
	
	// Defining default timezone
	//d( $wpvr_options[ 'timeZone' ] );
	// if ( is_array( $wpvr_options['timeZone'] ) && isset( $wpvr_options['timeZone'][1] ) ) {
	// 	date_default_timezone_set( $wpvr_options['timeZone'][1] );
	// } else {
	// 	date_default_timezone_set( 'UTC' );
	// }
	
	$wpvr_addons = array();
	
	define( 'WPVR_VIDEO_TYPE', apply_filters( 'wpvr_extend_videos_post_type', $wpvr_options['videoType'] ) );
	
	$wpvr_using_cpt = '
                            <span class="wpvr_using_post_type">
                                ' . sprintf( __( 'Using the %s post type', WPVR_LANG ), '<strong>' . WPVR_VIDEO_TYPE . '</strong>' ) . '
                            </span>
                            ';
	
	