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
		}
	};

	helper.init = function() {

		if( helper._initialized ) return;

		helper._initialized = true;
		$(document).on('click', helper.handleClick);
		$(window).on('click', helper.handleClick);
		$('body').on('click', helper.handleClick);
		$('.io-modal').on('click', helper.handleClick);
	};

	helper.handleClick = function(e) {
		if( helper.keyboard.visible && ! ( e.target.tagName.toUpperCase() == 'INPUT' ||  e.target.tagName.toUpperCase() == 'TEXTAREA') ) {
			parent.postMessage('appp_helper_close_keyboard', '*');
		}
	};

	helper.closed = function() {
		this.keyboard.visible = false;
		console.log('helper.closed', 'keyboard closed');
		$('body').trigger('keyboard_closed');
	};

	helper.opened = function() {
		this.keyboard.visible = true;
		console.log('helper.opened', 'keyboard opened');
		$('body').trigger('keyboard_opened');
	};

	window.addEventListener('message', helper.receiveMessage);
	window.apppKeyboardHelper = helper;

	
})(window, document, jQuery);

// initialized from apppresser2-plugins.js when device.platform == 'ios'
// requires cordova-plugin-ionic-keyboard