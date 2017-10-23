<?php
/**
 * Whiteboard64 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Whiteboard64
 */

if ( ! function_exists( 'whiteboard64_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function whiteboard64_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Whiteboard64, use a find and replace
	 * to change 'whiteboard64' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'whiteboard64', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );


	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'whiteboard64' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'whiteboard64_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add theme support for custom logo feature.
	add_theme_support( 'custom-logo', array(
	   	'height'      => 75,
	   	'width'       => 350,
	   	'header-text' => array( 'site-title', 'site-description' ),
		) 
	);

	add_editor_style( array( 'css/editor-style.css', whiteboard64_fonts_url() ) );
}
endif;
add_action( 'after_setup_theme', 'whiteboard64_setup' );



if ( ! function_exists( 'whiteboard64_fonts_url' ) ) :
/**
 * Register Google fonts for whiteboard64.
 * @since whiteboard64 1.0
 * @return string Google fonts URL for the theme.
 */
function whiteboard64_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Open Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'whiteboard64' ) ) {
		$fonts[] = 'Titillium+Web:400,300,600';
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'whiteboard64' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' =>  implode( '|', $fonts ) ,
			'subset' =>  $subsets ,
		), '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;



function whiteboard64_the_custom_logo() {
   if ( function_exists( 'the_custom_logo' ) ) {
      the_custom_logo();
   }
}


add_filter( 'widget_tag_cloud_args', 'whiteboard64_tag_cloud_args' );
function whiteboard64_tag_cloud_args( $args ) {
	$args['number'] = 10; // Your extra arguments go here
	$args['largest'] = 13;
	$args['smallest'] = 13;
	$args['unit'] = 'px';
	return $args;
}

function whiteboard64_custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'whiteboard64_custom_excerpt_length', 999 );



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function whiteboard64_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'whiteboard64_content_width', 640 );
}
add_action( 'after_setup_theme', 'whiteboard64_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function whiteboard64_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'whiteboard64' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add sidebar widgets here.', 'whiteboard64' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Header-Ad-Block', 'whiteboard64' ),
		'id'            => 'header-ad-block',
		'description'   => esc_html__( 'Add Header Ad Block widget here.', 'whiteboard64' ),
		'before_widget' => '<div class="header-ad">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Homepage-Ad1-Block', 'whiteboard64' ),
		'id'            => 'homepage-ad1-block',
		'description'   => esc_html__( 'Add Homepage Ad1 Block widget here.', 'whiteboard64' ),
		'before_widget' => '<div class="block wow fadeInUp" data-wow-duration="3s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Homepage-Ad2-Block', 'whiteboard64' ),
		'id'            => 'homepage-ad2-block',
		'description'   => esc_html__( 'Add Homepage Ad2 Block widget here.', 'whiteboard64' ),
		'before_widget' => '<div class="block wow fadeInUp" data-wow-duration="3s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Homepage-Ad3-Block', 'whiteboard64' ),
		'id'            => 'homepage-ad3-block',
		'description'   => esc_html__( 'Add Homepage Ad3 Block widget here.', 'whiteboard64' ),
		'before_widget' => '<div class="block wow fadeInUp" data-wow-duration="3s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Homepage-Ad4-Block', 'whiteboard64' ),
		'id'            => 'homepage-ad4-block',
		'description'   => esc_html__( 'Add Homepage Ad4 Block widget here.', 'whiteboard64' ),
		'before_widget' => '<div class="block wow fadeInUp" data-wow-duration="3s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Homepage-Ad5-Block', 'whiteboard64' ),
		'id'            => 'homepage-ad5-block',
		'description'   => esc_html__( 'Add Homepage Ad5 Block widget here.', 'whiteboard64' ),
		'before_widget' => '<div class="block wow fadeInUp" data-wow-duration="3s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Innerpage-Ad-Block', 'whiteboard64' ),
		'id'            => 'innerpage-ad-block',
		'description'   => esc_html__( 'Add Innerpage Ad Block widget here.', 'whiteboard64' ),
		'before_widget' => '<div class="block wow fadeInUp" data-wow-duration="3s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer-Block', 'whiteboard64' ),
		'id'            => 'footer-block',
		'description'   => esc_html__( 'Add footer block widgets here.', 'whiteboard64' ),
		'before_widget' => '<div class="col-md-4 footers">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'whiteboard64_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function whiteboard64_scripts() {
	wp_enqueue_style( 'whiteboard64-style', get_stylesheet_uri() );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/css/bootstrap.css' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/fonts/font-awesome.css', array(), '4.6.3' );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), '3.4.0' );
	wp_enqueue_style( 'whiteboard64-fonts', whiteboard64_fonts_url(), array(), null );

	wp_enqueue_script( 'jquery-bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), '3.3.7', true );	
	wp_enqueue_script( 'jquery-wow', get_template_directory_uri() . '/js/wow.js', array('jquery'), '1.1.2', true );
	wp_enqueue_script( 'whiteboard64-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'whiteboard64_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';