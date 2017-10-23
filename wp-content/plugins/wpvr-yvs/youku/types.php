<?php

	/* Defining types */
	$vs[ 'types' ] = array();

	/* Define Search Type */
	$type_id                   = 'search' . $pid_suffix;
	$vs[ 'types' ][ $type_id ] = array(
		'id'               => $type_id ,
		'global_id'        => 'search' ,
		'label'            => 'Search' ,
		'icon'             => 'fa-search' ,
		'color'            => $vs[ 'color' ] ,
		'subheader'        => FALSE ,
		'subdata_function' => FALSE ,
		'multiplicate'     => FALSE ,
		'param'            => 'searchTerm' . $pid_suffix ,
		'fields'           => array(
			//Search Terms Field
			array(
				'id'          => 'searchTerm' . $pid_suffix ,
				'type'        => 'textarea_small' ,
				'name'        => __( 'Search Terms' , WPVR_LANG ) ,
				'desc'        => '' ,
				'wpvrService' => $vs[ 'id' ] ,
				'wpvrType'    => $type_id ,
			) ,
		) ,
	);

	/* Define Group Type */
	$type_id                   = 'playlist' . $pid_suffix;
	$vs[ 'types' ][ $type_id ] = array(
		'id'               => $type_id ,
		'global_id'        => 'playlist' ,
		'label'            => 'Playlist' ,
		'icon'             => 'fa-play-circle' ,
		'color'            => $vs[ 'color' ] ,
		'subheader'        => TRUE ,
		'subdata_function' => 'get_playlist_data' ,
		'multiplicate'     => FALSE ,
		'param'            => 'playlistId' . $pid_suffix ,
		'fields'           => array(
			//Group Type Field
			array(
				'id'          => 'playlistId' . $pid_suffix ,
				'type'        => 'text' ,
				'name'        => __( 'Playlist Id' , WPVR_LANG ) ,
				'desc'        => 'Example: http://www.youku.com/playlist_show/id_<span class="wpvr_wanted_param">6450536</span>.htm' ,
				'wpvrService' => $vs[ 'id' ] ,
				'wpvrType'    => $type_id ,
			) ,
		) ,
	);


	/* Define CHANNEL Type */
	/*$type_id                 = 'channel' . $pid_suffix;
	$vs['types'][ $type_id ] = array(
		'id'     => $type_id,
		'global_id' => 'channel',
		'label'  => 'Channel',
		'icon'   => 'fa-desktop',
		'color'  => $vs['color'],
		'subheader'  => true,
		'subdata_function'  => 'get_channel_data',
		'multiplicate'  => false,
		'param' => 'channelId' . $pid_suffix,
		'fields' => array(
			//Group Type Field
			array(
				'id'          => 'channelId' . $pid_suffix,
				'type'        => 'text',
				'name'        => __( 'Channel Id',  WPVR_LANG  ) ,
				'desc'        =>  'Example: https://vimeo.com/channels/<span class="wpvr_wanted_param">staffpicks</span>',
				'wpvrService' => $vs['id'],
				'wpvrType'    => $type_id,
			),
		),
	);*/


	/* Define USER Type */
	$type_id                   = 'user' . $pid_suffix;
	$vs[ 'types' ][ $type_id ] = array(
		'id'               => $type_id ,
		'global_id'        => 'user' ,
		'label'            => 'User' ,
		'icon'             => 'fa-user' ,
		'color'            => $vs[ 'color' ] ,
		'subheader'        => TRUE ,
		'subdata_function' => 'get_user_data' ,
		'multiplicate'     => FALSE ,
		'param'            => 'userId' . $pid_suffix ,
		'fields'           => array(

			array(
				'id'          => 'userType' . $pid_suffix ,
				'type'        => 'select' ,
				'name'        => __( 'Parameter Type' , WPVR_LANG ) ,
				'desc'        => 'Choose whether to get user videos by user ID or username.' ,
				'wpvrService' => $vs[ 'id' ] ,
				'wpvrType'    => $type_id ,
				'options'     => array(
					'userid'   => __( 'User ID' , WPVR_LANG ) ,
					'username' => __( 'Username' , WPVR_LANG ) ,
				) ,
				'default'     => 'username' ,
			) ,

			//Group Type Field
			array(
				'id'          => 'userId' . $pid_suffix ,
				'type'        => 'text' ,
				'name'        => __( 'Username' , WPVR_LANG ) .' / '. __( 'User ID' , WPVR_LANG ),
				'desc'        => 'Username in plain text, Ex : <span class="wpvr_wanted_param">heyivideo</span><br/>
								OR User ID, Ex : <span class="wpvr_wanted_param">UMjgxODQzODMy</span><br/>
								  ' ,
				'wpvrService' => $vs[ 'id' ] ,
				'wpvrType'    => $type_id ,
				'wpvrClass'    => ' noborder ' ,
			) ,
		) ,
	);

	/* Define USER Type */
	$type_id                   = 'videos' . $pid_suffix;
	$vs[ 'types' ][ $type_id ] = array(
		'id'               => $type_id ,
		'global_id'        => 'videos' ,
		'label'            => 'Videos' ,
		'icon'             => 'fa-film' ,
		'color'            => $vs[ 'color' ] ,
		'subheader'        => FALSE ,
		'subdata_function' => FALSE ,
		'multiplicate'     => FALSE ,
		'param'            => 'videoIds' . $pid_suffix ,
		'fields'           => array(
			array(
				'name'            => __( 'Videos Ids' , WPVR_LANG ) .
				                     '<br/><div class="wpvr_count_videos wpvr_count_items" ></div>' ,
				'desc'            => 'Example: http://v.youku.com/v_show/id_<span class="wpvr_wanted_param">XODc4MzE0MjI0</span>.html?f=23535457<br/>' .
				                     __( 'List of video IDs separated by commas.' , WPVR_LANG ) ,
				'id'              => 'videoIds' . $pid_suffix ,
				'type'            => 'textarea' ,
				'wpvrType'        => $type_id ,
				'wpvrService'     => $vs[ 'id' ] ,
				'wpvrClass'       => 'countMyItems' ,
				'wpvr_attributes' => array(
					'listener' => 'videoIds' . $pid_suffix ,
				) ,

			) ,
		) ,
	);

