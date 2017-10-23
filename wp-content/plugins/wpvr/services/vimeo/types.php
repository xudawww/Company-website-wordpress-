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

	/* Define Group Type */
	$type_id                 = 'group' . $pid_suffix;
	$vs['types'][ $type_id ] = array(
		'id'     => $type_id,
		'global_id' => 'group_',
		'label'  => 'Group',
		'icon'   => 'fa-users',
		'color'  => $vs['color'],
		'subheader'  => true,
		'subdata_function'  => 'get_group_data',
		'multiplicate'  => false,
		'param' => 'groupId' . $pid_suffix,
		'fields' => array(
			//Group Type Field
			array(
				'id'          => 'groupId' . $pid_suffix,
				'type'        => 'text',
				'name'        => __( 'Group Id',  WPVR_LANG  ),
				'desc'        =>  'Example: https://vimeo.com/groups/<span class="wpvr_wanted_param">motion</span>',
				'wpvrService' => $vs['id'],
				'wpvrType'    => $type_id,
			),
		),
	);



	/* Define CHANNEL Type */
	$type_id                 = 'channel' . $pid_suffix;
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
	);

	/* Define USER Type */
	$type_id                 = 'user' . $pid_suffix;
	$vs['types'][ $type_id ] = array(
		'id'     => $type_id,
		'global_id' => 'user',
		'label'  => 'User',
		'icon'   => 'fa-user',
		'color'  => $vs['color'],
		'subheader'  => true,
		'subdata_function'  => 'get_user_data',
		'multiplicate'  => false,
		'param' => 'userId' . $pid_suffix,
		'fields' => array(
			//Group Type Field
			array(
				'id'          => 'userId' . $pid_suffix,
				'type'        => 'text',
				'name'        => __( 'Username',  WPVR_LANG  ) ,
				'desc'        =>  'Example: https://vimeo.com/<span class="wpvr_wanted_param">derekmccoy</span>',
				'wpvrService' => $vs['id'],
				'wpvrType'    => $type_id,
			),
		),
	);

	/* Define USER Type */
	$type_id                 = 'videos' . $pid_suffix;
	$vs['types'][ $type_id ] = array(
		'id'     => $type_id,
		'global_id' => 'videos',
		'label'  => 'Videos',
		'icon'   => 'fa-film',
		'color'  => $vs['color'],
		'subheader'  => false,
		'subdata_function'  => false,
		'multiplicate'  => false,
		'param' => 'videoId' . $pid_suffix,
		'fields' => array(
			//Group Type Field
			array(
				'id'          => 'videoId' . $pid_suffix,
				'type'        => 'text',
				'name'        => __( 'Video Id',  WPVR_LANG  ) ,
				'desc'        => 'Example: http://vimeo.com/<span class="wpvr_wanted_param">136531110</span><br/>' ,
				'wpvrService' => $vs['id'],
				'wpvrType'    => $type_id,
			),
		),
	);

