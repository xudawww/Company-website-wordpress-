<?php
define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
require_once dirname( __FILE__ ) . '/inc/options-framework.php';

include_once('baztro.php');
include_once('includes/installs.php');
include_once('includes/core/core.php');
include_once('includes/metaboxpage.php');
include_once('includes/metaboxsingle.php');
// Implement the Custom Header feature.
require get_template_directory() . '/includes/custom-header.php';
require get_template_directory() . '/includes/customizer.php';

function digital_scripts() {
		wp_enqueue_style( 'digital-style', get_stylesheet_uri() );
		wp_enqueue_script( 'digital-nivo-slider', get_template_directory_uri() . '/js/nivo.slider.js', array('jquery') );
		wp_enqueue_style( 'digital-nivo-slider-style', get_template_directory_uri()."/css/nivo.css" );
		wp_enqueue_style( 'digital-font-awesome', get_stylesheet_directory_uri() . '/font-awesome/css/font-awesome.min.css' );
		if ( ( of_get_option('slider_enabled') != 0 ) && ( is_front_page() ||  is_home() ) )  {
		wp_enqueue_script( 'digital-custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery','digital-nivo-slider') );
	}
if ( is_rtl() ) {
	wp_enqueue_style( 'digital-rtl-css', get_template_directory_uri() . '/css/rtl.css' );
}
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	if (of_get_option('digital_favicon') != '') {
			echo '<link rel="shortcut icon" href="' . esc_url(of_get_option('digital_favicon')) . '"/>' . "\n";
	}
	//Custom css output	
		$custom_css = html_entity_decode(of_get_option('digital_customcss'));	
		wp_add_inline_style( 'digital-style', $custom_css );	
	}
add_action( 'wp_enqueue_scripts', 'digital_scripts' );

/**
 * Enqueue script for custom customize control.
 */
function digital_custom_customize_enqueue() {
	wp_enqueue_style( 'customizer-css', get_stylesheet_directory_uri() . '/css/customizer-css.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'digital_custom_customize_enqueue' );


/* ----------------------------------------------------------------------------------- */
/* Custom CSS Output
/*----------------------------------------------------------------------------------- */


function digital_css(){
	$custom_css = '

	 
	'.html_entity_decode(get_theme_mod('custom_css')).'';

	wp_add_inline_style( 'digital-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'digital_css' );


//Home Icon for Menu
	
function digital_hdmenu() {	
		echo '<ul>';
		if ('page' != get_option('show_on_front')) {
		if (is_front_page())
		$class = 'class="current_page_item home-icon"';
		else
		$class = 'class="home-icon"';
		echo '<li ' . $class . ' ><a href="'.esc_url(home_url()) . '/"><i class="fa fa-home"></i></a></li>';
		}
		wp_list_pages('title_li=');
		echo '</ul>';
}
add_filter( 'wp_nav_menu_items', 'digital_home_link', 10, 2 );

function digital_home_link($items, $args) {
	if (is_front_page())
	$class = 'class="current_page_item home-icon"';
	else
	$class = 'class="home-icon"';
	$homeMenuItem =
	'<li ' . $class . '>' .
	$args->before .
	'<a href="' .esc_url(home_url( '/' )) . '" title="Home">' .
	$args->link_before . '<i class="fa fa-home"></i>' . $args->link_after .
	'</a>' .
	$args->after .
	'</li>';
	$items = $homeMenuItem . $items;
	return $items;
}

//function to call first uploaded image in functions file
function digital_main_image() {
$files = get_children('post_parent='.get_the_ID().'&post_type=attachment
&post_mime_type=image&order=desc');
  if($files) :
    $keys = array_reverse(array_keys($files));
    $j=0;
    $num = $keys[$j];
    $image=wp_get_attachment_image($num, 'large', true);
    $imagepieces = explode('"', $image);
    $imagepath = $imagepieces[1];
    $main=wp_get_attachment_url($num);
		$template=get_template_directory();
		$the_title=get_the_title();
    print "<img src='$main' alt='$the_title' class='frame' />";
  endif;
}

function digital_post_meta_data() {
$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date updated" datetime="%3$s"><i class="fa fa-clock-o"></i>%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'digital' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'.
		'<meta itemprop="dateModified" content="' . get_the_modified_date( 'c' ) . '" />'
	);

	$byline = sprintf(
		esc_html_x( '%s', 'post author', 'digital' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '"><i class="fa fa-user"></i>' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
}

/* Enable support for post-thumbnails ********************************************/
		
	// If we want to ensure that we only call this function if
	// the user is working with WP 2.9 or higher,
	// let's instead make sure that the function exists first
	
function digital_theme_setup() { 
	 
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'defaultthumb', 390, 210, true);
		add_image_size( 'popularpost', 75, 75, true );
		add_image_size( 'latestpost', 125, 120, true );
	    load_theme_textdomain('digital', get_template_directory() . '/languages');
		add_theme_support( 'custom-logo', array(
   'height'      => 90,
   'width'       => 400,
   'header-text' => array( 'site-title', 'site-description' ),
   'flex-width' => true,
   'flex-height' => true,
) );
		add_editor_style();
		add_theme_support( 'woocommerce' );
        add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		// Setup the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'digital_custom_background_args', array(
		'default-color' => 'f7f7f7',
		'default-image' => '',
			) ) );
	
        add_theme_support('automatic-feed-links');
		
		// This theme uses wp_nav_menu() location.
		register_nav_menus(
			array(
 				'primary' => __('Top Navigation', 'digital'),
				'digital-navigation' => __('Navigation', 'digital'),				
 				'footer-menu' => __('Footer Menu', 'digital'),
				)		
				);
		
		global $content_width;
		if ( ! isset( $content_width ) ) {
		$content_width = 670;
		}
		//woocommerce theme support
		add_theme_support( 'woocommerce' );
		
	}
add_action( 'after_setup_theme', 'digital_theme_setup' );

// Digital search form
	
function digital_search_form( $form ) {
	$form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
	<div><label class="screen-reader-text" for="s">' . __( 'Search for:','digital' ) . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" />
	<input type="submit" id="searchsubmit" value="'. esc_attr__( 'Go','digital' ) .'" />
	</div>
	</form>';

	return $form;
}

add_filter( 'get_search_form', 'digital_search_form' );

/* Excerpt ********************************************/

    function digital_excerptlength_teaser($length) {
    return 10;
    }
    function digital_excerptlength_index($length) {
    return 25;
    }
    function digital_excerptmore($more) {
    return '...';
    }
    
    
    function digital_excerpt($length_callback='', $more_callback='') {
    global $post;
    add_filter('excerpt_length', $length_callback);
 
    add_filter('excerpt_more', $more_callback);
   
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = ''.$output.'';
    echo $output;
    }

/* ----------------------------------------------------------------------------------- */
/* Customize Comment Form
/*----------------------------------------------------------------------------------- */
add_filter( 'comment_form_default_fields', 'digital_comment_form_fields' );
function digital_comment_form_fields( $fields ) {
    $commenter = wp_get_current_commenter();
    
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
    
    $fields   =  array(
        'author' => '<div class="large-6 columns"><div class="row collapse prefix-radius"><div class="small-3 columns">' . '<span class="prefix"><i class="fa fa-user"></i>' . __( 'Name','digital' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</span> </div>' .
                    '<div class="small-9 columns"><input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="20"' . $aria_req . ' /></div></div></div>',
        'email'  => '<div class="large-6 columns"><div class="row collapse prefix-radius"><div class="small-3 columns">' . '<span class="prefix"><i class="fa fa-envelope-o"></i>' . __( 'Email','digital' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</span></div> ' .
                    '<div class="small-9 columns"><input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="20"' . $aria_req . ' /></div></div></div>',
        'url'    => '<div class="large-6 columns"><div class="row collapse prefix-radius"><div class="small-3 columns">' . '<span class="prefix"><i class="fa fa-external-link"></i>' . __( 'Website','digital' ) . '</span> </div>' .
                    '<div class="small-9 columns"><input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div></div></div>'        
    );
    
    return $fields;
    
    
}

/* Widgets ********************************************/

    function digital_widgets_init() {


	register_sidebar(array(
		'name' => __( 'Sidebar Right', 'digital' ),
	    'before_widget' => '<div class="box clearfloat"><div class="boxinside clearfloat">',
		'id' => 'digsidebar',
	    'after_widget' => '</div></div>',
	    'before_title' => '<h4 class="widgettitle">',
	    'after_title' => '</h4>',
	));
		register_sidebar(array(
		'name' => __( 'Header Widget', 'digital' ),
	    'before_widget' => '<div class="box clearfloat"><div class="boxinside clearfloat">',
		'id' => 'headerwid',
	    'after_widget' => '</div></div>',
	    'before_title' => '<h4 class="widgettitle">',
	    'after_title' => '</h4>',
	));
	
		register_sidebar(array(
		'name' => __( 'Below Navigation', 'digital' ),
	    'before_widget' => '<div class="box clearfloat"><div class="boxinside clearfloat">',
		'id' => 'belownavi',
	    'after_widget' => '</div></div>',
	    'before_title' => '<h4 class="widgettitle">',
	    'after_title' => '</h4>',
	));
		register_sidebar(array(
		'name' => __( 'Below Single Post Content', 'digital' ),
	    'before_widget' => '<div class="box clearfloat"><div class="boxinside clearfloat">',
		'id' => 'belowsinglepost',
	    'after_widget' => '</div></div>',
	    'before_title' => '<h4 class="widgettitle">',
	    'after_title' => '</h4>',
	));
		register_sidebar(array(
		'name' => __( 'Below Page Content', 'digital' ),
	    'before_widget' => '<div class="box clearfloat"><div class="boxinside clearfloat">',
		'id' => 'belowpagecontent',
	    'after_widget' => '</div></div>',
	    'before_title' => '<h4 class="widgettitle">',
	    'after_title' => '</h4>',
	));
	register_sidebar(array(
		'name' => __( 'Bottom Menu 1', 'digital' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'id' => 'digbottom1',
	    'after_widget' => '</div>',
	    'before_title' => '<h4>',
	    'after_title' => '</h4>',
	));

	register_sidebar(array(
		'name' => __( 'Bottom Menu 2', 'digital' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'id' => 'digbottom2',
	    'after_widget' => '</div>',
	    'before_title' => '<h4>',
	    'after_title' => '</h4>',
	));	

	register_sidebar(array(
		'name' => __( 'Bottom Menu 3', 'digital' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'id' => 'digbottom3',
	    'after_widget' => '</div>',
	    'before_title' => '<h4>',
	    'after_title' => '</h4>',
	));	

	
}
add_action('widgets_init', 'digital_widgets_init');
//---------------------------- [ Pagenavi Function ] ------------------------------//

function digital_pagination() {
	global $wp_query;
	$big = 123456789;
	$page_format = paginate_links( array(
	    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	    'format' => '?paged=%#%',
	    'current' => max( 1, get_query_var('paged') ),
	    'total' => $wp_query->max_num_pages,
	    'type'  => 'array'
	) );
	if( is_array($page_format) ) {
	            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
	            echo '<div class="wp-pagenavi">';
	            echo '<span class="pages">'. $paged . ' of ' . $wp_query->max_num_pages .'</span>';
	            foreach ( $page_format as $page ) {
	                    echo "$page";
	            }
	           echo '</div>';
	 }
}

//Require Plugins

require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'digital_register_required_plugins' );

function digital_register_required_plugins() {

   $plugins = array(

	
		
		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'      => 'Regenerate Thumbnails',
			'slug'      => 'regenerate-thumbnails',
			'required'  => false,
		),
		array(
			'name'      => 'Menu Icons',
			'slug'      => 'menu-icons',
			'required'  => false,
		),
		array(
			'name'      => 'Shortcodes Ultimate',
			'slug'      => 'shortcodes-ultimate',
			'required'  => false,
		),

	);


	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.


);	tgmpa( $plugins, $config );

}



if ( ! function_exists( 'digital_site_title' ) ) :
/**
 * Displays the site title in the header area
 */
function digital_site_title() {
	if ( is_front_page() && is_home() ) : ?>
		<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

	<?php else : ?>

		<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>

	<?php endif;
}
endif;

if ( ! function_exists( 'digital_site_description' ) ) :
/**
 * Displays the site description in the header area
 */
function digital_site_description() {
	$description = get_bloginfo( 'description', 'display' ); /* WPCS: xss ok. */

	if ( $description || is_customize_preview() ) : ?>

		<p class="site-description"><?php echo $description; ?></p>

	<?php
	endif;
}
endif;
?>