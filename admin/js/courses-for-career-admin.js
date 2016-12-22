(function( $ ) {
	'use strict';
	$(function () {
		
	/**
	 * Add New Career
	 */
		$('body').on('click', '.c4c_add_career', function(e){
			
			e.preventDefault();
			
			var content = $('#c4c-content');
			var active_content = $('#active-content');			
			var c = content.find('#clone');
			var clone = c.clone();
			
			var cloned_content = clone.html();			
			active_content.append(cloned_content);
			
			var cloned = active_content.find('.cloned');
			cloned.attr('id', 'no-sort');
			cloned.find('.for-chosen').addClass('chzn-select');
			
			cloned.find('.chzn-select').chosen({				
				width: '95%'
			  });			
			cloned.removeClass('cloned');

			// smooth scroll to the new career field 
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				$('html, body').animate({
				  scrollTop: target.offset().top
			}, 1000);
				return false;
			}			
		});
		
	/**
	 * Remove Career
	 */
		$('body').on('click', '.remove-career', function(e){
			
			e.preventDefault();
			
			$(this).parents('.c4c-form').remove();
		});
		
	/**
	 * Activate update button on fields focus
	 */
		$('body').on('focusin', '.inputs input, .inputs textarea, .inputs .chosen-container', function(e){
			//alert()
			var forma = $(this).parents('.career-form');
			var butt = forma.find('.update-career');		
			butt.removeAttr('disabled');		
		});
		
	/**
	 * Save, Update, Delete Career
	 */
		$('body').on('click', '.action-button', function(e){
			
			e.preventDefault();
			
			var action = $(this).attr('data-action');
			
			var r = true;
			if(action == 'career_delete'){
				r = confirm('The item and it\'s data will be permanently deleted! Are you sure?');			 
			}
			
			if(r == false){
				exit;
			}
					
			var forma = $(this).parents('.career-form');
			var career_id = forma.attr('id');
			var form_data = forma.serialize();
			var animation_container = forma.find('.animation_container');
			
			var data = {
					action: action, // handle this ajax request
					career_id: career_id, // career id
					form_data: form_data // form data
				};
			
			animation_container.show(); // Show the animate loading			
			
			var opts = {
				url: ajaxurl, // ajaxurl points to /wp-admin/admin-ajax.php
				type: 'POST',
				async: true,
				cache: false,
				dataType: 'json',
				data:data,
				success: function(response) {
					
					if(action == 'career_save'){
						data=$.parseJSON(response);
						//alert (data);
						var id = data;
						forma.parents('.c4c-form').attr('id', id);
						forma.attr('id', id);
						forma.find('#new-courses').remove();
						forma.find('#existing-courses').show();
						forma.find('.update-career').prop('disabled', true);
						forma.parents('.c4c-form').find('.drag-drop-bar').append('<div class=\'wp-menu-image dashicons-before dashicons-move\' style=\'float:right; margin-right:10px;\'><br></div> ');
						
					}
					
					if(action == 'career_delete'){
						forma.parents('.c4c-form').remove();
					}				
					
					forma.find('.update-career').attr('disabled', 'true');
					
					animation_container.hide(); // Hide the loading animation

				},
				error: function(xhr,textStatus,e) {
					alert('There was an error saving the updates');				
					animation_container.hide(); // Hide the loading animation

				}
			};
			$.ajax(opts);		
		});
	 
	/**
	 * Drag and Drop Reorder
	 */		 
		var itemList = $('#active-content');
		var big_animation_container = itemList.parents('#c4c-content').find('.big_animation_container');
		itemList.sortable({
			items: '.c4c-form',
			
			cancel: '#no-sort, .sort-disabled',
			update: function(event, ui) {				
				$('#no-sort').remove(); // Remove new unsaved/unsortable item
				
				big_animation_container.show(); // Show the animate loading 

				var opts = {
					url: ajaxurl, // ajaxurl  points to /wp-admin/admin-ajax.php
					type: 'POST',
					async: true,
					cache: false,
					dataType: 'json',
					data:{
						action: 'item_sort', // handle this ajax request
						order: itemList.sortable('toArray').toString() // Passes id's of list items in  1,3,2 format
					},
					success: function(response) {						
						big_animation_container.hide(); // Hide the loading animation

					},
					error: function(xhr,textStatus,e) {
						alert('There was an error saving the updates');
						big_animation_container.hide(); // Hide the loading animation

					}
				};
				$.ajax(opts);
			}
		});		
	});	
})( jQuery );
