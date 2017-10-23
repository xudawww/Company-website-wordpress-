<?php
	/* DEFINING VIDEO SERVICE BASIC DATA */

	global $wpvr_options;

	/* Define service id */
	$vs['id'] = 'youku';

	/* Define service pid ( suffix or prefix of all service variables ) */
	$vs['pid'] = 'yk';

	/* Define service label */
	$vs['label'] = 'Youku';

	/* Define service icon */
	$vs['icon'] = 'yk';

	/* Define service color */
	//$vs['color'] = '#EF3F22';
	$vs['color'] = '#EF8C22';

	/* Define service api base url */
	$vs['api_base'] = 'https://openapi.youku.com/v2/';

	/* Define service api key option name among WPVR Options */
	//$vs['api_key_name'] = 'apiKey';

	$vs['client_id_name'] = $slot['client_id'];
	$vs['client_secret_name'] = $slot['client_secret'];



	/* Define Manual Adding Field */
	$vs['manual_id'] = 'wpvr_video_'.$vs['pid'].'Id';
	$vs['manual_name'] = __('Youku Video ID', WPVR_LANG ) ;
	$vs['manual_desc'] = 'Example : http://v.youku.com/v_show/id_<span class="wpvr_wanted_param">XNjU1NDU5NTQw</span>.html';


	$vs['force_credentials'] = true ;

	/* Dynamically define prefix/suffix */
	$pid_suffix = ( $vs['pid'] != '' ) ? '_' . $vs['pid'] : '';
	$pid_prefix = ( $vs['pid'] != '' ) ? $vs['pid'] . '_' : '';

	$vs[ 'msgs' ] = array();

	// Authentication error
	$vs[ 'msgs' ][ 'authentication_error' ] = '' .
		sprintf( __( 'The API Access to %s is not granted.' , WPVR_LANG ) , strtoupper( $vs[ 'label' ] ) ) . '<br/>' .
		'<a href="' . admin_url( 'admin.php?page=wpvr-options&section=api_keys' ) . '" target="_blank">' .
		__( 'Click here to grant access to this service.' , WPVR_LANG ) .
		'</a><br/>';

	$vs[ 'msgs' ][ 'obsolete_access' ] = '' .
		sprintf( __( 'The API Access to %s is no longer valid.' , WPVR_LANG ) , strtoupper( $vs[ 'label' ] ) ) . '<br/>' .
		'<a href="' . admin_url( 'admin.php?page=wpvr-options&section=api_keys' ) . '" target="_blank">' .
		__( 'Click here to grant access to this service.' , WPVR_LANG ) .
		'</a><br/>';

	$vs[ 'msgs' ][ 'quota_exceeded' ] = '' .
		sprintf( __( 'You have exceeded the quota for this %s credentials.' , WPVR_LANG ) , strtoupper( $vs[ 'label' ] ) ) . '<br/>' .
		sprintf( __( 'You are probably using the default plugin %s credentials. You should create your own.' , WPVR_LANG ) , strtoupper( $vs[ 'label' ] ) ) . '<br/>' .
		'<a href="<?php echo WPVR_SUPPORT_URL; ?>/tutorials/where-to-find-youtube-api-key/" target="_blank">' .
		__( 'Just follow this tutorial steps.' , WPVR_LANG ) .
		'</a><br/>';
	$vs[ 'msgs' ][ 'bad_credentials' ] = '' .
		sprintf( __( 'Make sure your %s API Client ID and Client Secret are correct.' , WPVR_LANG ) , strtoupper( $vs[ 'label' ] ) ) . '<br/>';

	$vs[ 'msgs' ][ 'api_error' ] = '' .
		sprintf( __( 'Oups! Something went wrong with the %s API. Try again later.' , WPVR_LANG ) , strtoupper( $vs[ 'label' ] ) ) .
		'<br/>';

	$vs[ 'msgs' ][ 'video_not_found' ] = '' .
		sprintf( __( 'There is no %s video corresponding to the video ID you provided.' , WPVR_LANG ) , strtoupper( $vs[ 'label' ] ) ) .
		'';

	$vs[ 'msgs' ][ 'import_success' ] = '' .
		__( 'Video found and data imported.' , WPVR_LANG );