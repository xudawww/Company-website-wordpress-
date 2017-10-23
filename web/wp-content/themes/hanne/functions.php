<?php
/**
 * hanne functions and definitions
 *
 * @package hanne
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'hanne_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hanne_setup() {


	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 *
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	
	//Custom Logo
	add_theme_support( 'custom-logo' );
	
	
	//RT Slider Support
	add_theme_support( 'rt-slider' );
	

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'hanne' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'hanne_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	
	add_image_size('hanne-pop-thumb',542, 340, true );
	add_image_size('hanne-thumb',600, 600, true );
	add_image_size('hanne-slider-thumb',860, 430, true );
}
endif; // hanne_setup
add_action( 'after_setup_theme', 'hanne_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function hanne_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'hanne' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title title-font">',
		'after_title'   => '</h1>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer 1', 'hanne' ), /* Primary Sidebar for Everywhere else */
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title title-font">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'hanne' ), /* Primary Sidebar for Everywhere else */
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title title-font">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'hanne' ), /* Primary Sidebar for Everywhere else */
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title title-font">',
		'after_title'   => '</h1>',
	) );
	
}
add_action( 'widgets_init', 'hanne_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function hanne_scripts() {
	wp_enqueue_style( 'hanne-style', get_stylesheet_uri() );
	
	wp_enqueue_style('hanne-title-font', '//fonts.googleapis.com/css?family='.str_replace(" ", "+", get_theme_mod('hanne_title_font', 'Nunito') ).':100,300,400,700' );
	
	wp_enqueue_style('hanne-body-font', '//fonts.googleapis.com/css?family='.str_replace(" ", "+", get_theme_mod('hanne_body_font', 'Alegreya') ).':100,300,400,700' );
	
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css' );
	
	wp_enqueue_style( 'nivo-slider', get_template_directory_uri() . '/assets/css/nivo-slider.css' );
	
	wp_enqueue_style( 'nivo-skin', get_template_directory_uri() . '/assets/css/nivo-default/default.css' );
	
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css' );
	
	wp_enqueue_style( 'hover-style', get_template_directory_uri() . '/assets/css/hover.min.css' );
	
	wp_enqueue_style( 'hanne-main-theme-style', get_template_directory_uri() . '/assets/css/main.css' );

	wp_enqueue_script( 'hanne-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	
	wp_enqueue_script( 'hanne-external', get_template_directory_uri() . '/js/external.js', array('jquery'), '20120206', true );

	wp_enqueue_script( 'hanne-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	wp_enqueue_script( 'hanne-custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery-masonry'), false, true );
}
add_action( 'wp_enqueue_scripts', 'hanne_scripts' );

/**
 * Enqueue Scripts for Admin
 */
function hanne_custom_wp_admin_style() {
        wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css' );
        wp_enqueue_style( 'hanne-admin_css', get_template_directory_uri() . '/assets/css/admin.css' );
}
add_action( 'customize_controls_print_styles', 'hanne_custom_wp_admin_style' );


//Function to Trim Excerpt Length & more..
function hanne_excerpt_length( $length ) {
	return 23;
}
add_filter( 'excerpt_length', 'hanne_excerpt_length', 999 );

function hanne_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'hanne_excerpt_more' );

/**
 * Hide Posts Rendered by Featured Posts Area from Main Query
 */
 
//Create an Array to Store Post Ids of all posts that have been displayed already.
$hanne_fpost_ids = array();
if ( get_theme_mod('hanne_featposts_enable') ) :
	
	$args = array( 
		'posts_per_page' => 3,
		'cat' => esc_html(get_theme_mod('hanne_featposts_cat')),
		'ignore_sticky_posts' => true,
	);
	
	$lastposts = new WP_Query($args);
	
	while ( $lastposts->have_posts() ) :
	  $lastposts->the_post(); 
	  
	  global $hanne_fpost_ids;
	  $hanne_fpost_ids[] = get_the_id(); 
	  
	 endwhile;
	 wp_reset_postdata(); 
endif;				
		
function hanne_exclude_single_posts_home($query) {		
	global $hanne_fpost_ids;

	if ($query->is_home() && $query->is_main_query()) {
	    $query->set('post__not_in', $hanne_fpost_ids);
	  }
}	
add_action('pre_get_posts', 'hanne_exclude_single_posts_home');



/**
 * Include the Custom Functions of the Theme.
 */
require get_template_directory() . '/framework/theme-functions.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Implement the Custom CSS Mods.
 */
require get_template_directory() . '/inc/css-mods.php';


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

/**
 * Recommened Slider plugins
 */
require get_template_directory() . '/framework/tgmpa.php';

