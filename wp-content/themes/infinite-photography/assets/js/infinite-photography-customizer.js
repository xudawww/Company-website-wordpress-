/**
 * Customizer custom js
 */

jQuery(document).ready(function() {
   jQuery('.wp-full-overlay-sidebar-content').prepend('<div class="acme-ads"> <a href="http://www.acmethemes.com/themes/infinite-photography-pro" class="button" target="_blank">{pro}</a></div>'.replace('{pro}',infinite_photography_customizer_js_obj.pro));
});