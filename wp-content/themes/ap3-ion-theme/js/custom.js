(function(window, document, $, undefined){
	'use strict';

	// Initiate our object and vars
	var app = {
		// make sure localize_script is called (or bail)
		appp               : typeof window.appp !== 'undefined' ? window.appp : false,
		// Check for woocommerce plugin
		woo                : typeof window.apppwoo !== 'undefined' ? window.apppwoo : false,
		appbuddy           : {},
		spinner            : null,
		xhr                : [],
		timeout            : false,
		isWidth600         : true,
		$                  : {},
		modalID 			: '',
		push_custom_ajax   : {url:'',isPopup:false},
		push_custom_noajax : {url:'',isPopup:false},
	};

	app.cacheSelectors = function() {
		app.$.body        = $('body');
		app.$.main        = $('#main');
		app.$.modalInside = $('.modal-inside');
		app.$.ioModal     = $('.io-modal');

		app.UpClasses   = 'slide-in-up-add ng-animate slide-in-up slide-in-up-add-active';
		app.downClasses = 'slide-in-up-remove slide-in-up-remove-active';
		app.dragging = false;
		app.browserDebug = false;
		app.isDevice = false;
	};

	app.init = function() {

		// test if we are on a device
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		 app.isDevice = true;
		}

		app.cacheSelectors();

		var isWidth600Check;

		if ( ! app.appp )
			return;

		if(parent) {
			// Message our frame so we know when to run scripts
			parent.postMessage( 'site_loaded', '*');
			app.isLoggedIn();
		}

		if( $('body').hasClass('activity') || $('body').hasClass('group-home') ) {
			parent.postMessage( 'activity_modal', '*');
		}

		// still having some issues with this, commenting out for now
		// if( $('body').hasClass('single-post') ) {
		// 	// shows share button and title on single post pages
		// 	parent.postMessage( JSON.stringify( { post_title: window.appp.post_title, post_url: window.appp.post_url } ), '*');
		// }

		// app.logGroup( 'apppresser.init()' );

		app.log( 'window.appp', app.appp );
		app.log( 'window.apppwoo', app.woo );

		// Load spinner
		app.$.body.append('<div class="ajax-spinner"><ion-spinner icon="ios" class="spinner spinner-ios"><svg viewBox="0 0 64 64"><g stroke-width="4" stroke-linecap="round"><line y1="17" y2="29" transform="translate(32,32) rotate(180)"><animate attributeName="stroke-opacity" dur="750ms" values="1;.85;.7;.65;.55;.45;.35;.25;.15;.1;0;1" repeatCount="indefinite"></animate></line><line y1="17" y2="29" transform="translate(32,32) rotate(210)"><animate attributeName="stroke-opacity" dur="750ms" values="0;1;.85;.7;.65;.55;.45;.35;.25;.15;.1;0" repeatCount="indefinite"></animate></line><line y1="17" y2="29" transform="translate(32,32) rotate(240)"><animate attributeName="stroke-opacity" dur="750ms" values=".1;0;1;.85;.7;.65;.55;.45;.35;.25;.15;.1" repeatCount="indefinite"></animate></line><line y1="17" y2="29" transform="translate(32,32) rotate(270)"><animate attributeName="stroke-opacity" dur="750ms" values=".15;.1;0;1;.85;.7;.65;.55;.45;.35;.25;.15" repeatCount="indefinite"></animate></line><line y1="17" y2="29" transform="translate(32,32) rotate(300)"><animate attributeName="stroke-opacity" dur="750ms" values=".25;.15;.1;0;1;.85;.7;.65;.55;.45;.35;.25" repeatCount="indefinite"></animate></line><line y1="17" y2="29" transform="translate(32,32) rotate(330)"><animate attributeName="stroke-opacity" dur="750ms" values=".35;.25;.15;.1;0;1;.85;.7;.65;.55;.45;.35" repeatCount="indefinite"></animate></line><line y1="17" y2="29" transform="translate(32,32) rotate(0)"><animate attributeName="stroke-opacity" dur="750ms" values=".45;.35;.25;.15;.1;0;1;.85;.7;.65;.55;.45" repeatCount="indefinite"></animate></line><line y1="17" y2="29" transform="translate(32,32) rotate(30)"><animate attributeName="stroke-opacity" dur="750ms" values=".55;.45;.35;.25;.15;.1;0;1;.85;.7;.65;.55" repeatCount="indefinite"></animate></line><line y1="17" y2="29" transform="translate(32,32) rotate(60)"><animate attributeName="stroke-opacity" dur="750ms" values=".65;.55;.45;.35;.25;.15;.1;0;1;.85;.7;.65" repeatCount="indefinite"></animate></line><line y1="17" y2="29" transform="translate(32,32) rotate(90)"><animate attributeName="stroke-opacity" dur="750ms" values=".7;.65;.55;.45;.35;.25;.15;.1;0;1;.85;.7" repeatCount="indefinite"></animate></line><line y1="17" y2="29" transform="translate(32,32) rotate(120)"><animate attributeName="stroke-opacity" dur="750ms" values=".85;.7;.65;.55;.45;.35;.25;.15;.1;0;1;.85" repeatCount="indefinite"></animate></line><line y1="17" y2="29" transform="translate(32,32) rotate(150)"><animate attributeName="stroke-opacity" dur="750ms" values="1;.85;.7;.65;.55;.45;.35;.25;.15;.1;0;1" repeatCount="indefinite"></animate></line></g></svg></ion-spinner></div>');
		app.$.spinner = $('.ajax-spinner');

		// Check if width is > 600px
		if ( window.matchMedia ) {
			// Establishing media check
			isWidth600Check = window.matchMedia( '(min-width: 600px)' );
			// Add listener for detecting changes
			isWidth600Check.addListener( function( mediaQueryList ) {
				app.isWidth600 = mediaQueryList.matches;
				app.log( 'Width ' + ( app.isWidth600 ? '>' : '<' ) +' 600' );
			});
		}

		app.logGroup( true );

		// Setting initial values
		app.isWidth600 = isWidth600Check && isWidth600Check.matches;

		// should only run this on list pages
		app.infiniteScroll();

		app.backhref = app.woo && app.woo.is_shop ? app.woo.shop_url : app.appp.home_url;

		// Need to use click if on desktop so that page transitions work in myapppresser preview. Otherwise we use touchend on the device so there is no delay.
		if( app.isDevice ) {
			var touchorclick = 'touchend';
		} else {
			var touchorclick = 'click';
		}

		app.$.body
			// Load login screen in modal.
			.on( 'click', '.comment-reply-login', function(event) {
				event.preventDefault();
				$('.menu-left .io-modal-open').trigger('click');
			})
			/*
			* Ionic modals
			*/
			.on( 'click', '.io-modal-open, .io-modal-close', function(event) {
				event.preventDefault();

				if ( $(this).hasClass( 'io-modal-open' ) ) {

					//get href of button that matches id of modal div
					app.modalID = $(this).attr('href');

					if( app.modalID == '#loginModal') {
						$('input[name=redirect_to]').val(window.location);
					}
					
					$('#error-message').html(' ');
					// need to move .css to css file
					$(app.modalID).css('display', 'block').removeClass(app.downClasses).addClass(app.UpClasses);

				} else {

					// slide down modal and put it back in the content area.
					$('.io-modal').removeClass(app.UpClasses).addClass(app.downClasses).css('display', 'none');
					$('form').trigger("reset");
					app.$.spinner.hide();

				}
			})
			.on( 'submit', 'form#loginform', function(event) {

				var login_text = {
					processing: 'Logging in....',
					required:  'Fields are required',
					error:     'Error Logging in'
				};

				// Verify required fields
				var data = $(this).serializeArray().reduce(function(obj, item) {
						obj[item.name] = item.value;
						return obj;
					}, {});
					
				if( '' === data.log || '' === data.pwd ) {
					event.preventDefault();
					$('.io-modal #error-message').show().text(login_text.required);
					return;
				}

				// Process form: AJAX OR POST
				if( typeof appp_ajax_login !== 'undefined' ) { // AppPresser 2.0.1

					// AJAX the login

					login_text = appp_ajax_login; // text-domain

					$('.io-modal #error-message').show().text(login_text.processing);
					
					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: apppCore.ajaxurl,
						data: {
							'action': 'apppajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
							'username': $('form#loginform #user_login').val(),
							'password': $('form#loginform #user_pass').val(),
							'security': $('form#loginform #security').val(),
							'rememberme': 'forever' 
						}
					})
					.done( function(data){

						if (data.success === true) {
							var msg = data.data.message;
							$('.io-modal #error-message').text(msg);
							setTimeout(function() {
								if( typeof apppCore == 'undefined' ) {
									// desktop theme
									location.reload();
								} else {
									// Wait a second to display the login msg, better UI
									app.sendLoginMsg( 1, data.data);
									var location = document.location.href;
									document.location.href = '';

									if( $('form#loginform input[name="redirect_to"]').val() ) {
										document.location.href = $('form#loginform input[name="redirect_to"]').val();
									} else {
										document.location.href = location;
									}

								}
							}, 1000);
						} else {
							$('.io-modal #error-message').show().text(login_text.error);
						}
					}).fail( function(e){
						console.log(e);
					});

					event.preventDefault();
				} else {
					// Don't AJAX the login
					// continue to POST the form
				}
			})
			.on('click', '.swiper-slide-content', function(e) {

				var url = jQuery(this).data('href');
				var re = new RegExp('/' + window.location.host + '/');

				if( re.test(url) ) {
					if( apppresser.appp.can_ajax ) {
						apppresser.loadAjaxContent(url);
					} else {
						location.href = url;
					}
				} else if( typeof apppCore !== 'undefined' && apppCore.ver == "2" ) {
					console.log('iabClick will handle external links');
				} else { // appp v1 external links
					location.href = url;
				}
			})
			.on('click', '#member-nav', function() {
				$('.has-subnav #subnav').slideUp('fast');
				$('#item-nav').slideToggle('fast');
			})
			.on('click', '#sub-nav-button', function() {
				$('.has-subnav #subnav').slideToggle('fast');
				$('#item-nav').slideUp('fast');
			})
			.on('click', '.load-more-hijack', function (event) {
				/*** BuddyPress default load more uses the wrong template, had to side-step it ***/
				event.preventDefault();

				$.ajax({
				  method: "GET",
				  url: event.target.href,
				})
				.done(function( html ) {
					var newactivity = $(html).find('#activity-stream').html();
					$('#activity-stream').append(newactivity);
					$(event.target).parent().hide();
				});
			})
			.on('push_custom_data push_alert_dismissed', document, function(event, data) {
				
				if( event.type == 'push_custom_data' && typeof data !== 'undefined' && typeof data.custom !== 'undefined' && typeof data.custom.page_ajax_url !== 'undefined' ) {
					app.push_custom_ajax.url = data.custom.page_ajax_url;
				} else if( event.type == 'push_custom_data' && typeof data !== 'undefined' && typeof data.custom !== 'undefined' && typeof data.custom.page_noajax_url !== 'undefined' ) {
					app.push_custom_noajax.url = data.custom.page_noajax_url;
				} else if( event.type == 'push_alert_dismissed' && app.push_custom_ajax.url ) {
					app.push_custom_ajax.isPopup = true;
				} else if( event.type == 'push_alert_dismissed' && app.push_custom_noajax.url ) {
					app.push_custom_noajax.isPopup = true;
				}

				if( app.push_custom_ajax.url && app.push_custom_ajax.isPopup ) {
					apppresser.loadAjaxContent( app.push_custom_ajax.url );

					// reset
					app.push_custom_ajax.url = '';
					app.push_custom_ajax.isPopup = false;
				}

				if( app.push_custom_noajax.url && app.push_custom_noajax.isPopup ) {

					if( typeof apppCore === 'undefined' || apppCore.ver == "1" ) {
						// desktop theme or v1
						window.open(app.push_custom_noajax.url, '_blank');
						// reset
						app.push_custom_noajax.url = '';
						app.push_custom_noajax.isPopup = false;
					} else {
						parent.postMessage( 'push_noajax_url', '*');
					}
				}

			})

			/* 
			 * Start AP3 click stuff 
			 */

			.on('touchmove', function(){
				app.dragging = true;
			})
			.on('touchstart', function(){
			    app.dragging = false;
			})

			// Only put stuff here that should trigger a page transition in Ionic
			.on( touchorclick, '.post-list-item a, .products li a, .wc-forward, .swiper-container a, .dir-list li a,  .push-page', function(e) {

				// app.dragging fixes bug with post lists
				if( app.browserDebug || app.dragging ) {
					return;
				}

				// don't push new page if it has these classes
				if( $(e.currentTarget).hasClass('no-transition') ) {
					// console.log('dont push page');
					return;
				}

				e.preventDefault();
				var message = { url: e.currentTarget.href, title: '' };
				parent.postMessage( JSON.stringify(message), '*');
				return;
			})

			.on('click', '.appshare', function(e) {
				//console.warn(e);
				e.preventDefault();
				var message = { link: e.currentTarget.dataset.link, msg: e.currentTarget.dataset.msg };
				parent.postMessage( JSON.stringify(message), '*');
				return;
			})

			.on('click', '#main a, .single-post .entry-content p a, .activity-inner a, .external, .external a, .swiper-container', function(e) {
				// need to check if url is external

				var a = new RegExp('/' + window.location.host + '/');

				var target = '_blank';

				var options = 'location=yes';

				var href = '';

				if(typeof e.target.href !== 'undefined') {
					href = e.target.href;
				} else if( typeof e.target.href === 'undefined' ) {
					href = $(this).attr('href');
				}

				// do in app browser if we have class of external, target=_blank, or neither of those but domain doesn't match window.location.host
				if( href && $(e.target).hasClass('external') || href && $( e.target ).attr('target') == '_blank' || href && !a.test(href) && href.substr(0,1) != '#' ) {

					console.log('is external link', window.location.host, href);

					e.preventDefault();

					if( $(this).hasClass('system') || app.is_system_link( href ) )
						target = '_system';

					if( $(this).data('options') ) {
						options = $(this).data('options');
					} else if( $(this).parent().data('options') ) {
						options = $(this).parent().data('options');
					}

					var url = ( typeof e.target.href === 'undefined' ) ? $(this).attr('href') : e.target.href;

					if( ! url && $(this).find('.swiper-slide-active a').length ) {
						url = $(this).find('.swiper-slide-active a').attr('href');
					}

					var message = { iablink: url, options: options, target: target };
					parent.postMessage( JSON.stringify(message), '*');
					return;
				}

			})	

			.on('click', '#attach-photo-ap3', function(e) {
				//console.warn(e);
				e.preventDefault();
				var message = { camera: 'photo', appbuddy: true };
				parent.postMessage( JSON.stringify(message), '*');
				return;
			})	

			.on('click', '#capture-photo-btn.btn-camera', function(e) {
				//console.warn(e);
				e.preventDefault();
				var message = { camera: 'photo' };
				parent.postMessage( JSON.stringify(message), '*');
				return;
			})

			.on('click', '#photo-library-btn.btn-camera', function(e) {
				console.warn(e);
				e.preventDefault();
				var message = { camera: 'library' };
				parent.postMessage( JSON.stringify(message), '*');
				return;
			})

			.on('click', '#attach-image-sheet #capture-photo-btn', function(e) {
				
				e.preventDefault();
				var message = { camera: 'photo', appbuddy: true };
				parent.postMessage( JSON.stringify(message), '*');

				return;
			})

			.on('click', '#attach-image-sheet #photo-library-btn', function(e) {

				e.preventDefault();
				var message = { camera: 'library', appbuddy: true };
				parent.postMessage( JSON.stringify(message), '*');
				return;
			})

			.on('click', '.btn-checkin', function(e) {
				//console.warn(e);
				e.preventDefault();
				var message = { geo: 'checkinhere' };
				parent.postMessage( JSON.stringify(message), '*');
				return;
			})

			.on('click', '.appfbconnectlogin', function(e) {
				//console.warn(e);
				e.preventDefault();
				var message = { fblogin: 'login', ajaxurl: window.appp.ajaxurl };
				parent.postMessage( JSON.stringify(message), '*');
				return;
			});

		// Listen for events from the parent frame for stuff like modals. Clicking a header button in the Ionic app should trigger a modal in the child frame.
		window.addEventListener("message", function receiveMessage(event) {

			//console.log(event);

			if(event.data.lat) {
				app.location(event.data);
				return;
			}

			switch(event.data) {
				case 'activity':
					app.activityModal();
					break;
				case 'checkin':
					app.checkinModal();
					break;
				case 'loginModal':
					$('#loginModal').css('display', 'block').removeClass(app.downClasses).addClass(app.UpClasses);
					break;
				default:
					if (event.data.indexOf('{') === 0) {
						var data = JSON.parse( event.data );
						app.handleJsonMessage( data );
					}
			}

		}, false);

		if( (/iphone|ipad/gi).test(navigator.appVersion) ) {

			/* fix copy/paste iframe bug */

			$('.menu-layer').addClass('ios_layer_fix');

		}

		// iOS input keyboard on focus bug
		$.fn.mobileFix = function (options) {
			var $parent = $(this);

			$(document)
			.on('focus', options.inputElements, function(e) {
				//$parent.addClass("ios-pos-fixed");
				$parent.css('position', 'fixed');
			})
			.on('blur', options.inputElements, function(e) {
				//$parent.removeClass("ios-pos-fixed");
				$parent.css('position', 'absolute');

				// Fix for some scenarios where you need to start scrolling
				setTimeout(function() {
					$(document).scrollTop($(document).scrollTop());
				}, 1);
			})
			.on('focusin', function(){
				$(window).scrollTop($(window).scrollTop() + 34);
			});

			return this; // Allowing chaining
		};

		if( navigator.userAgent.match(/iPhone|iPad|iPod/i) ) {
			$(document).on( 'load_ajax_content_done', function() {
				$("#main").mobileFix({ // Pass parent to apply to
					inputElements: "#send-to-input", // Pass activation child elements
				});
			});	
		}

		/**
		 * For the loginModal when #loginModal is part of the URL.
		 * Add the redirect_to too when available.
		 */
		$(document).on( 'ready load_ajax_content_done', function() {

			var redirect;

			if( location.hash == '#loginModal' ) {

				redirect = app.get_url_param('redirect_to');
				if(redirect) {
					redirect = decodeURIComponent(redirect);
					$('input[name=redirect_to]').val(redirect);
				}

				// Open the modal
				$('#loginModal').css('display', 'block').removeClass(app.downClasses).addClass(app.UpClasses);
			}
		});

		$(window).resize( function() { 
			
			app.appbuddy.setNavStates();
			
		} );

	}; // init

	app.appbuddy.setNavStates = function() {
		var mediaQueryList = window.matchMedia( '(min-width: 768px)' );

		if( mediaQueryList.matches ) { // large screen: show navs
			$('.has-subnav #subnav').show();
			$('#item-nav').show();
		} else {                       // small screen: hide navs
			$('.has-subnav #subnav').hide();
			$('#item-nav').hide();
		}
	}

	app.handleJsonMessage = function( data ) {

		if( typeof data.custom_css !== 'undefined' ) {
			app.doCustomCSS(data.custom_css);
		} else if( typeof data.pause_event !== 'undefined' ) {
			app.stopYouTubeVid( data.pause_event.platform );
		}

	}

	app.doCustomCSS = function( css ) {

		var removeduplicates = $('#app-customizer-styles2');

        if(removeduplicates) 
          $(removeduplicates).remove();

        var container = $('#body-container');

        $(container).after('<style id="app-customizer-styles2">' + css + '</style>');

	}

	app.activityModal = function() {

		event.preventDefault();

		$('#activity-post-form').css('display', 'block').removeClass(app.downClasses).addClass(app.UpClasses);
	}

	app.checkinModal = function() {

		event.preventDefault();

		$('#geo-checkin-form').css('display', 'block').removeClass(app.downClasses).addClass(app.UpClasses);

		// window.AppGeo_getLoc();
		$('.ajax-spinner').show();
		
	}

	app.location = function(pos) {
		window.ap3_onSuccessGeoPost(pos);
		$('.ajax-spinner').hide();
	}

	app.is_system_link = function( href ) {

		if( typeof href != 'undefined' ) {
			var l = document.createElement("a");
			l.href = href;

			// True, as long as the URL looks like tel:8055551234 and not http://example.com:8080
			return ( ! l.port && href.indexOf(':') > 0 && href.indexOf('http') != 0 );
		}

		return false;
	}

	app.iOSLayerFix = {
		open: function() {
			$('.menu-layer').removeClass('ios_layer_fix');
		},
		close: function() {
			$('.menu-layer').addClass('ios_layer_fix');
		}
	};

	app.ioModal = (function(){

		return {
			open: function() {
				app.$.ioModal
					.removeClass( app.downClasses )
					.addClass( app.UpClasses )
					.data( 'isOpen', true )
					.trigger('isOpen');
			},
			close: function() {
				app.$.ioModal
					.removeClass( app.UpClasses )
					.addClass( app.downClasses )
					.data( 'isOpen', false )
					.trigger('isClosed');

				// iOS scroll fix
				setTimeout( function() { app.$.ioModal.removeClass( app.downClasses ); }, 150 );
			}
		};
	})();

	app.untrailingslashit = function(str) {
		if ( str.substr(-1) == '/' ) {
			return str.substr(0, str.length - 1);
		}
		return str;
	};

	/*
	 * Gets a single URL param
	 * @param name A param name for the value you want
	 * @param url
	 * @return string|null
	 */
	app.get_url_param = function( name, url ) {
		if (!url) url = location.href;
		name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
		var regexS = "[\\?&]"+name+"=([^&#]*)";
		var regex = new RegExp( regexS );
		var results = regex.exec( url );
		return results == null ? null : results[1];
	}

	/**
	 * Safely log things if query var is set
	 * @since  1.0.0
	 */
	app.log = function() {
		
		if ( this.appp.debug && console && typeof console.log === 'function' ) {
			console.log.apply(console, arguments);
		}
	};

	/**
	 * Group logged items
	 * @since  1.0.0
	 */
	app.logGroup = function( groupName, expanded ) {
		

		if ( this.appp.debug && console && typeof console.group === 'function' ) {
			if ( groupName === true ) {
				console.groupEnd();
			} else if ( typeof groupName === 'undefined' ) {
				if ( expanded )
					console.group();
				else
					console.groupCollapsed();
			} else {
				if ( expanded )
					console.group( groupName );
				else
					console.groupCollapsed( groupName );
			}
		}
	};

	/*
	 * Send login info to app
	 */
	app.sendLoginMsg = function( loggedin, data ) {

		var login = loggedin ? loggedin : window.appp.loggedin;

		var message = { loggedin: login, ajaxurl: window.appp.ajaxurl };
		if( data ) {
			message.message = data.message;
			message.username = data.username;
			message.avatar = data.avatar;
		}

		parent.postMessage( JSON.stringify(message), '*');
	}

	/*
	 * Tells the app if we are still logged in to WordPress
	 */
	app.isLoggedIn = function() {

		var login = window.appp.loggedin == "1" ? true : false;

		var message = { isloggedin: login, avatar_url: window.appp.avatar_url, message: window.appp.loggedin_message };

		parent.postMessage( JSON.stringify(message), '*');
	}

	/*
	 * Handles ajax modal new password request
	 */
	app.newPassword = function() {

		var codeMsg = $('.reset-code-rsp');

		if( $('#lost_email').val() === '' ) {
			codeMsg.html('Email required.');
			return false;
		}

		// codeMsg.html('<i class="fa fa-cog fa-spin"></i>');

		var data = {
			// app_lost_password functions found in apppresser core plugin, inc/AppPresser_Ajax_Extras.php
	  		action: 'app-lost-password',
	  		email: $('#lost_email').val(),
	  		nonce: $('#app_new_password').val()
	  	};

	  	var reset = $.ajax({
			type: 'post',
			url : appp.ajaxurl,
			dataType: 'json',
			data : data,
			success: function( response ) {
				codeMsg.html(response.data.message);
				$('input[type=text]').val('');
				$('input[type=password]').val('');
			},
			error: function(e) {
				console.log('Password reset error ' + e);
			}

		});

		return reset;

	};

	/*
	 * Handles ajax modal change password request
	 */
	app.changePassword = function() {

		var pwVal = $('#app-pw').val();
		var pwrVal = $('#app-pwr').val();
		var rCode = $('#reset-code').val();
		var pwMsg = $('.psw-msg');

		if ( pwVal != pwrVal || pwVal === '' ) {
				pwMsg.html('Passwords do not match.');
				return false;
		}

		if ( rCode === '' ) {
				pwMsg.html('Please enter your reset code.');
				return false;
		}

		// pwMsg.html('<i class="fa fa-cog fa-spin"></i>');

		var data = {
	  		action: 'app-validate-password',
	  		code: rCode,
	  		password: pwVal,
	  		nonce: $('#app_new_password').val()
	  	};

	  	var validation = $.ajax({
				type: 'post',
				url : appp.ajaxurl,
				dataType: 'json',
				data : data,
				success: function( response ) {
					pwMsg.html(response.data.message);
					$('#app-pw').val('');
					$('#app-pwr').val('');
					if( response.data.success ) {
						pwMsg.append(' Logging you in...');
						setTimeout( function() {
							window.location.reload();
						}, 1000);
					}
				}

		});

		return validation;

	};

	/*
	 * Ajax password reset events
	 */

	$( 'body' )

	.on('click', '#app-new-password', app.newPassword )

	.on('click', '#app-change-password', app.changePassword );

	/*
	 * Add comment to page after submitted with ajax
	 */
	app.appendComment = function( author, comment ) {

		var el;

		if( $('.comment-list') ) {
			el = $('.comment-list');
		} else {
			el = $('#comments');
		}

		el.append( '<li class="comment item" id="ajax-comment"> <article class="comment-body"> <footer class="comment-meta"> <div class="comment-author vcard"> <cite class="fn">' + author + '</cite> <span class="says">says:</span></div><!-- .comment-author --> <div class="comment-metadata"></div><!-- .comment-metadata --> <p class="comment-awaiting-moderation">Your comment is awaiting moderation.</p> </footer><!-- .comment-meta --> <div class="comment-content"> <p>' + comment + '</p> </div><!-- .comment-content --> </article><!-- .comment-body --> </li>' );
	};
	
	// do not submit comment if no value
	$( 'body' ).on( 'click', '#respond #submit', function() {
	
		// comment check
		var $comment = $( this ).closest( '#respond' ).find( '#comment' ),
			comment  = $.trim( $comment.val() );

	    if ( comment === '' ) {
	        alert( appp.i18n_required_comment_text );
			return false;
		}
		
		// rating check
		var $rating = $( this ).closest( '#respond' ).find( '#rating' ),
		rating  = $rating.val();

		if ( $rating.size() > 0 && ! rating && wc_single_product_params.review_rating_required === 'yes' && comment !== '' ) {
			alert( wc_single_product_params.i18n_required_rating_text );
			return false;
		}
			
	});

	/*
	 * Ajax comment modal
	 */

	if( $('body').hasClass('logged-in') ) {
		$('.ajax-comment-form-author, .ajax-comment-form-email, .ajax-comment-form-url').hide();
	}

	$('body')

	.on('click' , '.comment-reply-link', function() {
		// get the comment id from href
		var re = /replytocom=([0-9]*)/;
		var comment_id = re.exec(this.href);

		// send comment id to form and open comment modal
		$('#ajax-comment-parent').val(comment_id[1]);
		$( '.appp-comment-btn' ).trigger('click');
	} )

	.on( 'click', '#ajax-comment-form-submit #submit', function() {

		var commentform=$('#commentform');

		// Defining the Status message element 
		var statusdiv = $('#comment-status');

		var comment_author = $('.ajax-comment-form-author #author').val();
		var comment_email = $('.ajax-comment-form-email #email').val();
		var comment = $('.ajax-comment-form-comment #comment').val();
		var comment_parent = $('#ajax-comment-parent').val();
		var logged_in = $('body').hasClass('logged-in');
		var commentData;

		if(logged_in) {

			$('.ajax-comment-form-author, .ajax-comment-form-email, .ajax-comment-form-url').hide();

			commentData = {
				comment_post_ID: $('#commentform #comment_post_ID').val(),
				comment: comment,
				comment_parent: comment_parent,
			};

		} else {

			// if name, email, or comment empty, show error
			if( !comment_author || !comment_email || !comment ) {
				statusdiv.html('<p class="ajax-error" >Please fill out required fields.</p>');
				return false;
			}

			commentData = {
				author: comment_author,
				email: comment_email,
				url: $('.ajax-comment-form-url #url').val(),
				comment_post_ID: $('#commentform #comment_post_ID').val(),
				comment: comment,
				comment_parent: comment_parent,
			};
		}

		//Add a status message
		statusdiv.html('<p class="ajax-placeholder">Processing...</p>');

		//Extract action URL from commentform
		var formurl=commentform.attr('action');

		//Post Form with data
		$.ajax({
			type: 'post',
			url: formurl,
			data: commentData,
			error: function(XMLHttpRequest, textStatus, errorThrown){
				statusdiv.html('<p class="ajax-error" >You might have left one of the fields blank, or be posting too quickly</p>');
			},
			success: function(data, textStatus){
				// console.log( data );
				if(textStatus=="success") {
					statusdiv.html('<p class="ajax-success" >Thanks for your comment. We appreciate your response.</p>');

					app.appendComment( comment_author, comment );

					setTimeout( function() {
						$( ".io-modal-close" ).trigger( "click" );
					}, 1500 );
				} else {
					statusdiv.html('<p class="ajax-error" >Please wait a while before posting your next comment</p>');
					commentform.find('textarea[name=comment]').val('');
				}
			}
		});

		return false;

	});

	// Load more for App List pages. appp_load_more function is in AppPresser_Ajax_Extras.php in core plugin
	app.infiniteScroll = function() {

		var list = $('#main #app-post-list');

		$(list).append( '<p class="load-more">Loading...</p>' );
		var button = $('#app-post-list .load-more');
		var per_page = app.getUrlParam('num');
		var page = 2;
		var loading = false;
		var scrollHandling = {
		    allow: true,
		    reallow: function() {
		        scrollHandling.allow = true;
		    },
		    delay: 400 //(milliseconds) adjust to the highest acceptable value
		};

		$('#main').scroll(function(){

			if( ! loading && scrollHandling.allow && $(button).length ) {

				scrollHandling.allow = false;
				setTimeout(scrollHandling.reallow, scrollHandling.delay);
				var offset = $(button).offset().top - $('#main').scrollTop();
				var list_type = app.getListType();

				if( 2000 > offset ) {

					loading = true;
					var data = {
						action: 'appp_load_more',
						nonce: appp.nonce,
						page: page,
						url_query: location.search,
						posts_per_page: per_page
					};

					$.post(appp.ajaxurl, data, function(res) {

						if( res.success && res.data != "" ) {

							for (var i = res.data.length - 1; i >= 0; i--) {
								$(list).append( app.getTemplate( list_type, res.data[i] ) );
							}
							
							$(list).append( button );
							page = page + 1;
							loading = false;
						} else {
							$('.load-more').hide();
						}

					}).fail(function(xhr, textStatus, e) {
						console.log('infinite scroll fail');
						$('.load-more').hide();
					});

				}
			}
		});
	}

	// get list_type from url query string
	app.getListType = function() {
		var params = window.location.href.split('?')[1];
		var list_type;

		if( params.indexOf('list_type') >= 0 ) {
			list_type = app.getUrlParam('list_type');
		} else {
			list_type = 'default';
		}

		return list_type;

	}

	// get specific template for card or normal list
	app.getTemplate = function( type, data ) {

		var template = '<li class="post-list-item">';

		if( type === 'cardlist' ) {

			template += '<a class="card-permalink" href="' + data.permalink + '">';

			template += '<div class="card">';
			template += '<div class="item item-text-wrap"><h2>' + data.title + '</h2></div>';
			template += '<div class="item item-body">';

			if( data.full )
				template += '<div class="card-media"><img class="post-thumbnail" src="' + data.full + '" /></div>';
			
			if( data.excerpt )
				template += '<div class="card-content-inner">' + data.excerpt + '</div>';

			template += '</div></div>'; 

		} else if( type === 'list' ) {

			template += '<a class="item item-text-wrap" href="' + data.permalink + '">';
			
			template += '<div class="item-title">' + data.title + '</div>';

			if( data.excerpt )
				template += '<div class="item-text"><p>' + data.excerpt + '</p></div>';

		} else {

			template += '<a class="item item-thumbnail-left item-text-wrap" href="' + data.permalink + '">';
			
			if( data.thumbnail )
				template += '<img class="post-thumbnail" src="' + data.thumbnail + '" />';
			template += '<div class="item-title">' + data.title + '</div>';

			if( data.excerpt )
				template += '<div class="item-text"><p>' + data.excerpt + '</p></div>';
			
		} 

		template += '</a></li>';

		return template;

	}

	app.stopYouTubeVid = function( platform ) {

		if( 'Android' === platform ) {
			setTimeout(function() {
				var divs = app.$.main;
				var Vidsrc;

				if(divs.length) {
					console.log('Killing youtube vids');
					for (var i in divs) {

				   		if( /youtube/.test(divs[i].src) ) {
					   		Vidsrc = divs[i].src;
					   		divs[i].src = '';
					   		divs[i].src = Vidsrc;
				   		}

					}

				}

			}, 0);
		}

	};
	
	// get url param value by key
	app.getUrlParam = function(sParam) {
	    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
	        sURLVariables = sPageURL.split('&'),
	        sParameterName,
	        i;

	    for (i = 0; i < sURLVariables.length; i++) {
	        sParameterName = sURLVariables[i].split('=');

	        if (sParameterName[0] === sParam) {

	            return sParameterName[1] === undefined ? true : sParameterName[1];
	        }
	    }
	}

	app.init();

	window.apppresser = app;

})(window, document, jQuery);