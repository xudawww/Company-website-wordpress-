=== AppTheme ===
Contributors: apppresser, webdevstudios, williamsba1, scottopolis, jtsternberg, Messenlehner, LisaSabinWilson, modemlooper, stillatmylinux
Author URI: http://apppresser.com
Requires at least: 3.5
Tested up to: 4.7.0
Stable tag: 2.5.1
License: General Public License
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: flexible-width, custom-background, custom-colors, custom-header, flexible-header, featured-image-header, featured-images, light, white, full-width-template, theme-options, threaded-comments, translation-ready, one-column, two-columns, left-sidebar, right-sidebar

== Description ==
Description: A starter theme for WordPress application development. 

== Installation ==

1. Unzip the apptheme.x.x.x.zip file. Be sure that the folder is named apptheme for updates.
2. Upload the apptheme folder using your preferred FTP software to wp-content/themes/
3. Go to the AppPresser menu.
4. From the "App-only theme" downdown select AppTheme.
5. Press the "Save Settings" button on the bottom of the page.
6. Press the "Open Customer" to customizer your new theme.

== Copyright ==

AppPresser WordPress Theme, Copyright 2013 AppPresser
AppPresser is distributed under the terms of the GNU GPL
AppPresser uses code from _s ("Underscores") WordPress Theme, Copyright 2013 Automattic, Inc.
Bootstrap designed and built by @mdo and @fat, sass-ified by Aaron Lademann @alademann http://getbootstrap.com/ license http://www.apache.org/licenses/LICENSE-2.0
Images included with the theme are under GPL license.

== Changelog ==

= 2.5.1 =
* Fix customizer compatibility issues with WordPress 4.7

= 2.5.0 =
* Add the ability to use custom login/logout redirects using the appp_login_redirect and appp_logout_redirect filters

= 2.4.1 =
* Fix ajax content for images with internal links
* Fix images with external links to open in InApp browser

= 2.4.0 =
* Add dynamic js modals to improve AppBuddy images popup
* Better login ajax error handling

= 2.3.1 =
* Add missing minified js file.

= 2.3.0 =
* Add the capability to hook the no_ajax classes
* Improve iOS keyboard layering and copy/paste issues
* Misc. styling

= 2.2.6 =
* fix iOS bug with fixed position on .site-footer
* apppush loadAjaxContent fix
* add missing icons for woocommerce
* rename css .spinner to avoid conflicts
* add fix to FastClick for textarea

= 2.2.5 =
* Improve copy/paste iOS issues on the AppBuddy login form
* Fix CSS related to menu nav icons and content margin
* Improve regex when loading localized variables

= 2.2.4 =
* Fix undefined ajaxurl

= 2.2.3 =
* Add apptheme body class
* Fix no-ajax bug
* Add page titles for BuddyPress

= 2.2.2 =
* Fix hidden top menu css issue

= 2.2.1 =
* Fix l10n bug: check for undefined match
* Fix layering bug for AppCamera attach-image-sheet css
* Fix fixed position bug with header snapping back
* Add appp_ajax_html event trigger

= 2.2.0 =
* Notifications with Ajax URLs
* Updates for Quick Start admin settings

= 2.1.5 =

* Fix AIB for A tags that use href="javascript:"
* Load localized javascript data when loading Ajax page (appwoo variables product fix)
* Load javascript/template when loading Ajax page (appwoo variables product fix)
* Add category choice from the customizer to homepage shortcode for AppSwiper

= 2.1.4 =

* Add ajax to #loginform modal
* Bug fix when using the external class opening the in-app browser

= 2.1.3 =

* Bug fix for horizontal scrolling BuddyPress profile menu
* Bug fix for replying to BuddyPress comments

= 2.1.2 =

* Add linking to appswiper images
* Bug fixes to check for undefined values
* Bug fixes to transitions
* Css fix for appbuddy buttons

= 2.1.1 =

* Add filter for appshare buttons

= 2.1.0 =

* Customizer updates: Add option for posts on mobile homepage
* Customizer updates: Customize list background colors
* Native transitions: Add filters for appp_transition_left
* Update template: Remove comments from page template
* Update template: Misc. styling updates
* Bug fix: Android back button

= 2.0.1 =

* New: swipe to go forward/back on single posts
* Fix: fields to display to logged in commenters

= 2.0.0 =

Major Release, see https://apppresser.com/apptheme-2-0-released/ for details.
* Big design and UI improvements
* New single post footer UI with sharing option
* Ajax commenting
* New homepage customization options:
* App style lists for homepage
* Homepage app style slider
* Support for custom ajax functions
* New hooks - login form, cardlist footer
* Better sub-menu animation
* Lots of small tweaks and fixes

= 1.0.8 =

* Side menu fixes and improvements
* Security fixes

= 1.0.7 =

* Fix missing ajax on many links
* Do not submit comment form if no content, fixes redirect error
* Bust CSS cache so changes in app take effect
* Fixed wrong menu slide direction, goes right to left now
* Updated spinner to match mobile UI better, sexy!
* Lots of CSS clean up on elements, better UI

= 1.0.6 =

* UI improvements, appswiper style improvements
* Translation updates
* Bug fixes
* Compatibility with latest version of Phonegap

= 1.0.5 =

* Bug fix for back button
* Added '.ajaxify a' class for easier custom ajax support

= 1.0.4 =

* Enhancement: new reusable modal
* Support for AppBuddy
* Bug fix: Remove all :hover states (they are buggy in a touchscreen app)
* Change: Updated text-domain to 'apptheme'. Translators take note.
* Enhancement: Added hammerjs for multitouch support
* Enhancement: double-top header bar to scroll to top
* Enhancement: Sign in/out buttons in left drawer menu

= 1.0.3 =

* Fixes: Remove unused theme customizer setting.
* Fixes: Make theme color modifications be theme_mods instead of options.

= 1.0.2 =

* Fixes: Fix version number phpdocs, and remove unneeded/unused function parameter from `appp_remove_hook`.

= 1.0.1 =

* Enhancement: Better handling of featured images.
* Enhancement: Moved all of functions.php to `/inc/init.php` so that child themes can manually include and use functionality right away.

= 1.0.0 =

* First official release.