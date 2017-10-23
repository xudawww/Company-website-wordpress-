/*
 *  Whiteboard64 Theme Custom Scripts
 *  Copyright (c) 2017 Whiteboard64 Theme
 *  http://www.sumanshresthaa.com.np/
 *  Licensed under MIT
 */

(function($) {  
  	//Bootstrap Carousel First Item Active
  	$('.carousel-inner .item:first-child').addClass('active');
    $('#myCarousel').carousel({
      interval: 6000,
      cycle: true
    });

  	//Pagination for Next & Previous Adding FontAwesome Icon
  	$('.nav-previous a').prepend('<i class="fa fa-angle-double-left"></i>');
  	$('.nav-next a').prepend('<i class="fa fa-angle-double-right"></i>');

  	$('.widget li a').prepend('<i class="fa fa-angle-double-right"></i>');
  	$('.footers li a').prepend('<i class="fa fa-angle-double-right"></i>');

})(jQuery);





(function($) {  
	// Activating Animations
	var wow = new WOW(
	  {
	    boxClass:     'wow',      // animated element css class (default is wow)
	    animateClass: 'animated', // animation css class (default is animated)
	    offset:       0,          // distance to the element when triggering the animation (default is 0)
	    mobile:       true,       // trigger animations on mobile devices (default is true)
	    live:         true,       // act on asynchronously loaded content (default is true)
	    callback:     function(box) {
	      // the callback is fired every time an animation is started
	      // the argument that is passed in is the DOM node being animated
	    },
	    scrollContainer: null // optional scroll container selector, otherwise use window
	  }
	);
	wow.init();
})(jQuery);



(function($) { 
	//Tab to top
	$(window).scroll(function() {
  	if ($(this).scrollTop() > 1){  
    	$('.scroll-top-wrapper').addClass("show");
  	}
  	else{
    	$('.scroll-top-wrapper').removeClass("show");
  	}
	});

	$(".scroll-top-wrapper").on("click", function() {
  	$("html, body").animate({ scrollTop: 0 }, 600);
  	return false;
	});

})(jQuery);



(function() {
  var container, button, menu, links, subMenus, i, len;

  container = document.getElementById( 'site-navigation' );
  if ( ! container ) {
    return;
  }

  button = container.getElementsByTagName( 'button' )[0];
  if ( 'undefined' === typeof button ) {
    return;
  }

  menu = container.getElementsByTagName( 'ul' )[0];

  // Hide menu toggle button if menu is empty and return early.
  if ( 'undefined' === typeof menu ) {
    button.style.display = 'none';
    return;
  }

  menu.setAttribute( 'aria-expanded', 'false' );
  if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
    menu.className += ' nav-menu';
  }

  button.onclick = function() {
    if ( -1 !== container.className.indexOf( 'toggled' ) ) {
      container.className = container.className.replace( ' toggled', '' );
      button.setAttribute( 'aria-expanded', 'false' );
      menu.setAttribute( 'aria-expanded', 'false' );
    } else {
      container.className += ' toggled';
      button.setAttribute( 'aria-expanded', 'true' );
      menu.setAttribute( 'aria-expanded', 'true' );
    }
  };

  // Get all the link elements within the menu.
  links    = menu.getElementsByTagName( 'a' );
  subMenus = menu.getElementsByTagName( 'ul' );

  // Set menu items with submenus to aria-haspopup="true".
  for ( i = 0, len = subMenus.length; i < len; i++ ) {
    subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
  }

  // Each time a menu link is focused or blurred, toggle focus.
  for ( i = 0, len = links.length; i < len; i++ ) {
    links[i].addEventListener( 'focus', toggleFocus, true );
    links[i].addEventListener( 'blur', toggleFocus, true );
  }

  /**
   * Sets or removes .focus class on an element.
   */
  function toggleFocus() {
    var self = this;

    // Move up through the ancestors of the current link until we hit .nav-menu.
    while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

      // On li elements toggle the class .focus.
      if ( 'li' === self.tagName.toLowerCase() ) {
        if ( -1 !== self.className.indexOf( 'focus' ) ) {
          self.className = self.className.replace( ' focus', '' );
        } else {
          self.className += ' focus';
        }
      }

      self = self.parentElement;
    }
  }
} )();