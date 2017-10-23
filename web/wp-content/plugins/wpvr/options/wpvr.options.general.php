<?php
	
	global $wpvr_roles;

?>

<!-- timeZone -->
<?php wpvr_render_hybrid_option( array(
	'tab'        => 'general',
	'id'         => 'timeZone',
	'label'      => __( 'Default Time Zone', WPVR_LANG ),
	'desc'       => __( 'Choose the timezone that should be used for scheduling your sources and on the WPVR Activity Logs screen.', WPVR_LANG ).
                    '<br/>'. __( 'Important: Make sure you use the same timezone as defined under WordPress General Settings.', WPVR_LANG ),
	'render_fct' => function () {
		global $wpvr_timezones, $wpvr_options;
		$wpvr_timezones_array = array();
		foreach ( (array) $wpvr_timezones as $g => $gZone ) {
			foreach ( (array) $gZone as $gValue => $gLabel ) {
				$wpvr_timezones_array[ $gValue ] = str_replace('_' , ' ' , $gLabel );
			}
		}
		
		wpvr_render_selectized_field( array(
			'name'        => 'timeZone',
			'placeholder' => __( 'Pick your timezone', WPVR_LANG ),
			'values'      => $wpvr_timezones_array,
			'maxItems'    => 1,
		
		), $wpvr_options['timeZone'] );
	},
), $wpvr_options['timeZone'] ); ?>

<!-- timeFormat -->
<?php wpvr_render_select_option( array(
	'tab'     => 'general',
	'id'      => 'timeFormat',
	'label'   => __( 'Default Time Format', WPVR_LANG ),
	'desc'    => __( 'Choose the time format that should be used to print time.', WPVR_LANG ),
	'options' => array(
		'standard' => __( '24H Standard Time Format', WPVR_LANG ),
		'us'       => __( '12H US Time Format', WPVR_LANG ),
	),
), $wpvr_options['timeFormat'] ); ?>


<!-- enableManualAdding -->
<!-- @deprecated since v1.8.10 -->
<?php if ( false ) { ?>
	<?php wpvr_render_switch_option( array(
		'tab'   => 'general',
		'id'    => 'enableManualAdding',
		'label' => __( 'Enable manual video adding', WPVR_LANG ),
		'desc'  => __( 'Enable grabbing a single video by its id.', WPVR_LANG ),
	), $wpvr_options['enableManualAdding'] ); ?>
<?php } ?>

<!-- restrictVideos *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'general',
	'id'    => 'restrictVideos',
	'label' => __( 'Restrict videos to their authors', WPVR_LANG ),
	'desc'  => __( 'Enable this option to restrict imported videos to their respective authors and to the site administrators.', WPVR_LANG ),
), $wpvr_options['restrictVideos'] ); ?>


<!-- unwantOnTrash *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'general',
	'id'    => 'unwantOnTrash',
	'label' => __( 'Auto unwant after trashing videos', WPVR_LANG ),
	'desc'  => __( 'Turn this option to automatically flag a video as unwanted when trashing it.', WPVR_LANG ) . '<br/>' .
	           __( 'That way the plugin will skip it on next video import operations.', WPVR_LANG ),
), $wpvr_options['unwantOnTrash'] ); ?>

<!-- unwantOnDelete *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'general',
	'id'    => 'unwantOnDelete',
	'label' => __( 'Auto unwant after deleting videos', WPVR_LANG ),
	'desc'  => __( 'Turn this option to automatically flag a video as unwanted when deleting them permanently.', WPVR_LANG ) . '<br/>' .
	           __( 'That way the plugin will skip it on next video import operations.', WPVR_LANG ),

), $wpvr_options['unwantOnDelete'] ); ?>


<!-- logsPerPage *** -->
<?php wpvr_render_input_option( array(
	'tab'   => 'general',
	'id'    => 'logsPerPage',
	'class' => 'small',
	'label' => __( 'Logs per page', WPVR_LANG ),
	'desc'  => __( 'Define here the number of log lines to display per page on the Activity Logs screen.', WPVR_LANG ),
), $wpvr_options['logsPerPage'] ); ?>

<!-- videosPerPage *** -->
<?php wpvr_render_input_option( array(
	'c'     => 'general',
	'id'    => 'videosPerPage',
	'class' => 'small',
	'label' => __( 'Videos per page', WPVR_LANG ),
	'desc'  => __( 'Define here the number of videos to display per page.', WPVR_LANG ) . '<br/>' .
	           __( 'This works on Manage Videos, Duplicate Videos, Deferred Videos, Unwanted Videos screens.', WPVR_LANG ),
), $wpvr_options['videosPerPage'] ); ?>


<!-- smoothScreen *** -->
<?php wpvr_render_switch_option( array(
	'tab'   => 'general',
	'id'    => 'smoothScreen',
	'label' => __( 'WPVR Screens FadeIn', WPVR_LANG ),
	'desc'  => __( 'Choose whether to use a fancy fade in animation on all WPVR screens.', WPVR_LANG ) . '<br/>' .
	           __( 'Turn off this option if you do encounter errors.' ),
), $wpvr_options['smoothScreen'] ); ?>

<!-- timeZone -->
<?php wpvr_render_hybrid_option( array(
	'tab'        => 'general',
	'id'         => 'showMenuFor',
	'label'      => __( 'User roles with enabled WPVR links', WPVR_LANG ),
	'desc'       => __( 'Pick here which user roles should have WPVR menu links enabled.', WPVR_LANG ) . '<br/>' .
	                __( 'Leave it empty to allow all user roles to access all WPVR screens.', WPVR_LANG ),
	'render_fct' => function () {
		global $wpvr_roles, $wpvr_options;
		wpvr_render_selectized_field( array(
			'name'        => 'showMenuFor',
			'placeholder' => __( 'Pick one or more user roles.', WPVR_LANG ),
			'values'      => $wpvr_roles['available'],
			'maxItems'    => 10,
		
		), $wpvr_options['showMenuFor'] );
	},
), $wpvr_options['showMenuFor'] ); ?>
