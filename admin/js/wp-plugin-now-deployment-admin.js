(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$( window ).load(function() {
		$('#submitDeploy').on('click', function(e) {
			e.preventDefault();
			if (!$('#wp_plugin_now_deployment_webhook_enable_deploy').is(":checked")) {
				alert('Enable deploy should be checked and saved before deploy.')
				return;
			}
			var url = document.location.href.indexOf("&deploy=yes") > -1 ? document.location.href : document.location.href+"&deploy=yes";
      document.location.href = url;
		});
	});

})( jQuery );
