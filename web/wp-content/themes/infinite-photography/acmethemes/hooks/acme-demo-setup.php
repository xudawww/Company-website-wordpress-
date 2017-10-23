<?php
if( !function_exists( 'infinite_photography_demo_nav_data') ){
    function infinite_photography_demo_nav_data(){
        $demo_navs = array(
            'primary'  => 'Primary'
        );
        return $demo_navs;
    }
}
add_filter('acme_demo_setup_nav_data','infinite_photography_demo_nav_data');

if( !function_exists( 'infinite_photography_demo_wp_options_data') ){
    function infinite_photography_demo_wp_options_data(){
        $wp_options = array(
            'blogname'       => 'Pixel Perfect Photos',
        );
        return $wp_options;
    }
}
add_filter('acme_demo_setup_wp_options_data','infinite_photography_demo_wp_options_data');