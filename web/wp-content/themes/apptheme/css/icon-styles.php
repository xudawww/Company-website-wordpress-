<?php

if ( ! class_exists('AppPresser') ) {
	echo '<style type="text/css">
	#adminmenu .toplevel_page_apptheme_about .wp-menu-image {
	   width: 28px;
	   height: 28px;
	   background-image: url("' . get_stylesheet_directory_uri() . '/images/icon.svg") !important;
	   background-position: 5px 1px !important;
		background-size: 70px 30px;
		margin-right: 5px;
		color:white;
	}
	#adminmenu li.toplevel_page_apptheme_about.current a .wp-menu-image {
		background-position: -40px 1px !important;
	}
	#adminmenu .toplevel_page_apptheme_about .wp-menu-image:before {
		content: "" !important;
	}
	</style>';
}
