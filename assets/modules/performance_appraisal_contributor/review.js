$(document).ready(function(){
	get_section_items();
});

function get_section_item( section_id )
{
	$('tbody.section-'+section_id).block({ message: '<div>Loading section items, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
		onBlock: function(){
			var data = {
				planning_id: $('input[name="planning_id"]').val(),
				appraisal_id: $('input[name="appraisal_id"]').val(),
				user_id: $('input[name="user_id"]').val(),
				manager_id: $('input[name="manager_id"]').val(),
				template_id: $('input[name="template_id"]').val(),
				section_id: section_id
			};

			$.ajax({
				url: base_url + module.get('route') + '/get_section_items',
				type:"POST",
				data: data,
				dataType: "json",
				async: true,
				success: function ( response ) {
					handle_ajax_message( response.message );
					$('tbody.section-'+section_id + ' tr:not(.first-row)').each(function(){
						$(this).remove();
					});
					$('tbody.section-'+section_id).prepend( response.items );
					init_rating();
					$('select.rating-field-'+section_id).trigger('change');
					$('tbody.section-'+section_id).unblock();
					$('textarea:visible').textareaAutoSize();
				}
			});
		},
		baseZ: 300000000
	});
		
}

function get_section_items()
{
	$('tbody.get-section').each(function(){
		var section_id = $(this).attr('section');
		get_section_item(section_id);
	});
}

function init_rating()
{
	$('select.rating-field').stop().change(function(){
		var section_id = $(this).attr('section_id');
		var total_score = 0;
		var total_items = 0;
		$('select.rating-field-'+section_id).each(function(){
			total_items++;
			total_score = total_score + parseFloat( $(this).find(":selected").attr('score') );
		});

		var average = total_score / total_items;
		$('input.weighted_rating-field-'+section_id).val( round(average, 2));
	});
}

function change_status(form, status_id)
{
	$.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
		onBlock: function(){
			var data = form.find(":not('.dontserializeme')").serialize() + '&status_id='+status_id;
			$.ajax({
				url: base_url + module.get('route') + '/change_status',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if(response.notify != "undefined")
					{
						for(var i in response.notify)
							socket.emit('get_push_data', {channel: 'get_user_'+response.notify[i]+'_notification', args: { broadcaster: user_id, notify: true }});
					}

					if(response.redirect)
						window.location = base_url + module.get('route');
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();	
}

function total_rating()
{
	$('tbody.get-section').each(function(){
		var $this = $(this);
		var total = 0;
		$this.find('input.weighted_rating-field').each(function(){
			total = total + parseFloat( $(this).val() );
		});

		$(this).find('input.weight_rating-total').val( round(total, 2) );
	});	
}

function get_discussion_form( appraisal_id, section_id, user_id, contributor_id, show_form )
{
	$.blockUI({ message: loading_message(),
		onBlock: function(){
			var data = {
				appraisal_id: $('input[name="appraisal_id"]').val(),
				user_id: $('input[name="user_id"]').val(),
				contributor_id: contributor_id,
				section_id: section_id,
				show_form: show_form
			};

			$.ajax({
				url: base_url + module.get('route') + '/cs_discussion',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if (typeof (response.notes) != 'undefined') {
		                $('.modal-container').html(response.notes);
		                $('.modal-container').modal();       
		            	init_cs_discussion_button(); 
		            }
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}

function init_cs_discussion_button()
{
	$('#cs_discussion_button').stop().click(function(){
		$.blockUI({ message: loading_message(),
			onBlock: function(){
				var data = $('form#note-form').serialize();
				$.ajax({
					url: base_url + module.get('route') + '/sendback_cs',
					type:"POST",
					data: data,
					dataType: "json",
					async: false,
					success: function ( response ) {
						handle_ajax_message( response.message );
						
						$('.modal-container').modal('hide');

						if(response.hasOwnProperty('notify'))
						{
							for(var i in response.notify)
								socket.emit('get_push_data', {channel: 'get_user_'+response.notify[i]+'_notification', args: { broadcaster: user_id, notify: true }});
						}

						if(response.redirect)
							window.location = base_url + module.get('route');


					}
				});
			},
			baseZ: 300000000
		});
		$.unblockUI();
	});
}