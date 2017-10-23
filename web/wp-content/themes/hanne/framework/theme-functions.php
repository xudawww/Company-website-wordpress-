<?php
/*
 * @package hanne, Copyright Rohit Tripathi, rohitink.com
 * This file contains Custom Theme Related Functions.
 */
 
/*
** Walkers for Navigation menus
*/ 
//Supports Menu Desc and Icons Both 
class Hanne_Menu_With_Description extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$fontIcon = ! empty( $item->attr_title ) ? ' <i class="fa ' . esc_attr( $item->attr_title ) .'">' : '';
		$attributes = ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_url( $item->url ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>'.$fontIcon.'</i>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '<br /><span class="menu-desc">' . $item->description . '</span>';
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );
	}
}
//Supports Icon only. No Description.
class Hanne_Menu_With_Icon extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$fontIcon = ! empty( $item->attr_title ) ? ' <i class="fa ' . esc_attr( $item->attr_title ) .'">' : '';
		$attributes = ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_url( $item->url ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>'.$fontIcon.'</i>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );
	}
}

/*
** Customizer Controls 
*/
if (class_exists('WP_Customize_Control')) {
	class Hanne_WP_Customize_Category_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         */
        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'              => '_customize-dropdown-categories-' . $this->id,
                    'echo'              => 0,
                    'show_option_none'  => __( '&mdash; Select &mdash;', 'hanne' ),
                    'option_none_value' => '0',
                    'selected'          => $this->value(),
                )
            );
 
            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
 
            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );
        }
    }
}  

if (class_exists('WP_Customize_Control')) {
	class Hanne_WP_Customize_Upgrade_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         */
        public function render_content() {
             printf(
                '<label class="customize-control-upgrade"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $this->description
            );
        }
    }
}
  
/*
** Function to check if Sidebar is enabled on Current Page 
*/

function hanne_load_sidebar() {
	$load_sidebar = true;
	if ( get_theme_mod('hanne_disable_sidebar') ) :
		$load_sidebar = false;
	elseif( get_theme_mod('hanne_disable_sidebar_home',true) && is_home() )	:
		$load_sidebar = false;
	elseif( get_theme_mod('hanne_disable_sidebar_front',true) && is_front_page() ) :
		$load_sidebar = false;
	endif;
	
	return  $load_sidebar;
}

/*
** Add Body Class
*/
function hanne_body_class( $classes ) {
	
	$sidebar_class_name =  hanne_load_sidebar() ? "sidebar-enabled" : "sidebar-disabled" ;
    return array_merge( $classes, array( $sidebar_class_name ) );   
}
add_filter( 'body_class', 'hanne_body_class' );


/*
**	Determining Sidebar and Primary Width
*/
function hanne_primary_class() {
	$sw = esc_html(get_theme_mod('hanne_sidebar_width',4));
	$class = "col-md-".(12-$sw);
	
	if ( !hanne_load_sidebar() ) 
		$class = "col-md-12";
	
	echo $class;
}
add_action('hanne_primary-width', 'hanne_primary_class');

function hanne_secondary_class() {
	$sw = esc_html(get_theme_mod('hanne_sidebar_width',4));
	$class = "col-md-".$sw;
	
	echo $class;
}
add_action('hanne_secondary-width', 'hanne_secondary_class');


/*
**	Helper Function to Convert Colors
*/
function hanne_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return implode(",", $rgb); // returns the rgb values separated by commas
   //return $rgb; // returns an array with the rgb values
}
function hanne_fade($color, $val) {
	return "rgba(".hanne_hex2rgb($color).",". $val.")";
}


/*
** Function to Get Theme Layout 
*/
function hanne_get_blog_layout(){
	$ldir = 'framework/layouts/content';
	if (get_theme_mod('hanne_blog_layout') ) :
		get_template_part( $ldir , get_theme_mod('hanne_blog_layout') );
	else :
		get_template_part( $ldir ,'hanne');	
	endif;	
}
add_action('hanne_blog_layout', 'hanne_get_blog_layout');

/*
** Function to Set Masonry Class 
*/
function hanne_set_masonry_class(){
	if ( get_theme_mod('hanne_blog_layout','hanne') != "hanne" ) :
		//DO NOTHING
	else :
		echo "masonry-main";	
	endif;	
}
add_action('hanne_masonry_class', 'hanne_set_masonry_class');

/*
** Load Custom Widgets
*/

require get_template_directory() . '/framework/widgets/recent-posts.php';


