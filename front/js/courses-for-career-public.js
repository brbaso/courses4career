(function( $ ) {
	'use strict';
	$(function () {
		
	/**
	 * ON Career Change
	 */
		$('body').on('change', '#career-select', function(e){
			var career_id = $(this).val();
			var wtype = $(this).attr('data-type');
			var wid = $(this).attr('data-wid'); 
				
			// find if we are about to render plugin or widgets
			var action = (wtype == 'widget') ? 'widget_render_courses' :  'render_courses' ;							

			var response_container = ( wtype == 'widget' ) ? $( '#c4c-response-widget-'+wid ) : $('#c4c-response');			
			
			var animation_container = ( wtype == 'widget' ) ?  response_container.find('.animation_container.widget.'+wid) :  response_container.find('.animation_container');

			var data = {
					action: action, // handle this ajax request
					career_id: career_id, // career id					
					wtype: wtype, // is it widget					
					wid: wid, // widget id - needed for widget rendering					
				};
		
			response_container.html('').append(animation_container);
			animation_container.show(); // Show the animate loading
			
			var opts = {
				url: ajax_url.ajaxurl, // ajaxurl points to /wp-admin/admin-ajax.php
				type: 'POST',
				async: true,
				cache: false,
				dataType: 'json',
				data:data,
				success: function(response) {

					response_container.html(response).append(animation_container);
					animation_container.hide(); // Hide the loading animation
				},
				error: function(xhr,textStatus,e) { 

					alert('There was an error');				
					animation_container.hide(); // Hide the loading animation
				}
			};
			$.ajax(opts);	
		});
	});
})( jQuery );
