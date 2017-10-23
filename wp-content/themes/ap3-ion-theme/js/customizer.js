/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	menuContent = $('body.ion-ap3 #menu-content');

	// add header just for customizer
	$(menuContent).prepend('<header class="bar bar-header"><div class="buttons"><button id="nav-left-open" class="nav-left-btn button button-icon icon ion-navicon"></button></div></header>').addClass('menu-closed');

	$('#nav-left-open').on( 'click', function() {
		if( $(menuContent).hasClass('menu-closed') ) {
			$(menuContent).css('transform','translate3d(275px, 0px, 0px)').removeClass('menu-closed');
		} else {
			$(menuContent).css('transform','').addClass('menu-closed');
		}
	});


	// Get menu items
	var menuId = parent.window.jQuery('#customize-control-nav_menu_locations-primary-menu option:selected').val();
	
	$.ajax({ 
		url: apppCore.home_url + '/wp-json/ap3/v1/menus/' + menuId, 
	}).done( function(data) {

		var items = data.items;

		// console.log(items);

		var menu = '<div class="menu menu-left menu-layer"><div class="bar bar-header"><div class="title"></div></div><div class="scroll-content ionic-scroll has-header"><div class="scroll"><ul class="list">';

		for (var i = 0; i <= items.length - 1; i++) {
			console.log( items[i] );
			var title = (items[i].title ? items[i].title : 'Undefined');
			var icon = (items[i].classes ? '<i class="icon ion-ios-' + items[i].classes + '"></i>' : '');
			menu += '<li class="item"><a href="#">' + icon + title + '</a></li>';
		}

		menu += '</ul></div></div></div>';

		$('body.ion-ap3 #body-container').prepend(menu);

	});

	$('body.ion-ap3 #main').css('top','44px');

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' == to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
		} );
	} );
} )( jQuery );