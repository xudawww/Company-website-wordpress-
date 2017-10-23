<?php

	/* Defining types */
	$vs['types'] = array();

	/* Define Search Type */
	$type_id                 = 'search' . $pid_suffix;
	$vs['types'][ $type_id ] = array(
		'id'     => $type_id,
		'global_id' => 'search',
		'label'  => 'Search',
		'icon'   => 'fa-search',
		'color'  => $vs['color'],
		'subheader'  => false,
		'subdata_function'  => false,
		'multiplicate'  => false,
		'param' => 'searchTerm' . $pid_suffix,
		'fields' => array(
			//Search Terms Field
			array(
				'id'          => 'searchTerm' . $pid_suffix,
				'type'        => 'textarea_small',
				'name'        => __( 'Search Terms', WPVR_LANG ),
				'desc'        => '',
				'wpvrService' => $vs['id'],
				'wpvrType'    => $type_id,
			),
		),
	);

	/* Define Trends Type */
	global $wpvr_countries ;
	$type_id                 = 'trends' . $pid_suffix;
	$vs['types'][ $type_id ] = array(
		'id'     => $type_id,
		'global_id' => 'trends',
		'label'  => 'Trends',
		'icon'   => 'fa-trophy',
		'color'  => $vs['color'],
		'subheader'  => true,
		'subdata_function'  => 'get_trends_data',
		'multiplicate'  => false,
		'param' => 'regionCode' . $pid_suffix,
		'fields' => array(
			//Trends Fields
			array(
				'id'          => 'regionCode' . $pid_suffix,
				'type'        => 'select',
				'name'        => __( 'Country', WPVR_LANG ),
				'desc'        => '',
				'default'     => '',
				'options'     => $wpvr_countries,
				'wpvrType'    => $type_id,
				'wpvrService' => $vs['id'],
				'wpvrStyle'   => $vs['id'],
			),
		),
	);

	/* Define Playlist Type */
	$type_id                 = 'playlist' . $pid_suffix;
	$vs['types'][ $type_id ] = array(
		'id'     => $type_id,
		'global_id' => 'playlist',
		'label'  => 'Playlists',
		'icon'   => 'fa-play-circle',
		'color'  => $vs['color'],
		'subheader'  => true,
		'subdata_function'  => 'get_playlist_data',
		'multiplicate'  => false,
		'param' => 'playlistId' . $pid_suffix,
		'fields' => array(
			array(
				'name'         => __( 'Playlist Id', WPVR_LANG ),
				'desc'         => 'Example: http://www.dailymotion.com/playlist/<span class="wpvr_wanted_param">x37u4</span>_curtis-circus_anim/1#video=x2ed0b <br/>'.
				                  __('Single Playlist ID', WPVR_LANG ) ,
				'id'           => 'playlistId' . $pid_suffix,
				'type'         => 'text',
				'wpvrType'     => $type_id,
				'wpvrService'  => $vs['id'],
				//'hidden_field' => true,
			),
		)
	);

	/* Define Channel Type */
	$type_id                 = 'channel' . $pid_suffix;
	$vs['types'][ $type_id ] = array(
		'id'     => $type_id,
		'global_id' => 'channel',
		'label'  => 'Channels',
		'icon'   => 'fa-desktop',
		'color'  => $vs['color'],
		'subheader'  => true,
		'subdata_function'  => 'get_channel_data',
		'param' => 'channelId' . $pid_suffix,
		'multiplicate'  =>false,
		'fields' => array(
			array(
				'name'         => __( 'Channel Id', WPVR_LANG ),
				'desc'         => 'Example: http://www.dailymotion.com/user/<span class="wpvr_wanted_param">cromme</span>/1<br/>' .
				                  __('On Dailymotion, the channel Id is its owner username.', WPVR_LANG ),
				'id'           => 'channelId' . $pid_suffix,
				'type'         => 'text',
				'wpvrType'     => $type_id,
				'wpvrService'  => $vs['id'],
			),
		)

	);

	/* Define Videos Type */
	$type_id                 = 'videos' . $pid_suffix;
	$vs['types'][ $type_id ] = array(
		'id'     => $type_id,
		'global_id' => 'videos',
		'label'  => 'Videos',
		'icon'   => 'fa-film',
		'color'  => $vs['color'],
		'subheader'  => false,
		'subdata_function'  => false,
		'param'  =>  'videoId' . $pid_suffix,
		'fields' => array(
			array(
				'name'         => __( 'Video Id', WPVR_LANG ),
				'desc'         =>'Example: http://www.dailymotion.com/video/<span class="wpvr_wanted_param">x25uztu</span>_serebro-malo-tebya_music<br/>' ,
				'id'           => 'videoId' . $pid_suffix,
				'type'         => 'text',
				'wpvrType'     => $type_id,
				'wpvrService'  => $vs['id'],
			),

		)
	);