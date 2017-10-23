<?php

/**
 * theme menu support
 *
 * @since MeisterMag 1.0
 */

class Tagdiv_Menu {

    function __construct() {
        add_action( 'init', array( $this, 'tagdiv_hook_on_init' ) );
        add_filter( 'wp_nav_menu_objects', array( $this, 'tagdiv_hook_on_wp_nav_menu_objects' ),  10, 2);
    }

    function tagdiv_hook_on_wp_nav_menu_objects( $items ) {

        /**
         * Internal array to keep the references of the items ( ID item is the key -> item itself )
         * This helps to not look for an item into the $items list
         */
        $_items_ref  = array();
        $items_buffy = array();

        foreach ( $items as &$item ) {

            $_items_ref[ $item->ID ] = $item;
            $items_buffy[]           = $item;

            /**
             * - Because 'current_item_parent' ( true/false ) item property is not set by wp,
             *   we use an additional flag 'tagdiv_is_parent' to mark the parent elements of the tree menu
             *
             * - The 'tagdiv_is_parent' flag is used just by the 'Tagdiv_Walker_Mobile_Menu'
             *   walker of the mobile theme version @see Tagdiv_Walker_Mobile_Menu
             */

            if ( isset( $item->menu_item_parent ) && 0 !== intval( $item->menu_item_parent ) && array_key_exists( intval( $item->menu_item_parent ), $_items_ref ) ) {
                $_items_ref[ intval( $item->menu_item_parent ) ]->tagdiv_is_parent = true;
            }

        }

        return $items_buffy;
    }

    function tagdiv_hook_on_init() {
        register_nav_menus(
            array(
                'header-menu' => __( 'Header Menu (main)', 'meistermag' ),
                'footer-menu' => __( 'Footer Menu', 'meistermag' )
            )
        );
    }

} //end class Tagdiv_Menu

new Tagdiv_Menu();


class Tagdiv_Walker_Mobile_Menu extends Walker_Nav_Menu {

    /**
     * Starts the element output. > this method overwrites the parent @see Walker::start_el()
     *
     * @since 3.0.0
     * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
     *
     *
     *
     * @param string   $output Passed by reference. Used to append additional content.
     * @param WP_Post  $item   Menu item data object.
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     * @param int      $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        /**
         * Filter the CSS class(es) applied to a menu item's list item element.
         *
         * @since 3.0.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        /**
         * Filter the ID applied to a menu item's list item element.
         *
         * @since 3.0.1
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        /**
         * Filter the HTML attributes applied to a menu item's anchor element.
         *
         * @since 3.6.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         *     @type string $title  Title attribute.
         *     @type string $target Target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param object $item  The current menu item.
         * @param array  $args  An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );


        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }


        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );

        /**
         * Tagdiv: the $link_after of args is added for parent items
         */
        if (isset( $item->tagdiv_is_parent ) && true === $item->tagdiv_is_parent ) {
            $item_output .= $args->link_after;
        }

        $item_output .= '</a>';
        $item_output .= $args->after;

        /**
         * Filter a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since MeisterMag 1.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of {@see wp_nav_menu()} arguments.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
} //end class Tagdiv_Walker_Mobile_Menu