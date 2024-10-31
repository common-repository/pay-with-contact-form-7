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

})( jQuery );

jQuery(document).ready(function(){

	jQuery(window).load(function(){

		if(jQuery("input[name='mode']:checked").val() == 1){
			jQuery('.sandbx_pay_details').show();
			jQuery('.live_pay_details').hide();
		}else if(jQuery("input[name='mode']:checked").val() == 2){
			jQuery('.live_pay_details').show();
			jQuery('.sandbx_pay_details').hide();
		}

	});

	jQuery('.live_pay_details').hide();
	jQuery('input[name="mode"]').change(function(){
		
		if (jQuery(this).val()== 1) {
			
			jQuery('.live_pay_details').hide();
			jQuery('.sandbx_pay_details').show();
		}else if(jQuery(this).val() == 2){

			jQuery('.live_pay_details').show();
			jQuery('.sandbx_pay_details').hide();
		}

	});

	jQuery('input[name="btn2"]').click(function(){
		if(jQuery('.sandboxaccount').val() == ''){ 
		}	
	});
});