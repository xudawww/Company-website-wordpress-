(function(window, document, $, undefined){

	var modal = {
			_appendTo: '#body-container',
		};

	modal.init = function() {			
		// to avoid duplicate modal, we'll remove them each time
		$('.io-dynamic-modal').remove();

		$(document).trigger('create_dynamic_modals');
	};

	/**
	 *
     * <img class="dynamic-modal" src="/my-img.jpg">
	 *
	 * Use: $('img.dynamic-modal').apppmodal();
	 *
	 * Options:
	 * {
	 *	 id: 'my-img-3', // optional
	 *   content: '<div>something</div>', // optional, default will use the img
	 * }
	 **/
	$.fn.extend({
		apppmodal: function(object, options) {

			return this.each( function() {
				$(this).removeClass('dynamic-modal'); // so we only create a modal once

				// We'll need an ID
				var id = appmodal.guid(); // make a random id
				
				// Add a link to this element
				$(this).wrap('<a href="#'+id+'" class="io-modal-open"></a>');

				// Create the modal and append it to a DOM
				var modal = jQuery('<aside/>',{
					id: id,
					class: 'io-modal io-dynamic-modal',
					tabindex: '-1',
					role: 'dialog',
					'aria-hidden': true,
				}).appendTo(appmodal._appendTo);

				// header
				modal.append('<div class="toolbar site-header"><i class="io-modal-close fa fa-times fa-lg alignright"></i></div>');
				
				// content
				if( options && options.content )
					modal.append(options.content);
				else
					$(this).clone().appendTo(modal).wrap('<div class="io-modal-content"></div>');
			});
		}
	});

	modal.guid = function() {
	  function s4() {
	    return Math.floor((1 + Math.random()) * 0x10000)
	      .toString(16)
	      .substring(1);
	  }
	  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
	    s4() + '-' + s4() + s4() + s4();
	};

	$(document).on('ready load_ajax_content_done', modal.init);

	window.appmodal = modal;

})(window, document, jQuery);
