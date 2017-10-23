<?php
	require_once( 'functions.api.php' );
	
	/* Inject Service Styles */
	$vs['get_styles'] = function () use ( $vs, $pid_suffix ) {
		$vs_id    = $vs['id'];
		$vs_color = $vs['color'];
		$styles
		          = "
			.wpvr_service_icon.$vs_id{ background-color:$vs_color;}\n
			.wpvr_video_author.$vs_id{ background-color:$vs_color;}\n
            .wpvr_source_icon_right.$vs_id{ background-color:$vs_color;}\n
            .wpvrArgs[service=$vs_id] , .wpvr_source_icon[service=$vs_id]{ border-color:$vs_color;}\n
		";
		
		return $styles;
	};
	
	/* Embed Video */
	$vs['video_embed'] = function ( $videoID, $post_id = '', $autoPlay = true, $add_styles = false, $player_args = array(), $player_attributes = array() ) use ( $vs, $pid_suffix ) {
		global $wpvr_options, $wpvr_dynamics;
		
		$player_width  = '100%';
		$player_height = '459';
		$player_styles = '';
		
		if ( $add_styles === true ) {
			$player_styles = ' position:absolute !important;top:0 !important;left:0 !important;width:100% !important;height:100% !important; ';
		}
		
		
		if ( $wpvr_dynamics['player_tags']['force_autoplay_disable'] === true ) {
			$autoPlay = false;
		}
		
		$player_classes = implode( ' ', $wpvr_dynamics['player_classes'] );
		
		$player_args = wpvr_extend( $player_args, array(
			'api'       => '1',
			'player_id' => 'wpvr_player_' . $post_id,
			'title'     => '0',
			'byline'    => '0',
			'portrait'  => '0',
			'color'     => 'ffffff',
			'autoplay'  => ( $autoPlay === true ? 1 : 0 ),
		) );
		// if (
		// 	isset( $wpvr_dynamics['player_options'][ $vs['id'] ] )
		// 	&& is_array( $wpvr_dynamics['player_options'][ $vs['id'] ] )
		// ) {
		// 	$player_args = wpvr_extend( $player_args, $wpvr_dynamics['player_options'][ $vs['id'] ] );
		// }
		
		
		$player_src = '//player.vimeo.com/video/' . $videoID . '?' . http_build_query( $player_args, '&amp;' );
		
		$player_attributes = wpvr_extend( $player_attributes, array(
			'video_id'              => $videoID,
			'style'                 => $player_styles,
			'class'                 => ' wpvr_iframe vimeo ' . $player_classes,
			'id'                    => 'wpvr_iframe_' . $videoID,
			'width'                 => $player_width,
			'height'                => $player_height,
			'src'                   => $player_src,
			'frameborder'           => "0",
			'webkitallowfullscreen' => "",
			'mozallowfullscreen'    => "",
			'allowfullscreen'       => "",
		) );
		
		
		$player = '<iframe ' . wpvr_render_html_attributes( $player_attributes ) . ' ></iframe>';
		
		return $player;
	};
	
	/* GET DATA */
	$vs['get_trends_data'] = function ( $param = null ) use ( $vs, $pid_suffix ) {
		return false;
	};
	
	/* GET YOUTUBE CHANNEL DATA */
	$vs['get_channel_data'] = function ( $param = null ) use ( $vs, $pid_suffix ) {
		
		$api_handle = $vs['api_auth']();
		if ( $api_handle === false ) {
			return false;
		}
		
		$api_endpoint = '/channels/' . $param;
		$api_args     = array();
		$api_response = wpvr_object_to_array( $api_handle->request( $api_endpoint, $api_args ) );
		//$api_response = $api_handle->request( $api_endpoint, $api_args );
		
		if ( isset( $api_response['status'] ) && $api_response['status'] != '200' ) {
			return false;
		}
		
		return array(
			'name'    => $api_response['body']['name'],
			'thumb'   => $api_response['body']['pictures']['sizes'][1]['link'],
			'thumbHQ' => $api_response['body']['pictures']['sizes'][3]['link'],
		);
	};
	
	/* GET YOUTUBE PLAYLIST DATA */
	$vs['get_group_data'] = function ( $param = null ) use ( $vs, $pid_suffix ) {
		
		$api_handle = $vs['api_auth']();
		if ( $api_handle === false ) {
			return false;
		}
		
		$api_endpoint = '/groups/' . $param;
		$api_args     = array();
		$api_response = $api_handle->request( $api_endpoint, $api_args );
		$api_response = wpvr_object_to_array( $api_response );
		
		//d( $api_args );d( $api_endpoint );d( $api_response );
		return array(
			'name'    => $api_response['body']['name'],
			'thumb'   => $api_response['body']['pictures']['sizes'][1]['link'],
			'thumbHQ' => $api_response['body']['pictures']['sizes'][3]['link'],
		);
	};
	
	
	/* GET YOUTUBE PLAYLIST DATA */
	$vs['get_user_data'] = function ( $param = null ) use ( $vs, $pid_suffix ) {
		
		$api_handle = $vs['api_auth']();
		if ( $api_handle === false ) {
			return false;
		}
		
		$api_endpoint = '/users/' . $param;
		$api_args     = array();
		$api_response = $api_handle->request( $api_endpoint, $api_args );
		$api_response = wpvr_object_to_array( $api_response );
		
		//d( $api_args );d( $api_endpoint );d( $api_response );
		return array(
			'name'    => $api_response['body']['name'],
			'thumb'   => $api_response['body']['pictures']['sizes'][1]['link'],
			'thumbHQ' => $api_response['body']['pictures']['sizes'][3]['link'],
		);
	};
	
	
	/* Render Subheader */
	$vs['render_subheader'] = function ( $source = null ) use ( $vs, $pid_suffix ) {
		$source_type = $source->type;
		$vs_type     = $vs['types'][ $source_type ];
		if ( $vs_type['subheader'] === false ) {
			return '';
		}
		if ( $vs_type['subdata_function'] === false ) {
			return '';
		}
		
		$sub_data = $vs[ $vs_type['subdata_function'] ]( $source->{$vs_type['param']} );
		if ( $sub_data === false ) {
			return '';
		}
		
		$output = '';
		if ( $vs_type['global_id'] == 'trends' ) {
			$output = '';
		} elseif ( $sub_data != false ) {
			$output
				= '
				<div class="wpvr_subsource">
					<div class="wpvr_subsource_thumb ' . $vs_type['global_id'] . '">
						<img src="' . $sub_data['thumb'] . '" alt="' . $sub_data['name'] . '" />
					</div>
					<div class="wpvr_subsource_name ' . $vs_type['global_id'] . '">
						' . $sub_data['name'] . '
					</div>
					<div class="wpvr_clearfix"></div>
				</div>
			';
		}
		
		
		return $output;
	};
	
	/* Get Video Tags */
	$vs['get_video_tags'] = function ( $videoId ) use ( $vs, $pid_suffix ) {
		return array();
	};
	
	/* GEt Video Stats */
	$vs['get_video_stats'] = function ( $videosFound, $options ) use ( $vs, $pid_suffix ) {
		return $videosFound;
	};
	
	/* Get Single Video Data */
	$vs['get_single_video_data'] = function ( $video_id ) use ( $vs, $pid_suffix ) {
		
		$api_handle = $vs['api_auth']();
		if ( $api_handle === false ) {
			wpvr_add_notice( array(
				'title'     => 'WP Video Robot ERROR :',
				'class'     => 'error', //updated or warning or error
				'content'   => $vs['msgs']['authentication_error'],
				'hidable'   => false,
				'is_dialog' => false,
				'show_once' => true,
			) );
			
			return false;
		}
		
		$vimeo_endpoint = '/videos/' . $video_id . '';
		$vimeo_args     = array();
		$api_response   = $api_handle->request( $vimeo_endpoint, $vimeo_args );
		$api_response   = wpvr_object_to_array( $api_response );
		//d( $vimeo_args );
		//d( $vimeo_endpoint );
		//d( $api_response );
		
		
		// No items Found
		if ( $api_response['status'] != '200' ) {
			wpvr_add_notice( array(
				'title'     => 'WP Video Robot ERROR :',
				'class'     => 'error', //updated or warning or error
				'content'   => $vs['msgs']['video_not_found'],
				'hidable'   => false,
				'is_dialog' => false,
				'show_once' => true,
			) );
			
			return false;
		}
		
		//d( $api_response['body'] );
		
		$nDate            = new DateTime( $api_response['body']['created_time'] );
		$originalPostDate = $nDate->format( 'Y-m-d H:i:s' );
		$metas            = array(
			'id'               => $video_id,
			'service'          => 'vimeo',
			'url'              => $api_response['body']['link'],
			'desc'             => $api_response['body']['description'],
			'title'            => $api_response['body']['name'],
			'duration'         => 'PT' . $api_response['body']['duration'] . 'S',
			'views'            => $api_response['body']['stats']['plays'],
			'thumb'            => $api_response['body']['pictures']['sizes'][3]['link'],
			'hqthumb'          => $api_response['body']['pictures']['sizes'][3]['link'],
			'icon'             => $api_response['body']['pictures']['sizes'][1]['link'],
			'likes'            => 0,
			'dislikes'         => 0,
			'originalPostDate' => $originalPostDate,
			'tags'             => array(),
		);
		
		foreach ( (array) $api_response['body']['tags'] as $tagItem ) {
			$metas['tags'][] = $tagItem['tag'];
		}
		if (
			is_array( $api_response['body']['user']['pictures']['sizes'] )
			&& count( $api_response['body']['user']['pictures']['sizes'] ) != 0
		) {
			$thumb     = array_pop( $api_response['body']['user']['pictures']['sizes'] );
			$thumbnail = $thumb['link'];
		} else {
			$thumbnail = '';
		}
		$metas['author'] = array(
			'id'        => str_replace( '/users/', '', $api_response['body']['user']['uri'] ),
			'title'     => $api_response['body']['user']['name'],
			'title_cut' => $api_response['body']['user']['name'],
			'thumbnail' => $thumbnail,
			'link'      => $api_response['body']['user']['link'],
		);
		
		//d( $metas );
		
		return $metas;
	};
	
	
	/* Fetch Videos */
	$vs_vm                 = $vs;
	$vs_vm['fetch_videos'] = function ( $videosFound, $options, $oldVideos ) use ( &$vs_vm, $pid_suffix ) {
		global $preDuplicates;
		global $default_videosFound, $default_fetching_options;
		
		//$default_videosFound[ 'nextPageToken' ] = '1';
		
		//Default variables
		$default_fetching_options = wpvr_prepare_sOptions_fields( $default_fetching_options, null, $default = true );
		$videosFound              = wpvr_extend( $videosFound, $default_videosFound );
		$options                  = wpvr_extend( $options, $default_fetching_options );
		
		
		if ( $videosFound['nextPageToken'] == '' ) {
			$videosFound['nextPageToken'] = '1';
		}
		
		
		$api_handle = $vs_vm['api_auth']();
		//d( $api_handle );
		if ( $api_handle === false ) {
			return $videosFound;
		}
		
		if ( $options['how']['onlyNewVideos'] == 'on' ) {
			$options['how']['onlyNewVideos'] = true;
		} else {
			$options['how']['onlyNewVideos'] = false;
		}
		
		
		if ( $videosFound['execTime'] == '' ) {
			$videosFound['execTime'] = microtime( true );
		}
		
		
		$vs_type = $vs_vm['types'][ $options['what']['mode'] ];
		
		$api_endpoint = '/';
		$api_args     = array(
			'page'      => $videosFound['nextPageToken'],
			'per_page'  => 50,
			//'filter'=> 'embeddable' ,
			//'filter_embeddable'=> 'true' ,
			'sort'      => 'plays',
			'direction' => 'desc',
		);
		
		$direction = "desc";
		if ( $options['what']['order'] == 'title' ) {
			$sort      = "alphabetical";
			$direction = "asc";
		} elseif ( $options['what']['order'] == 'rating' ) {
			$sort = "likes";
		} elseif ( $options['what']['order'] == 'viewCount' ) {
			$sort = "plays";
		} elseif ( $options['what']['order'] == 'date' ) {
			$sort = "date";
		} elseif ( $options['what']['order'] == 'relevance' ) {
			$sort = "relevant";
		} else {
			$sort = 'date';
		}
		
		if ( $options['what']['mode'] == 'search' . $pid_suffix ) {
			
			$api_endpoint          = '/videos/';
			$api_args['query']     = $options['what'][ $vs_type['param'] ];
			$api_args['sort']      = $sort;
			$api_args['direction'] = $direction;
			
			
		} elseif ( $options['what']['mode'] == 'group' . $pid_suffix ) {
			if ( $sort == "relevant" ) {
				$sort = 'date';
			}
			
			$api_endpoint          = '/groups/' . $options['what'][ $vs_type['param'] ] . '/videos';
			$api_args['sort']      = $sort;
			$api_args['direction'] = $direction;
			
		} elseif ( $options['what']['mode'] == 'channel' . $pid_suffix ) {
			if ( $sort == "relevant" ) {
				$sort = 'date';
			}
			
			$api_endpoint          = '/channels/' . $options['what'][ $vs_type['param'] ] . '/videos';
			$api_args['sort']      = $sort;
			$api_args['direction'] = $direction;
			
		} elseif ( $options['what']['mode'] == 'user' . $pid_suffix ) {
			if ( $sort == "relevant" ) {
				$sort = 'date';
			}
			
			$api_endpoint          = '/users/' . $options['what'][ $vs_type['param'] ] . '/videos';
			$api_args['sort']      = $sort;
			$api_args['direction'] = $direction;
			
		} elseif ( $options['what']['mode'] == 'videos' . $pid_suffix ) {
			
			$api_endpoint = '/videos/' . $options['what'][ $vs_type['param'] ];
			
		} else {
			echo "UNKOWN MODE. EXIT !";
			
			return $videosFound;
		}
		
		
		if ( $options['what']['havingLikes'] != '' ) {
			$api_args['sort'] = 'likes';
		}
		if ( $options['what']['videoDuration'] != 'any' ) {
			$api_args['sort'] = 'duration';
		}
		if ( $options['what']['havingViews'] != '' ) {
			$api_args['sort'] = 'plays';
		}
		
		
		if ( ! isset( $videosFound['recalls'] ) ) {
			$videosFound['recalls'] = 0;
		}
		
		// d( $api_endpoint );
		// d( $api_args );
		//
		// return $videosFound ;
		
		$api_response = $api_handle->request( $api_endpoint, $api_args );
		
		
		$api_response = wpvr_object_to_array( $api_response );
		
		
		if ( WPVR_API_RESPONSE_DEBUG ) {
			d( $api_response );
		}
		//d( $api_endpoint );
		//d( $api_args );
		
		if ( $api_response['status'] != '200' ) {
			wpvr_render_error_notice( $vs_vm['msgs']['api_error'] );
			
			return $videosFound;
		}
		
		if ( isset( $api_response['body']['total'] ) && $api_response['body']['total'] == 0 ) {
			return $videosFound;
			
		}
		if ( ! isset( $api_response['body']['paging']['next'] ) || $api_response['body']['paging']['next'] == null ) {
			$videosFound['nextPageToken'] = "end";
		} else {
			$videosFound['nextPageToken'] = $videosFound['nextPageToken'] + 1;
		}
		
		if ( ! isset( $api_response['body']['total'] ) ) {
			$response_items = array( $api_response['body'] );
		} elseif ( count( $api_response['body']['data'] ) == 0 ) {
			$response_items = array( $api_response['body']['data'] );
		} else {
			$response_items = $api_response['body']['data'];
		}
		
		if ( isset( $api_response['body']['total'] ) ) {
			$videosFound['totalResults'] = $api_response['body']['total'];
		} elseif ( isset( $api_reponse['body']['uri'] ) ) {
			$videosFound['totalResults'] = 1;
		} else {
			$videosFound['totalResults'] = 0;
		}
		$videosIds                = "";
		$videosFound['videosIds'] = "";
		
		//d( $response_items );
		
		foreach ( (array) $response_items as $item ) {
			$videosFound['absCount'] ++;
			
			//new dBug($item);
			$x = explode( '/videos/', $item['uri'] );
			if ( ! isset( $x[1] ) ) {
				$videoId = '';
			} else {
				$videoId = $x[1];
			}
			
			
			if ( $videosFound['real_count'] >= $options['how']['wantedResults'] ) {
				$videosFound['execTime'] = round( microtime( true ) - $videosFound['execTime'], 2 );
				break;
			}
			
			if ( array_key_exists( $videoId, $oldVideos ) ) {
				if ( isset( $oldVideos[ $videoId ] ) && $oldVideos[ $videoId ] == 'unwanted' ) {
					$videosFound['unwantedCount'] ++;
				} else {
					$videosFound['dupCount'] ++;
				}
			}
			
			
			if ( $options['how']['onlyNewVideos'] === false || ! ( array_key_exists( $videoId, $oldVideos ) ) ) {
				
				if ( $options['how']['onlyNewVideos'] && array_key_exists( $videoId, $oldVideos ) ) {
					$isDuplicate = true;
				} else {
					$isDuplicate = false;
				}
				if ( ! ( array_key_exists( $videoId, $preDuplicates ) ) ) {
					$preDuplicates[ $videoId ] = 1;
					
					$videosIds                .= $videoId . ",";
					$videosFound['videosIds'] .= $videoId . ",";
					
					// Getting Tags
					if (
						$options['how']['getVideoTags'] == 'off'
						|| $isDuplicate
						|| ! isset( $item['tags'] )
					) {
						$video_tags = array();
					} else {
						$video_tags = array();
						foreach ( (array) $item['tags'] as $item_tag ) {
							if ( isset( $item_tag['name'] ) ) {
								$video_tags[] = $item_tag['name'];
							}
						}
					}
					
					
					//$video_tags = array();
					//if( isset( $item[ 'tags' ] ) && count( $item[ 'tags' ] ) != 0 ) {
					//	foreach ( (array) $item[ 'tags' ] as $item_tag ) {
					//		if( isset( $item_tag[ 'name' ] ) ) {
					//			$video_tags[] = $item_tag[ 'name' ];
					//		}
					//	}
					//}
					
					/* Getting thumbs */
					if ( isset( $item['pictures']['sizes'][5]['link'] ) ) {
						$item_thumb = $item['pictures']['sizes'][5]['link'];
					} elseif ( isset ( $item['pictures']['sizes'][4]['link'] ) ) {
						$item_thumb = $item['pictures']['sizes'][4]['link'];
					} elseif ( isset ( $item['pictures']['sizes'][3]['link'] ) ) {
						$item_thumb = $item['pictures']['sizes'][3]['link'];
					} elseif ( isset ( $item['pictures']['sizes'][2]['link'] ) ) {
						$item_thumb = $item['pictures']['sizes'][2]['link'];
					} elseif ( isset ( $item['pictures']['sizes'][1]['link'] ) ) {
						$item_thumb = $item['pictures']['sizes'][1]['link'];
					} else {
						$item_thumb = $item['pictures']['sizes'][0]['link'];
					}
					
					$nDate            = new DateTime( $item['created_time'] );
					$originalPostDate = $nDate->format( 'Y-m-d H:i:s' );
					
					if (
						isset( $item['metadata'] )
						&& isset( $item['metadata']['connections'] )
						&& isset( $item['metadata']['connections']['likes'] )
						&& isset( $item['metadata']['connections']['likes']['total'] )
						&& $item['metadata']['connections']['likes']['total'] != null
						&& $item['metadata']['connections']['likes']['total'] != ''
					) {
						$likesCount = $item['metadata']['connections']['likes']['total'];
					} else {
						$likesCount = 0;
					}
					if (
						isset( $item['stats'] )
						&& isset( $item['stats']['plays'] )
						&& $item['stats']['plays'] != null
						&& $item['stats']['plays'] != ''
					) {
						$viewsCount = $item['stats']['plays'];
					} else {
						$viewsCount = 0;
					}
					
					//d( $item );
					$videoItem = array(
						'id'               => $videoId,
						'viewIcon'         => '<img style="" width="150" height="115" src="' . $item['pictures']['sizes'][0]['link'] . '">',
						'title'            => $item['name'],
						'description'      => $item['description'],
						'thumb'            => $item_thumb,
						'hqthumb'          => $item_thumb,
						'service'          => 'vimeo',
						'icon'             => $item['pictures']['sizes'][2]['link'],
						'url'              => $item['link'],
						'originalPostDate' => $originalPostDate,
						'likes'            => $likesCount,
						'dislikes'         => 0,
						'views'            => $viewsCount,
						'duration'         => 'PT' . $item['duration'] . 'S',
						'source_tags'      => $options['how']['postTags'],
						'tags'             => $video_tags,
						'duplicate'        => $isDuplicate,
						'postDate'         => $options['how']['postDate'],
						'postCats'         => $options['how']['postCats'],
						'postAuthor'       => $options['how']['postAuthor'],
						'autoPublish'      => $options['how']['autoPublish'],
						'postStatus'      => $options['how']['postStatus'],
						'sourceName'       => $options['how']['sourceName'],
						'sourceId'         => $options['how']['sourceId'],
						'sourceType'       => $options['how']['sourceType'],
						'postAppend'       => $options['how']['postAppend'],
						'postContent'      => $options['how']['postContent'],
						'appendCustomText' => $options['how']['appendCustomText'],
						'appendSourceName' => $options['how']['appendSourceName'],
						'source'           => $videosFound['source'],
					);
					
					if ( $item['user']['pictures']['sizes'] != null ) {
						$thumb = array_pop( $item['user']['pictures']['sizes'] );
					} else {
						$thumb = false;
					}
					
					$videoItem = apply_filters(
						'wpvr_extend_found_item_author_data',
						$videoItem, //videoItem
						$item['user']['name'], //Author Name
						str_replace( '/users/', '', $item['user']['uri'] ), // Author ID
						$thumb['link'], // Author Image
						$item['user']['link'] // Author Link
					);
					
					$videoItem = apply_filters(
						'wpvr_extend_found_item',
						$videoItem,
						$item
					);
					
					$videosFound['items'][ $videoId ] = $videoItem;
					$oldVideos[ $videoId ]            = "tmp";
					$videosFound['count'] ++;
				}
			}
			
			$videosFound['real_count'] = count( $videosFound['items'] );
		}
		
		/* Apply Filtering on Videos Found */
		$videosFound = wpvr_filter_videos_found( $videosFound, $options );
		//d( $videosFound );
		// RECALL IF WANTED VIDEOS IS NOT REACHED
		if ( $videosFound['totalResults'] != 0 && $videosFound['real_count'] < $options['how']['wantedResults'] ) {
			if ( $videosFound['nextPageToken'] == 'end' ) {
				if ( $options['how']['debugMode'] ) {
					echo( '<br/> Found : ' . $videosFound['count'] . ' .... END SEARCH' );
				}
			} else {
				if ( $options['how']['debugMode'] ) {
					echo( '<br/> Found : ' . $videosFound['count'] . ' .... need to recall' );
				}
				$videosFound['recalls'] = $videosFound['recalls'] + 1;
				$videosFound            = $vs_vm['fetch_videos']( $videosFound, $options, $oldVideos );
			}
		} else {
			if ( $options['how']['debugMode'] ) {
				echo( '<br/> Found : ' . $videosFound['count'] . ' .... DONE !' );
			}
			$videosFound['execTime'] = round( microtime( true ) - $videosFound['execTime'], 2 );
		}
		
		return $videosFound;
	};
	$vs['fetch_videos']    = $vs_vm['fetch_videos'];
	/* Fetch Videos */
	
	
	/* Get Comments of a video */
	$vs_vmcm                 = $vs;
	$vs_vmcm['get_comments'] = function ( $video_id, $post_id, $cData ) use ( &$vs_vmcm, $pid_suffix ) {
		
		$cData = wpvr_extend( $cData, array(
			'ch'        => curl_init(),
			'pageToken' => 1,
			'wanted'    => 20,
			'count'     => 0,
			'recalls'   => 0,
			'do_import' => false,
			'comments'  => array(),
		) );
		
		//if( ! isset( $vs_vmcm ) ) return $cData;
		
		$vimeo = $vs_vmcm['api_auth']();
		if ( $vimeo === false ) {
			$cData['msg'] = 'Vimeo API not authorized.';
			
			return $cData;
		}
		
		$vimeo_endpoint = '/videos/' . $video_id . '/comments';
		$vimeo_args     = array(
			'per_page'  => '50',
			'page'      => $cData['pageToken'],
			'sort'      => 'date',
			'direction' => 'desc',
		);
		$api_response   = wpvr_object_to_array( $vimeo->request( $vimeo_endpoint, $vimeo_args ) );
		if ( $api_response['status'] != 200 ) {
			return $cData;
		}
		
		$api_response = $api_response['body'];
		
		
		$max_pages = ( $api_response['total'] / $api_response['per_page'] ) + 1;
		
		
		if ( ! isset( $api_response['data'] ) || ! is_array( $api_response['data'] ) || count( $api_response['data'] ) == 0 ) {
			return $cData;
		}
		
		//new dBug( $data );
		
		foreach ( (array) $api_response['data'] as $item ) {
			if ( $cData['count'] >= $cData['wanted'] ) {
				return $cData;
			}
			
			$nDate        = new DateTime( $item['created_on'] );
			$comment_date = $nDate->format( 'Y-m-d H:i:s' );
			$cData['count'] ++;
			
			$comment = array(
				'comment_post_ID'      => $post_id,
				'comment_author'       => $item['user']['name'],
				'comment_author_email' => '',
				'comment_author_url'   => $item['user']['link'],
				'comment_content'      => $item['text'],
				'comment_type'         => '',
				'comment_parent'       => 0,
				'comment_author_IP'    => '127.0.0.1',
				'comment_agent'        => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
				'comment_date'         => $comment_date,
				'comment_approved'     => 1,
			);
			if ( $cData['do_import'] === true ) {
				$comment_id            = wp_insert_comment( $comment );
				$comment['comment_id'] = $comment_id;
			} else {
				//new dBug( $comment );
			}
			$cData['comments'][] = $comment;
		}
		if ( $api_response['paging']['next'] != null && ( $cData['pageToken'] + 1 ) <= $max_pages && $cData['count'] <= $cData['wanted'] ) {
			$cData['recalls'] ++;
			$cData['pageToken'] = $cData['pageToken'] + 1;
			
			return $vs_vmcm['get_comments']( $video_id, $post_id, $cData );
		}
		
		return $cData;
		
	};
	$vs['get_comments']      = $vs_vmcm['get_comments'];
