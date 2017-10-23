<?php
	
	
	/* Require Ajax WP load */
	if( isset( $_GET[ 'wpvr_wpload' ] ) || isset( $_POST[ 'wpvr_wpload' ] ) ) {
		define( 'DOING_AJAX' , TRUE );
		//define('WP_ADMIN', true );
		$wpload = 'wp-load.php';
		while( ! is_file( $wpload ) ) {
			if( is_dir( '..' ) ) chdir( '..' );
			else die( 'EN: Could not find WordPress! FR : Impossible de trouver WordPress !' );
		}
		require_once( $wpload );
	}
	
	
	global $wpvr_options , $wpvr_default_options , $wpvr_token;
	$wpvr_url = WPVR_IMPORT_URL;
	
	global $wpvr_pages;
	$wpvr_pages = TRUE;
	if( isset( $_GET[ 'import_single_video' ] ) ) {
		global $wpvr_options , $wpvr_imported;
		
		$count_dup = $count_imported = 0;
		foreach ( (array) $_POST[ 'items' ] as $k => $item ) {
			
			$video = (array) $_SESSION[ 'wpvr_tmp_import' ][ $k ];
			
			//new dBug( $video );
			//return false;
			//$video = wpvr_json_decode( stripslashes( $item ), true );
			
			/* Defining what we do ... */
			if( isset( $video[ 'resetViews' ] ) && $video[ 'resetViews' ] == 'yes' ) $resetViews = TRUE;
			else $resetViews = FALSE;
			if( isset( $video[ 'skipDup' ] ) && $video[ 'skipDup' ] == 'yes' ) $skipDup = TRUE;
			else $skipDup = FALSE;
			if( isset( $video[ 'publishDate' ] ) && $video[ 'publishDate' ] != '' ) $publishDate = $video[ 'publishDate' ];
			else $publishDate = "";
			
			//new dBug( $video );
			
			
			$newVideo         = (array) $video;
			$newVideo[ 'ID' ] = $newVideo[ 'id' ] = '';
			if( $publishDate == 'now' ) {
				$now                         = new Datetime();
				$newVideo[ 'post_date' ]     = $now->format( 'Y-m-d H:i:s' );
				$newVideo[ 'post_date_gmt' ] = $now->format( 'Y-m-d H:i:s' );
			}
			/*	if($postAuthor != ''){$newVideo['post_author'] = $postAuthor;}*/
			
			//we get the video Id
			$new_video_id = $newVideo[ '__videoId' ];
			$service      = $newVideo[ '__service' ];
			
			if( $skipDup && isset( $wpvr_imported[ $service ][ $new_video_id ] ) ) {
				$count_dup ++;
				continue;
			}
			
			//We add the video 
			$newVideoId = wp_insert_post( $newVideo );
			
			
			//We set Cats and tags
			$slugTags = explode( ',' , $newVideo[ 'slugTags' ] );
			$slugCats = explode( ',' , $newVideo[ 'slugCats' ] );
			wp_set_post_tags( $newVideoId , $slugTags , TRUE );
			wp_set_object_terms( $newVideoId , $slugCats , 'category' , TRUE );
			
			
			//We update metadata
			$keys = array_keys( $newVideo );
			foreach ( (array) $keys as $key ) {
				$xKey = explode( '__' , $key );
				if( isset( $xKey[ 1 ] ) && $xKey[ 1 ] != '' ) {
					$meta_name  = "wpvr_video_" . $xKey[ 1 ];
					$meta_value = $newVideo[ $key ];
					if( $meta_name == 'wpvr_video_videoId' ) update_post_meta( $newVideoId , 'wpvr_video_id' , $meta_value );
					elseif( $meta_name == 'wpvr_video_views' && $resetViews ) {
						update_post_meta( $newVideoId , 'wpvr_video_views' , 0 );
					} else update_post_meta( $newVideoId , $meta_name , $meta_value );
					
				}
			}
			
			//We add and set Thumbnail
			$upload_dir = wp_upload_dir(); // Set upload folder
			$image_data = @file_get_contents( $newVideo[ '__youtubeThumb' ] ); // Get image data
			$filename   = sanitize_file_name( $newVideo[ '__videoId' ] ) . basename( $newVideo[ '__youtubeThumb' ] );


			if( ! file_exists( $filename ) ) {
				if( wp_mkdir_p( $upload_dir[ 'path' ] ) ) $file = $upload_dir[ 'path' ] . '/' . $filename;
				else $file = $upload_dir[ 'basedir' ] . '/' . $filename;
				@file_put_contents( $file , $image_data );
			}
			
			$wp_filetype = @wp_check_filetype( $filename , null );
			$thumb_title = "_att_" . $newVideo[ '__videoId' ] . "";
			$attachment  = array(
				'post_mime_type' => $wp_filetype[ 'type' ] ,
				'post_title'     => $thumb_title . "_attachment" ,
				'post_name'      => sanitize_title( $newVideo[ '__videoId' ] . "_attachment" ) ,
				'post_content'   => $newVideo[ 'post_title' ] ,
				'post_status'    => 'inherit' ,
			);
			$attach_id   = @wp_insert_attachment( $attachment , $file , $newVideoId );
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			$attach_data = @wp_generate_attachment_metadata( $attach_id , $file );
			@wp_update_attachment_metadata( $attach_id , $attach_data );
			@set_post_thumbnail( $newVideoId , $attach_id );
			
			$count_imported ++;
		}
		
		echo wpvr_json_encode( array(
			'status'         => 'ok' ,
			'count_dup'      => $count_dup ,
			'count_imported' => $count_imported ,
		) );
		
		return FALSE;
	}
	
	//Actions of importing options	
	if( isset( $_POST[ 'import_options' ] ) ) {

		$imported_file_name = "tmp_import_" . mt_rand( 0 , 1000 );
		$imported_file      = WPVR_TMP_PATH . $imported_file_name;
		if( move_uploaded_file( $_FILES[ 'uploadedfile' ][ 'tmp_name' ] , $imported_file ) ) {
			//echo "The file ".  $_FILES['uploadedfile']['name']. " has been uploaded";
		} else {
			_e( "There was an error uploading the file, please try again!" , WPVR_LANG );

			return FALSE;
		}
		//new dBug( file_get_contents( $imported_file ) );
		$json = (array) wpvr_json_decode( file_get_contents( $imported_file ) );
		
		//new dBug( $imported_file );
		//new dBug( $json );
		
		unlink( $imported_file );
		//return false;
		
		if( ! isset( $json[ 'version' ] ) || ! isset( $json[ 'data' ] ) || ! isset( $json[ 'type' ] ) || $json[ 'type' ] != 'options' ) {
			?>
			<div class = "wrap wpvr_wrap  wpvr_wrap">
				<h2 class = "wpvr_title">
					<?php wpvr_show_logo(); ?>
					<i class = "wpvr_title_icon fa fa-download"></i>
					<?php echo __( 'WP Video Robot' , WPVR_LANG ) . ' - ' . __( 'Importing Options' , WPVR_LANG ); ?>
				</h2>
				<p>
					<?php _e( 'The uploaded file is not valid !' , WPVR_LANG ); ?><br/><br/>
					<a href = "#" id = "backBtn"> <?php echo __( 'Go Back' , WPVR_LANG ); ?> </a>
				</p>
			</div>
			<?php
			return FALSE;
		}
		
		$json_options = (array) $json[ 'data' ];
		$tokens       = array();
		$json_tokens  = (array) $json_options[ 'tokens' ];
		foreach ( (array) $json_tokens as $s => $data ) {
			$tokens[ $s ] = (array) $data;
		}
		//new dBug( $tokens );
		update_option( 'wpvr_options' , $json_options );
		update_option( 'wpvr_tokens' , $tokens );
		?>
		<div class = "wrap wpvr_wrap ">
			<h2 class = "wpvr_title">
				<?php wpvr_show_logo(); ?>
				<i class = "wpvr_title_icon fa fa-download"></i>
				<?php echo __( 'WP Video Robot' , WPVR_LANG ) . ' - ' . __( 'Importing Options' , WPVR_LANG ); ?>
			</h2>
			<p>
				<div class = "updated">
			<p><?php echo __( 'Options were successfully imported !' , WPVR_LANG ); ?> </p>
		</div>
		<br/><br/>

		<a href = "#" id = "backBtn">
			<?php echo __( 'Go Back' , WPVR_LANG ); ?>
		</a>
		</p>
		</div>
		<?php
		return FALSE;
	}


	//Actions of importing sources
	if( isset( $_POST[ 'import_sources' ] ) ) {
		
		if( isset( $_POST[ 'toggleOff' ] ) && $_POST[ 'toggleOff' ] == 'yes' ) $toggleOff = TRUE;
		else $toggleOff = FALSE;
		
		$imported_file_name = "tmp_import_" . mt_rand( 0 , 1000 );
		$imported_file      = WPVR_TMP_PATH . $imported_file_name;

		if( move_uploaded_file( $_FILES[ 'uploadedfile' ][ 'tmp_name' ] , $imported_file ) ) {
			//echo "The file ".  $_FILES['uploadedfile']['name']. " has been uploaded";
		} else {
			_e( "There was an error uploading the file, please try again!" , WPVR_LANG );

			return FALSE;
		}
		
		
		$json = (array) wpvr_json_decode( file_get_contents( $imported_file ) );
		
		//new dBug( $json);		return false;

		unlink( $imported_file );

		if(
			! isset( $json[ 'version' ] )
			|| ! isset( $json[ 'data' ] )
			|| ! isset( $json[ 'type' ] )
			|| $json[ 'type' ] != 'sources'
		) {
			?>
			<div class = "wrap wpvr_wrap  wpvr_wrap">
				<h2 class = "wpvr_title">
					<?php wpvr_show_logo(); ?>
					<i class = "wpvr_title_icon fa fa-download"></i>
					<?php echo __( 'WP Video Robot' , WPVR_LANG ) . ' - ' . __( 'Importing sources' , WPVR_LANG ); ?>
				</h2>
				<p>
					<?php _e( 'The uploaded file is not valid !' , WPVR_LANG ); ?><br/><br/>
					<a href = "#" id = "backBtn"> <?php echo __( 'Go Back' , WPVR_LANG ); ?> </a>
				</p>
			</div>
			<?php
			return FALSE;
		}
		$import_sources = $json[ 'data' ];
		
		
		$count_import   = count( $import_sources );
		$count_imported = 0;
		//new dBug( $import_sources );
		
		foreach ( (array) $import_sources as $source ) {
			$done = wpvr_import_source( $source , $toggleOff );
			$count_imported ++;
		}
		?>
		<div class = "wrap wpvr_wrap" style = "display:none;">
			<h2 class = "wpvr_title">
				<?php wpvr_show_logo(); ?>
				<i class = "wpvr_title_icon fa fa-download"></i>
				<?php echo __( 'Importing sources' , WPVR_LANG ); ?>
			</h2>

			<p>
				<div class = "updated">
			<p><?php echo __( 'Sources were successfully imported !' , WPVR_LANG ); ?> </p>
		</div>
		<br/><br/>

		<?php echo '<b>' . $count_import . '</b> ' . __( 'source(s) found.' , WPVR_LANG ); ?>
		<br/><?php echo '<b>' . $count_imported . '</b> ' . __( 'source(s) successfully imported.' , WPVR_LANG ); ?>

		<br/><br/>
		<a href = "#" id = "backBtn">
			<?php echo __( 'Go Back' , WPVR_LANG ); ?>
		</a>
		</p>
		</div>
		
		<?php
		
		return FALSE;
	}
	
	//Actions of importing videos
	if( isset( $_POST[ 'import_videos' ] ) ) {
		global $wpvr_imported;
		if( isset( $_POST[ 'resetViews' ] ) && $_POST[ 'resetViews' ] == 'yes' ) $resetViews = TRUE;
		else $resetViews = FALSE;
		
		if( isset( $_POST[ 'skipDup' ] ) && $_POST[ 'skipDup' ] == 'yes' ) $skipDup = TRUE;
		else $skipDup = FALSE;
		
		if( isset( $_POST[ 'postAuthor' ] ) ) $postAuthor = $_POST[ 'postAuthor' ];
		else $postAuthor = "";
		
		if( isset( $_POST[ 'publishDate' ] ) ) $publishDate = $_POST[ 'publishDate' ];
		else $publishDate = "";
		
		if( isset( $_POST[ 'allAtOnce' ] ) && $_POST[ 'allAtOnce' ] == 'yes' ) $allAtOnce = TRUE;
		else $allAtOnce = FALSE;
		
		
		//new dBug( $_POST );return false;
		
		
		$imported_file_name = "tmp_import_" . mt_rand( 0 , 1000 );
		$imported_file      = WPVR_TMP_PATH . $imported_file_name;

		if( move_uploaded_file( $_FILES[ 'uploadedfile' ][ 'tmp_name' ] , $imported_file ) ) {
			//echo "The file ".  $_FILES['uploadedfile']['name']. " has been uploaded";
		} else {
			_e( "There was an error uploading the file, please try again!" , WPVR_LANG );

			return FALSE;
		}
		
		$json_data = file_get_contents( $imported_file );
		$json      = (array) wpvr_json_decode( $json_data );
		unlink( $imported_file );
		
		
		//new dBug($json);

		if( ! isset( $json[ 'version' ] ) || ! isset( $json[ 'data' ] ) || ! isset( $json[ 'type' ] ) || $json[ 'type' ] != 'videos' ) {
			?>
			<div class = "wrap wpvr_wrap  wpvr_wrap" style = "display:none;">
				<h2 class = "wpvr_title">
					<?php wpvr_show_logo(); ?>
					<i class = "wpvr_title_icon fa fa-download"></i>
					<?php _e( 'Importing videos ...' , WPVR_LANG ); ?>
				</h2>
				<p>
					<?php _e( 'The uploaded file is not valid !' , WPVR_LANG ); ?><br/><br/>
					<a href = "#" id = "backBtn"> <?php echo __( 'Go Back' , WPVR_LANG ); ?> </a>
				</p>
			</div>
			<?php
			return FALSE;
		}
		$import_videos  = $json[ 'data' ];
		$count_import   = count( $import_videos );
		$count_imported = 0;
		$count_dup      = 0;
		
		
		foreach ( (array) $import_videos as $video ) {
			
			$newVideo         = (array) $video;
			$newVideo[ 'ID' ] = $newVideo[ 'id' ] = '';
			if( $publishDate == 'now' ) {
				$now                         = new Datetime();
				$newVideo[ 'post_date' ]     = $now->format( 'Y-m-d H:i:s' );
				$newVideo[ 'post_date_gmt' ] = $now->format( 'Y-m-d H:i:s' );
			}
			if( $postAuthor != '' ) {
				$newVideo[ 'post_author' ] = $postAuthor;
			}
			
			//we get the video Id
			$new_video_id = $newVideo[ '__videoId' ];
			$service      = $newVideo[ '__service' ];
			
			if( $skipDup && isset( $wpvr_imported[ $service ][ $new_video_id ] ) ) {
				$count_dup ++;
				continue;
			}
			
			//We add the video 
			$newVideoId = wp_insert_post( $newVideo );
			
			if( $service == 'youtube' )
				update_post_meta( $newVideoId , 'wpvr_video_ytId' , $new_video_id );
			elseif( $service == 'dailymotion' )
				update_post_meta( $newVideoId , 'wpvr_video_dmId' , $new_video_id );
			elseif( $service == 'vimeo' )
				update_post_meta( $newVideoId , 'wpvr_video_voId' , $new_video_id );
			
			//We set Cats and tags
			$slugTags = explode( ',' , $newVideo[ 'slugTags' ] );
			$slugCats = explode( ',' , $newVideo[ 'slugCats' ] );
			wp_set_post_tags( $newVideoId , $slugTags , TRUE );
			wp_set_object_terms( $newVideoId , $slugCats , 'category' , TRUE );
			
			
			//We update metadata
			$keys = array_keys( $newVideo );
			foreach ( (array) $keys as $key ) {
				$xKey = explode( '__' , $key );
				if( isset( $xKey[ 1 ] ) && $xKey[ 1 ] != '' ) {
					$meta_name  = "wpvr_video_" . $xKey[ 1 ];
					$meta_value = $newVideo[ $key ];
					if( $meta_name == 'wpvr_video_videoId' ) update_post_meta( $newVideoId , 'wpvr_video_id' , $meta_value );
					elseif( $meta_name == 'wpvr_video_views' && $resetViews ) {
						update_post_meta( $newVideoId , 'wpvr_video_views' , 0 );
					} else update_post_meta( $newVideoId , $meta_name , $meta_value );
					
				}
			}
			
			//We add and set Thumbnail
			$upload_dir = wp_upload_dir(); // Set upload folder
			$image_data = @file_get_contents( $newVideo[ '__youtubeThumb' ] ); // Get image data
			$filename   = sanitize_file_name( $newVideo[ '__videoId' ] ) . basename( $newVideo[ '__youtubeThumb' ] );


			if( ! file_exists( $filename ) ) {
				if( wp_mkdir_p( $upload_dir[ 'path' ] ) ) $file = $upload_dir[ 'path' ] . '/' . $filename;
				else $file = $upload_dir[ 'basedir' ] . '/' . $filename;
				@file_put_contents( $file , $image_data );
			}
			
			$wp_filetype = @wp_check_filetype( $filename , null );
			$thumb_title = "_att_" . $newVideo[ '__videoId' ] . "";
			$attachment  = array(
				'post_mime_type' => $wp_filetype[ 'type' ] ,
				'post_title'     => $thumb_title . "_attachment" ,
				'post_name'      => sanitize_title( $newVideo[ '__videoId' ] . "_attachment" ) ,
				'post_content'   => $newVideo[ 'post_title' ] ,
				'post_status'    => 'inherit' ,
			);
			$attach_id   = @wp_insert_attachment( $attachment , $file , $newVideoId );
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			$attach_data = @wp_generate_attachment_metadata( $attach_id , $file );
			@wp_update_attachment_metadata( $attach_id , $attach_data );
			@set_post_thumbnail( $newVideoId , $attach_id );
			
			$count_imported ++;
		}
		
		?>

		<div class = "wrap wpvr_wrap " style = "display:none;">
		<h2 class = "wpvr_title">
			<?php wpvr_show_logo(); ?>
			<i class = "wpvr_title_icon fa fa-download"></i>
			<?php echo __( 'Importing videos ...' , WPVR_LANG ); ?>
		</h2>

		<p>
		<?php if( $count_imported != 0 ) { ?>
			<div class = "updated">
			<p><?php
					echo __( 'Videos were successfully imported !' , WPVR_LANG ); ?> </p>
			</div>
			<br/><br/>
		<?php } ?>

		<?php echo '<b>' . $count_import . '</b> ' . __( 'video(s) found.' , WPVR_LANG ); ?>
		<br/><?php echo '<b>' . $count_imported . '</b> ' . __( 'video(s) successfully imported.' , WPVR_LANG ); ?>
		<br/><?php echo '<b>' . $count_dup . '</b> ' . __( 'duplicate video(s) skipped.' , WPVR_LANG ); ?>

		<br/><br/>
		<br/><br/>
		<a href = "#" id = "backBtn">
			<?php echo __( 'Go Back' , WPVR_LANG ); ?>
		</a>
		</p>
		</div>

		<?php
		
		return FALSE;
	}

?>


<div class = "wrap wpvr_wrap  wpvr_wrap" style = "display:none;">
	<?php wpvr_show_logo(); ?>
	<h2 class = "wpvr_title">
		<i class = "wpvr_title_icon fa fa-download"></i>
		<?php echo __( 'Import Panel' , WPVR_LANG ); ?>
	</h2>

	<div id = "dashboard-widgets-wrap">
		<div id = "dashboard-widgets" class = "metabox-holder">
			<div id = "postbox-container-1" class = "postbox-container">
				<div id = "normal-sortables" class = "meta-box-sortables ui-sortable">
					<div id = "dashboard_right_now" class = "postbox ">
						<h3 class = "hndle"><span>
								<?php _e( 'IMPORT SOURCES' , WPVR_LANG ); ?>
							</span></h3>
						<div class = "inside">
							<div class = "main">
								<form method = "post" enctype = "multipart/form-data">
									<input type = "hidden" name = "import_sources" value = "1"/>
									<div class = "wpvr_import_left">

										<?php _e( 'Choose a JSON (.json) file to upload, then click Upload file and import.' , WPVR_LANG ); ?>
										<br/>
										<label for = "upload">
											<?php _e( 'Choose a file from your computer: (Maximum size: 32 MB)' , WPVR_LANG ); ?>
										</label><br/><br/>
										<input type = "file" id = "upload" name = "uploadedfile" size = "25">

										<br/><br/>
										<label><?php echo _e( 'Toggle Off Imported sources :' , WPVR_LANG ); ?></label>
										<select name = "toggleOff">
											<option value = "yes"> <?php _e( 'Yes' , WPVR_LANG ); ?></option>
											<option value = "no" selected = "selected"><?php _e( 'No' , WPVR_LANG ); ?></option>
										</select>
										<br/><br/>

										<button type = "submit" id = "" class = "pull-left actionBtn wpvr_submit_button">
											<i class = "wpvr_button_icon fa fa-download"></i>
											<?php _e( 'Upload the file and import' , WPVR_LANG ); ?>
										</button>
										<div class = "wpvr_clearfix"></div>
									</div>
									<div class = "wpvr_big_icon wp-menu-image dashicons-before dashicons-search"></div>
								</form>

							</div>
						</div>
					</div>

					<div id = "dashboard_right_now" class = "postbox ">
						<h3 class = "hndle"><span>
								<?php _e( 'IMPORT VIDEOS' , WPVR_LANG ); ?>
							</span></h3>
						<div class = "inside">
							<div class = "main">

								<form method = "post" enctype = "multipart/form-data">
									<input type = "hidden" name = "import_videos" value = "1"/>
									<p>
										<?php _e( 'Choose a JSON (.json) file to upload, then click Upload file and import.' , WPVR_LANG ); ?>
										<br/><br/>
										<label for = "upload">
											<?php _e( 'Choose a file from your computer: (Maximum size: 32 MB)' , WPVR_LANG ); ?>
										</label><br/>
										<input type = "file" id = "upload" name = "uploadedfile" size = "25">
										<br/><br/>
										<label><?php echo _e( 'Publish Action :' , WPVR_LANG ); ?></label>
										<select name = "publishDate">
											<option value = "original">
												<?php _e( 'Keep original publish date' , WPVR_LANG ); ?>
											</option>
											<option value = "now" selected = "selected">
												<?php _e( 'Publish Now' , WPVR_LANG ); ?>
											</option>
										</select>
										<br/>
										<label><?php echo _e( 'Posting Author :' , WPVR_LANG ); ?></label>
										<select name = "postAuthor">
											<?php
												$authorsArray = wpvr_get_authors( $invert = FALSE , $default = FALSE );
												$current_user = wp_get_current_user();
												foreach ( (array) $authorsArray as $label => $value ) {
													printf( '<option value="%s"%s>%s</option>' ,
														$value , $value == $current_user->ID ? ' selected="selected"' : '' , $label );
												}
											?>
										</select>
										<br/>

										<label><?php echo _e( 'Reset Views :' , WPVR_LANG ); ?></label>
										<select name = "resetViews">
											<option value = "yes"> <?php _e( 'Yes' , WPVR_LANG ); ?></option>
											<option value = "no" selected = "selected"><?php _e( 'No' , WPVR_LANG ); ?></option>
										</select>
										<br/>
										<label><?php echo _e( 'Skip Duplicates :' , WPVR_LANG ); ?></label>
										<select name = "skipDup">
											<option value = "yes"> <?php _e( 'Yes' , WPVR_LANG ); ?></option>
											<option value = "no" selected = "selected"><?php _e( 'No' , WPVR_LANG ); ?></option>
										</select>


										<br/><br/>

										<button type = "submit" id = "" class = "pull-left actionBtn wpvr_submit_button">
											<i class = "wpvr_button_icon fa fa-download"></i>
											<?php _e( 'Upload the file and import' , WPVR_LANG ); ?>
										</button>

									<div class = "wpvr_clearfix"></div>
									</p>
								</form>
								<div class = "wpvr_big_icon wp-menu-image dashicons-before dashicons-format-video"></div>

							</div>
						</div>
					</div>


				</div>
			</div>
			<div id = "postbox-container-2" class = "postbox-container">
				<div id = "normal-sortables" class = "meta-box-sortables ui-sortable">


					<div id = "dashboard_right_now" class = "postbox ">
						<h3 class = "hndle"><span>
								<?php _e( 'IMPORT OPTIONS' , WPVR_LANG ); ?>
							</span></h3>
						<div class = "inside">
							<div class = "main">
								<form method = "post" enctype = "multipart/form-data">
									<input type = "hidden" name = "import_options" value = "1"/>
									<p>
										<?php _e( 'Choose a JSON (.json) file to upload, then click Upload file and import.' , WPVR_LANG ); ?>
										<br/>
										<label for = "upload">
											<?php _e( 'Choose a file from your computer: (Maximum size: 32 MB)' , WPVR_LANG ); ?>
										</label><br/><br/>
										<input type = "file" id = "upload" name = "uploadedfile" size = "25">
										<br/>
										<br/>
										<button type = "submit" id = "" class = "pull-left actionBtn wpvr_submit_button">
											<i class = "wpvr_button_icon fa fa-download"></i>
											<?php _e( 'Upload the file and import' , WPVR_LANG ); ?>
										</button>
									<div class = "wpvr_clearfix"></div>
									</p>
								</form>
								<div class = "wpvr_big_icon wp-menu-image dashicons-before dashicons-admin-settings"></div>
							</div>
						</div>
					</div>


				</div>
			</div>
		</div>
	</div>

</div>