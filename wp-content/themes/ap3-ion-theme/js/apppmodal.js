(function(window, document, $, undefined){

	var modal = {
			_appendTo: 'body',
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
				modal.append('<div class="bar bar-header"><button class="button button-icon ion-location"></button><i class="io-modal-close icon ion-close-round"></i></div>');
				
				// content
				if( options && options.content )
					modal.append(options.content);
				else
					$(this).clone().appendTo(modal).wrap('<div class="io-modal-content"></div>');
					if( $('#'+id+' .io-modal-content .activity-image').length ) {
						// swap out the small image for the full sized image 
						// by removing the -WxH portion of a filename filename-WxH.jpg
						var new_url = appmodal.getFullImg( $('#'+id+' .io-modal-content .activity-image').attr('src') );
						$('#'+id+' .io-modal-content .activity-image').attr('src', new_url);
						$('#'+id+' .io-modal-content').addClass('modal-scroll');
					}
			});
		}
	});

	/**
	 * Removes the dimensions portion of a filename.
	 * In:  http://example.com/sample-180x250.jpg
	 * Out: http://example.com/sample.jpg
	 */
	modal.getFullImg = function( url ) {
		return url.replace(/-(\d*)x(\d*).(jpg|png|gif)/, ".$3");
	};

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
