/**
 * AppPresser - iOS keyboard helper
 * version 1.0
 */

(function(window, document, $, undefined) {

	'use strict';

	var helper = {
		_initialized: false,
		keyboard: {
			visible: false
		}
	};

	helper.receiveMessage = function(e) {
		if( e.data && e.data === 'appp_keyboard_helper' ) {
			helper.init();
		} else if( e.data && e.data === 'appp_keyboard_closed' ) {
			helper.closed();
		} else if( e.data && e.data === 'appp_keyboard_opened' ) {
			helper.opened();
		}
	}

	helper.init = function() {

		if( helper._initialized ) return;

		helper._initialized = true;
		$(document).on('touchstart', helper.handleClick);
		$(window).on('touchstart', helper.handleClick);
		$('body').on('touchstart', helper.handleClick);
		$('.io-modal').on('touchstart', helper.handleClick);
	};

	helper.handleClick = function(e) {

		if( helper.keyboard.visible && ! ( e.target.tagName.toUpperCase() == 'INPUT' ||  e.target.tagName.toUpperCase() == 'TEXTAREA') && e.target.type != "submit" && e.target.tagName.toUpperCase() != "BUTTON" ) {
			var message = {"apppkeyboardhelper":"close"};
			parent.postMessage( JSON.stringify(message), '*');
			helper.keyboard.visible=false;
		}
	};

	helper.closed = function() {
		if( ! this.keyboard.visible )
			return;
		this.keyboard.visible = false;
		$('body').trigger('keyboard_closed');
	};

	helper.opened = function() {
		if( this.keyboard.visible )
			return;
		this.keyboard.visible = true;
		$('body').trigger('keyboard_opened');
	};

	window.addEventListener('message', helper.receiveMessage);
	window.apppKeyboardHelper = helper;
	helper.init();

	
})(window, document, jQuery);

// requires cordova-plugin-ionic-keyboard