<?php
/**
 * Dynamic css
 *
 * @since infinite-photography 1.1.0
 *
 * @param null
 * @return null
 *
 */
if ( ! function_exists( 'infinite_photography_dynamic_css' ) ) :

    function infinite_photography_dynamic_css() {

        global $infinite_photography_customizer_all_values;
        /*Color options */
        $infinite_photography_primary_color = esc_attr( $infinite_photography_customizer_all_values['infinite-photography-primary-color'] );
        $infinite_photography_header_height = absint( $infinite_photography_customizer_all_values['infinite-photography-header-height'] );
        $custom_css = '';
        /*background*/
        $custom_css .= "
            mark,
            .comment-form .form-submit input,
            .slider-section .cat-links a,
            #calendar_wrap #wp-calendar #today,
            #calendar_wrap #wp-calendar #today a,
            .wpcf7-form input.wpcf7-submit:hover,
            .breadcrumb,
            .at-icon-link > a {
                background: {$infinite_photography_primary_color};
            }";
        /*color*/
        $custom_css .= "
            a:hover,
            .header-wrapper .menu li a:hover,
            .screen-reader-text:focus,
            .bn-content a:hover,
            .socials a:hover,
            .site-title a,
            .widget_search input#s,
            .besides-slider .post-title a:hover,
            .slider-feature-wrap a:hover,
            .slider-section .bx-controls-direction a,
            .besides-slider .beside-post:hover .beside-caption,
            .besides-slider .beside-post:hover .beside-caption a:hover,
            .featured-desc .above-entry-meta span:hover,
            .posted-on a:hover,
            .cat-links a:hover,
            .comments-link a:hover,
            .edit-link a:hover,
            .tags-links a:hover,
            .byline a:hover,
            .nav-links a:hover,
            #infinite-photography-breadcrumbs a:hover,
            .wpcf7-form input.wpcf7-submit,
            .widget li a:hover,
            .header-wrapper .menu > li.current-menu-item > a,
            .header-wrapper .menu > li.current-menu-parent > a,
            .header-wrapper .menu > li.current_page_parent > a,
            .header-wrapper .menu > li.current_page_ancestor > a,
            .search-icon-menu:hover{
                color: {$infinite_photography_primary_color};
            }";

        /*border*/
         $custom_css .= "
         .nav-links .nav-previous a:hover,
            .nav-links .nav-next a:hover{
                border-top: 1px solid {$infinite_photography_primary_color};
            }
            .besides-slider .beside-post{
                border-bottom: 3px solid {$infinite_photography_primary_color};
            }
            .page-header .page-title,
            .entry-header .entry-title{
                border-bottom: 1px solid {$infinite_photography_primary_color};
            }
            .page-header .page-title:before,
            .entry-header .entry-title:before{
                border-bottom: 7px solid {$infinite_photography_primary_color};
            }
            .wpcf7-form input.wpcf7-submit:hover,
            article.post.sticky .post-item,
            .comment-form .form-submit input,
            .read-more:hover{
                border: 2px solid {$infinite_photography_primary_color};
            }
            .breadcrumb::after {
                border-left: 5px solid {$infinite_photography_primary_color};
            }
            .tagcloud a{
                border: 1px solid {$infinite_photography_primary_color};
            }
            .widget-title{
                border-bottom: 2px solid {$infinite_photography_primary_color};
            }
         ";
        /*media width*/
        $custom_css .= "
            @media screen and (max-width:992px){
                .slicknav_btn.slicknav_open{
                    border: 1px solid {$infinite_photography_primary_color};
                }
                .slicknav_btn.slicknav_open:before{
                    background: {$infinite_photography_primary_color};
                    box-shadow: 0 6px 0 0 {$infinite_photography_primary_color}, 0 12px 0 0 {$infinite_photography_primary_color};
                }
                .slicknav_nav li:hover > a,
                .slicknav_nav li.current-menu-ancestor a,
                .slicknav_nav li.current-menu-item  > a,
                .slicknav_nav li.current_page_item a,
                .slicknav_nav li.current_page_item .slicknav_item span,
                .slicknav_nav li .slicknav_item:hover a{
                    color: {$infinite_photography_primary_color};
                }
            }";
        /*header-height*/
	    $bg_image_url = esc_url( get_template_directory_uri()."/assets/img/banner-image.jpg" );
	    if( get_header_image() ){
		    $bg_image_url = esc_url( get_header_image() );
	    }
	    $custom_css .= "
              .inner-header-image{
                background-image:url('{$bg_image_url}');
                background-repeat:no-repeat;
                background-size:cover;
                background-attachment:fixed;
                background-position: center; 
                height: {$infinite_photography_header_height}px;
            }";

        /*custom css*/
        $infinite_photography_custom_css = wp_filter_nohtml_kses ( $infinite_photography_customizer_all_values['infinite-photography-custom-css'] );
        if ( ! empty( $infinite_photography_custom_css ) ) {
            $custom_css .= $infinite_photography_custom_css;
        }
        wp_add_inline_style( 'infinite-photography-style', $custom_css );

    }
endif;
add_action( 'wp_enqueue_scripts', 'infinite_photography_dynamic_css', 99 );