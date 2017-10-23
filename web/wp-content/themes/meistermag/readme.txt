=== MeisterMag ===

Requires at least: 4.0
Tested up to: 4.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Tags: two-columns, right-sidebar, custom-menu, custom-logo, featured-images, footer-widgets, sticky-post, theme-options, threaded-comments, translation-ready, blog, news

== Description ==

MeisterMag is a free WordPress theme that lets you write articles and blog posts with ease.

The MeisterMag template uses a beautiful default color schemes combined with a harmonious fluid grid with an attractive mobile approach and impeccable polish in every detail. Is excellent for a news, newspaper, magazine or publishing site. It�s fast, simple, and easy to use.

The MeisterMag Theme supports the following features:

 - Responsive Layout
 - Theme Customizer
 - Custom Menus
 - Post Thumbnails
 - Page/Post Navigation
 - 3 widgetized areas in the Footer
 - Customisable Homepage
 - Customisable Footer
 - Translation Ready
 - Child Theme Ready

== Installation ==

1. Upload the MeisterMag Theme folder to your wp-content/themes folder.
2. Activate the theme from the WP Dashboard.
3. Done!

* WordPress Installation

1. In your WordPress admin panel, go to Appearance -> Themes and click the 'Add New' button then the 'Upload Theme' button.
2. Choose the MeisterMag .zip theme file and press the 'Install Now' button to begin the theme installation.
3. Click on the 'Activate' button to use your new theme right away.
4. Navigate to Appearance > Customize in your admin panel and customize it to your tastes.

== Copyright ==

MeisterMag WordPress theme, Copyright (C) 2017 tagDiv
MeisterMag WordPress theme is licensed under the GNU General Public License v2 or later

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

The MeisterMag Theme bundles the following third-party resources:

HTML5 Shiv v3.7.3, Copyright 2014 Alexander Farkas | @afarkas @jdalton @jon_neal @rem |
Licenses: MIT/GPL2
Source: https://github.com/aFarkas/html5shiv

Supersubs v0.3b - jQuery plugin, Copyright (c) 2013 Joel Birch
Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
Source: http://nerdyjs.com/script/44310

Normalize CSS | normalize.css v3.0.2 | MIT License | git.io/normalize

Images used in screenshot.png:

1. A photo by jeshoots ( https://unsplash.com/photos/XzoSKULTDWI ), http://jeshoots.com/
1. A photo by Nasa ( https://unsplash.com/photos/yZygONrUBe8 ), https://www.nasa.gov/
2. A photo by Rami Al-zayat ( https://unsplash.com/photos/w33-zg-dNL4 )

== Changelog ==
= v1.2 =
* NEW: Theme Color Settings. The Theme Accent Color and the Text Logo Color can now be changed using the WordPress Theme Customizer.
* NEW: Page Templates. We have added 3 new predefined page templates which can be set on any page.
* NEW: New theme blocks, modules and thumbs
* NEW: Theme API now supports css generator
* NEW: New style for the modules 'Read More' button
* Update: Better animation for search form input fields on focus
* Update: Footer Copyright default text
* Update: Various other minor CSS fixes
* Update: Updated the Theme language .pot file

== Changelog ==
= v1.1.1 =
* Update: Theme Description
* Update: Preview Demo Improvements

== Changelog ==
= v1.1 =
* Fix: Droid Sans font was loaded but it was used only in one place, we removed the font dependency from the theme.
* Fix: Footer text logo was not working as expected. We now fixed it and we aligned it better.
* Fix: Double search box issue on the search page. The theme always has available a search button in the main menu so another search form on the search page is not needed.
* Update: Updated screenshot.png
* Update: Preview Demo Improvements

= v1.0.9 =
* Fix: Removed theme mbstring support ( already handled by WordPress )

= v1.0.8 =
* Fix: Removed the header custom search form and replaced it with get_search_form()
* Fix: Changed sanitization for simple text fields to sanitize_text_field()
* Fix: Added prefixing for localized object screenReaderText
* Fix: Now the excerpt_length filter will not affect the admin side

= v1.0.7 =
* Update: Removed the Theme Author URI

= v1.0.6 =
* Update: Theme Author URI

= v1.0.5 =
* Fix: Addressed and fixed multiple data escaping issues
* Fix: main header menu search design issue
* Update: string translation in comments.php

= v1.0.4 =
* Fix: comments.php & template-home.php > WordPress globals overriding
* Fix: escaped author meta and no-thumb img url data in template-tags.php
* Fix: fixed main menu fallback
* Update: updated screenshot

= v1.0.3 =
* Fix: header & footer menus > no menus case
* Update: no logo > now defaults to site title
* Update: changed the dynamic_sidebar() parameter in footer
* Update: removed the footer text and contact fields
* Update: removed the footer copyright text placeholder default
* Update: removed @package comments
* Update: removed less files
* Update: added sticky-post styles
* Update: added print styles
* Update: formatting improvements
* Update: removed date for static pages in search results
* Update: changed the 404 and home template custom post query implementation

= v1.0.2 =
* Update: third party script and style handles
* Update: theme prefix
* Update: theme tags
* Update: theme readme.txt
* Update: theme screenshot
* Update: theme js/css code refactorization
* Update: added sane defaults
* Update: added child theme support
* Update: other code changes and fixes
* Fixed: theme options creating multiple rows in options table
* Fixed: untrusted data escaped before displaying
* Fixed: non translatable strings now all theme strings are translation ready.
* Fixed: comments.php silencing errors
* Fixed: changed copyright message found in theme footer
* Removed: add_filter > do_shortcode > feature considered plugin territory
* Removed: non trivial content creation from Customizer

= v1.0.1 =
* Updated Theme Description

= v1.0.0 =
* Initial release

=== Support ===

For any ideas, support and feedback you can access the theme forum.

== Notes ==

Theme Main 'Header Menu':
* The theme main menu sub items > depth levels are extending laterally, depending on user's viewport on the parent menu item position. It generally displays 3 sub items, expanding on right and once it reaches the edge it expands on the left also on top of the other, lower level, sub items.

Theme Homepage Top Block & Homepage Latest Articles
* The Top Block displays 3 random posts and the block title can be changed through WordPress Customizer.
* The Latest Articles section provides the site latest posts paginated according to WordPress's > Reading Settings > 'Blog pages show at most' setting value. This section title can also be changed through WordPress's Customizer.

Theme Footer
* The Footer provides 3 widgetised areas customizable through WordPress's widgets or Customizer widgets area.
* It also features 1 custom logo area, a copyright text area and a footer menu area, all customizable through WordPress's Customizer.

Theme Header
* Settings for logo/ site title are available through WordPress's Customizer.