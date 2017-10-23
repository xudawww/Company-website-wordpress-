/* global jQuery:{} */
/* global tagdivScreenReaderText */

/**
 * Mobile menu handler
 * Menu handler for screen readers
 */
( function() {
    'use strict';

    jQuery('.tagdiv-search-wrap-mob').find('#tagdiv-header-search').removeAttr('placeholder');

    //handles open/close mobile menu
    jQuery( '#tagdiv-top-mobile-toggle a, .tagdiv-mobile-close a' ).click( function() {

        var body = jQuery( 'body'),
            html = jQuery( document ).find( 'html');

        if ( body.hasClass( 'tagdiv-menu-mob-open-menu' ) ) {
            body.removeClass( 'tagdiv-menu-mob-open-menu' );
            html.removeClass( 'tagdiv-mobile-menu-search-open' );
        } else {
            body.addClass( 'tagdiv-menu-mob-open-menu' );
            html.addClass( 'tagdiv-mobile-menu-search-open' );
        }
    });

    //move through all the menu and find the item with sub-menues to atach a custom class to them
    jQuery( document ).find( '#tagdiv-mobile-nav .menu-item-has-children' ).each( function( i ) {

        var class_name = 'tagdiv_mobile_elem_with_submenu_' + i;
        jQuery( this ).addClass( class_name );

        //click on link elements with #
        jQuery( this ).children( 'a' ).addClass( 'tagdiv-link-element-after' );

        jQuery( this ).children( 'a' ).append( jQuery( '<span />', {
            'class': 'screen-reader-text',
            text: tagdivScreenReaderText.expand
        } ) );

        jQuery( this ).click( function( event ) {

            /**
             * currentTarget - the li element
             * target - the element clicked inside of the currentTarget
             */

            var jQueryTarget = jQuery( event.target );

            // html i element
            if ( jQueryTarget.length &&
                ( ( jQueryTarget.hasClass( 'tagdiv-element-after') || jQueryTarget.hasClass( 'tagdiv-link-element-after') ) &&
                ( '#' === jQueryTarget.attr( 'href' ) || undefined === jQueryTarget.attr( 'href' ) ) ) ) {

                event.preventDefault();
                event.stopPropagation();

                jQuery( this ).toggleClass( 'tagdiv-sub-menu-open' );

                if ( jQuery( this ).hasClass( 'tagdiv-sub-menu-open' ) ) {
                    jQuery( this ).children( 'a' ).find( '.screen-reader-text' ).remove();
                    jQuery( this ).children( 'a' ).append( jQuery( '<span />', {
                        'class': 'screen-reader-text',
                        text: tagdivScreenReaderText.collapse
                    } ) );
                } else {
                    jQuery( this ).children( 'a' ).find( '.screen-reader-text' ).remove();
                    jQuery( this ).children( 'a' ).append( jQuery( '<span />', {
                        'class': 'screen-reader-text',
                        text: tagdivScreenReaderText.expand
                    } ) );
                }
            }
        });
    });

} )();

/**
 *   Set the mobile menu min-height property
 *
 *   This is used to force vertical scroll bar appearance from the beginning.
 *   Without it, on some mobile devices, at scroll bar appearance also appear some visual issues.
 */

( function () {
    'use strict';

    jQuery( window ).resize( function() {

        var window_innerHeight = window.innerHeight; // used to store the window height

        var tagdivMobileMenu = jQuery( '#tagdiv-mobile-nav' ),
            cssHeight = window_innerHeight + 1;

        if ( tagdivMobileMenu.length ) {
            tagdivMobileMenu.css( 'min-height', cssHeight + 'px' );
        }

        var tagdivMobileBg = jQuery( '.tagdiv-menu-background' ),
            tagdivMobileBgSearch = jQuery( '.tagdiv-search-background' );

        if ( tagdivMobileBg.length ) {
            tagdivMobileBg.css( 'height', ( cssHeight + 70 ) + 'px' );
        }

        if ( tagdivMobileBgSearch.length ) {
            tagdivMobileBgSearch.css( 'height', ( cssHeight + 70 ) + 'px' );
        }

    });

} )();



