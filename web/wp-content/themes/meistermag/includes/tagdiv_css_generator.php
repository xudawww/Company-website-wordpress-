<?php
/**
 * theme css generator function
 *
 * @return string
 */
function tagdiv_css_generator() {

    $tagdiv_raw_css = '
    /* @tagdiv_accent_color */

    .tagdiv-search-box-wrap .tagdiv-drop-down-search .btn:hover,
    .tagdiv-sf-menu > .current-menu-item > a,
    .tagdiv-sf-menu > .current-menu-ancestor > a,
    .tagdiv-sf-menu > .current-category-ancestor > a,
    .tagdiv-sf-menu > li > a:hover,
    .tagdiv-sf-menu > .sfHover > a,
    .tagdiv-sf-menu ul .menu-item > a:hover,
    .tagdiv-sf-menu ul .sfHover > a,
    .tagdiv-sf-menu ul .current-menu-ancestor > a,
    .tagdiv-sf-menu ul .current-category-ancestor > a,
    .tagdiv-sf-menu ul .current-menu-item > a,
    .tagdiv-header-menu-search #tagdiv-header-search-button .tagdiv-icon-search:hover,
    a,
    a:hover,
    a:active,
    cite a:hover,
    .tagdiv-excerpt p .tagdiv-more-link:hover,
    .tagdiv-post-author-name a:hover,
    .tagdiv-page-content a:hover,
    .tagdiv-post-content a:hover,
    .tagdiv-page-content blockquote p,
    .tagdiv-post-content blockquote p,
    .comment-content blockquote p,
    .commentlist .bypostauthor,
    .tagdiv-module-comments a:hover,
    .tagdiv-post-comments a:hover,
    .tagdiv-module-wrap:hover .tagdiv-entry-title a,
    .tagdiv-search-header .tagdiv-search-query,
    .tagdiv-post-tags .tagdiv-tags span,
    .tagdiv-post-tags .tagdiv-tags a:hover,
    .tagdiv-post-next-prev-content .tagdiv-prev-art,
    .tagdiv-post-next-prev-content .tagdiv-next-art,
    .tagdiv-post-next-prev-content a:hover,
    .tagdiv-author-name a:hover,
    .tagdiv-author-url a:hover,
    .logged-in-as a:hover,
    .comment-reply-link,
    #cancel-comment-reply-link:hover,
    .widget a:hover,
    .widget .current-menu-item a,
    .widget_calendar tbody a,
    .widget_calendar tfoot a:hover,
    .widget_categories li:hover > a,
    .tagdiv-footer-wrapper a:hover,
    .tagdiv-subfooter-menu .menu-item > a:hover,
    .tagdiv-subfooter-menu .current-menu-ancestor > a,
    .tagdiv-subfooter-menu .current-category-ancestor > a,
    .tagdiv-subfooter-menu .current-menu-item > a,
    .tagdiv-sub-footer-copy i,
    #searchsubmit:hover,
    input.search-submit:hover,
    button.search-submit:hover,
    .screen-reader-text:hover,
    .screen-reader-text:active,
    .screen-reader-text:focus {
      color: @tagdiv_accent_color;
    }


    ins,
    input[type=submit]:hover,
    .tagdiv-entry-title:after,
    .tagdiv-post-category:hover,
    .tagdiv-block-title:after,
    .tagdiv-post-header .tagdiv-category a:hover,
    .single .page-nav > div,
    .page .page-nav > div,
    .tagdiv-author-name:after,
    .page-nav .current,
    .tagdiv-404-title:after,
    .tagdiv-comments-title-wrap h4:after,
    .comment-reply-title:after,
    .widget_calendar #today,
    .search-form .tagdiv-search-input-bar {
        background-color: @tagdiv_accent_color;
    }


    .tagdiv-post-tags .tagdiv-tags span,
    .widget_categories li:hover a span:before {
        border-color: @tagdiv_accent_color;
    }

    *:focus {
        outline-color: @tagdiv_accent_color;
    }

    /* @tagdiv_text_logo_color */
    .tagdiv-header-style .tagdiv-header-logo a {
        color: @tagdiv_text_logo_color;
    }

    ';

    $tagdiv_css_compiler = new Tagdiv_Css_Compiler( $tagdiv_raw_css );

    // load the user settings
    $tagdiv_css_compiler->load_setting('tagdiv_accent_color');
    $tagdiv_css_compiler->load_setting('tagdiv_text_logo_color');

    //output the style
    return $tagdiv_css_compiler->compile_css();

}