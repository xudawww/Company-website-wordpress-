<?php

/**
 * The theme's css generator API
 * Class Tagdiv_API_Css_Generator
 *
 * @since MeisterMag 1.2
 */

class Tagdiv_API_Css_Generator {

    private static $css_buffer = '';
    private static $used = false;

    static function add($css_id, $css = '') {
        if (self::$used === true) {
            Tagdiv_Util::tagdiv_wp_booster_error( __FILE__, __( '<b>td_api_css_generator::add</b> - the get_all method was already called', 'meistermag' ) );
        }
        self::$css_buffer .= PHP_EOL . $css . PHP_EOL;
    }


    static function get_all() {
        self::$used = true;
        return self::$css_buffer;
    }


}