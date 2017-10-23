<?php
	global $wpvr_pages;
	$wpvr_pages = TRUE;

	$changelog_url = WPVR_CHANGELOG_URL ;

	$grid = array(
		// LINE 1
		array(
			//COL 1
			array(
				'icon'       => 'fa-dashboard' ,
				'title'      => __( 'Plugin Dashboard' , WPVR_LANG ) ,
				'txt'        => __( 'The dashboard shows everything you need to know in a fancy way with beautiful graphics.' , WPVR_LANG ) ,
				'btn_icon'   => 'fa-arrow-right' ,
				'btn_label'  => __( 'Open Dashboard' , WPVR_LANG ) ,
				'btn_link'   => admin_url( 'admin.php?page=wpvr' ) ,
				'btn_target' => '_self' ,
			) ,

			//COL 1
			array(
				'icon'       => 'fa-gear' ,
				'title'      => __( 'Plugin Options' , WPVR_LANG ) ,
				'txt'        => __( 'Customize every facet and step of the plugin. There is a setting for almost everything !' , WPVR_LANG ) ,
				'btn_icon'   => 'fa-arrow-right' ,
				'btn_label'  => __( 'Manage Options' , WPVR_LANG ) ,
				'btn_link'   => admin_url( 'admin.php?page=wpvr-options' ) ,
				'btn_target' => '_self' ,
			) ,

			//COL 1
			array(
				'icon'       => 'fa-cubes' ,
				'title'      => __( 'Plugin Addons' , WPVR_LANG ) ,
				'txt'        => __( 'Enhance the plugin functionalities with several addons, or add other video services.' , WPVR_LANG ) ,
				'btn_icon'   => 'fa-arrow-right' ,
				'btn_label'  => __( 'Browse Addons' , WPVR_LANG ) ,
				'btn_link'   => admin_url( 'admin.php?page=wpvr-addons' ) ,
				'btn_target' => '_self' ,
			) ,
		) ,

		// LINE 1
		array(
			//COL 1
			array(
				'icon'       => 'fa-support' ,
				'title'      => __( 'Support Forums' , WPVR_LANG ) ,
				'txt'        => __( 'Our Support Team is here to help and assist you until you get satisfied with WP Video Robot.' , WPVR_LANG ) ,
				'btn_icon'   => 'fa-arrow-right' ,
				'btn_label'  => __( 'Get Support' , WPVR_LANG ) ,
				'btn_link'   => 'http://support.wpvideorobot.com/forum/support/' ,
				'btn_target' => '_blank' ,
			) ,

			//COL 1
			array(
				'icon'       => 'fa-book' ,
				'title'      => __( 'Documentation' , WPVR_LANG ) ,
				'txt'        => __( 'A clear and concise documentation written up to help you use WP Video Robot.' , WPVR_LANG ) ,
				'btn_icon'   => 'fa-arrow-right' ,
				'btn_label'  => __( 'Read Documentation' , WPVR_LANG ) ,
				'btn_link'   => 'http://doc.wpvideorobot.com/' ,
				'btn_target' => '_blank' ,
			) ,

			//COL 1
			array(
				'icon'       => 'fa-graduation-cap' ,
				'title'      => __( 'Tutorials' , WPVR_LANG ) ,
				'txt'        => __( 'A fully fledged and regularly added tutorials to help you get the most of WP Video Robot.' , WPVR_LANG ) ,
				'btn_icon'   => 'fa-arrow-right' ,
				'btn_label'  => __( 'Read Tutorials' , WPVR_LANG ) ,
				'btn_link'   => 'http://support.wpvideorobot.com/tutorials/' ,
				'btn_target' => '_blank' ,
			) ,
		) ,

	);


?>
<div class = "wrap wpvr_wrap" style = "display:none;">
	<div class = "wpvr_welcome_header"></div>
	<div class = "wpvr_welcome_content">
		<h1 class = "wpvr_welcome_content_title">
			<?php echo __( 'Welcome to WP Video Robot' , WPVR_LANG ); ?>
			<a class = "version">ver. <?php echo WPVR_VERSION; ?></a>
		</h1>
		<div class = "wpvr_welcome_content_wrap">

			<table>
				<tr>
					<td class = "">
						<div>

							<p>
								Thank you for using our plugin ! We had worked very hard to release a great, stable and improved
								product and we will commit to offer the best support for WPVR and fix all the reported issues. Our new goal is to make the plugin easier to use and more user friendly.
								Please let us know if you encounter any issues or if you have any feedback.
								We would be very happy to get your feedback or to help you get the most of WP Video Robot.
							</p>
							
							<?php if( WPVR_CHANGELOG_URL_ENABLED ) { ?>
                                <a href = "<?php echo $changelog_url; ?>" target = "_blank" class=" pull-left ">
                                    <button class = "wpvr_button wpvr_black_button">
                                        <i class="fa fa-gift"></i>
										<?php echo __( 'What\'s new on this version' , WPVR_LANG ); ?>
                                    </button>
                                </a>
							<?php } ?>
                            
                            <button
                                    changelog_url = "<?php echo WPVR_URL.'wpvr.changelog.txt'; ?>"
                                    changelog_title = "WP VIDEO ROBOT - Versions Changelog"
                                    class = "wpvr_read_changelog wpvr_button  wpvr_black_button pull-left "
                            >
                                <i class = "fa fa-file-text-o"></i>
								<?php echo __( 'Complete Changelog' , WPVR_LANG ); ?>
                            </button>

                            <button
                                    class = "wpvr_import_sample_sources wpvr_button  pull-left"
                            >
                                <i class = "fa fa-cloud-download"></i>
								<?php echo __( 'Import Sample Sources' , WPVR_LANG ); ?>
                            </button>
                            
							

       
                            

       
                            
							
						</div>
					</td>
				</tr>
			</table>
		</div>


	</div>
	<div class = "wpvr_welcome_grid">
		<?php foreach ( (array) $grid as $lines ) { ?>

			<?php foreach ( (array) $lines as $col ) { ?>
				<div class = "wpvr_grid_col">
					<h2>
						<a target = "<?php echo $col[ 'btn_target' ]; ?>" href = "<?php echo $col[ 'btn_link' ]; ?>">
							<i class = "fa <?php echo $col[ 'icon' ]; ?>"></i>
							<?php echo $col[ 'title' ]; ?>
						</a>
					</h2>
					<p class = "wpvr_grid_col_txt">
						<?php echo $col[ 'txt' ]; ?>
					</p>
					<div class = "wpvr_grid_col_btn">
						<a target = "<?php echo $col[ 'btn_target' ]; ?>" href = "<?php echo $col[ 'btn_link' ]; ?>">
							<button class = "wpvr_grid_btn wpvr_button wpvr_full_width">
								<i class = "fa <?php echo $col[ 'btn_icon' ]; ?>"></i>
								<?php echo $col[ 'btn_label' ]; ?>
							</button>
						</a>
					</div>
				</div>

			<?php } ?>

		<?php } ?>
	</div>

	<span class = "wpvr_welcome_thanks">
		Thank you for using <a href = "http://wpvideorobot.com/" target = "_blank">WP Video Robot</a> !
	</span>

</div>
