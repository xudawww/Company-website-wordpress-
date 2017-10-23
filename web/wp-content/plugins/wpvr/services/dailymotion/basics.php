<?php
	/* DEFINING VIDEO SERVICE BASIC DATA */

	global $wpvr_options;

	//d( $wpvr_options );

	/* Define service id */
	$vs['id'] = 'dailymotion';

	/* Define service pid ( suffix or prefix of all service variables ) */
	$vs['pid'] = 'dm';

	/* Define service label */
	$vs['label'] = 'Dailymotion';

	/* Define service icon */
	$vs['icon'] = 'dm';

	/* Define service color */
	$vs['color'] = '#0066DC';

	/* Define service api base url */
	$vs['api_base'] = '';

	/* Define service api key option name among WPVR Options */
	//$vs['api_key_name'] = 'apiKey';
	$vs['client_id_name']     = $wpvr_options['dmClientId'];
	$vs['client_secret_name'] = $wpvr_options['dmClientSecret'];


	/* Define Manual Adding Field */
	$vs['manual_id']   = 'wpvr_video_' . $vs['pid'] . 'Id';
	$vs['manual_name'] = __( 'Video ID or URL', WPVR_LANG );
	$vs['manual_desc'] = 'Example : http://www.dailymotion.com/video/<span class="wpvr_wanted_param">x3vfcx4</span>_nina-simone-2016-official-trailer-1-vo-hd_shortfilms';


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