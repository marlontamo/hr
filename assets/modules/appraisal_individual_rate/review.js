$(document).ready(function(){
	get_section_items();
});

function view_discussion( form, status_id )
{
    $.ajax({
        url: base_url + module.get('route') + '/view_discussion',
        type: "POST",
        async: false,
        data: form.find(":not('.dontserializeme')").serialize() + '&status_id='+status_id,
        dataType: "json",
        beforeSend: function () {
            $.blockUI({
                message: '<img src="'+ base_url +'assets/img/ajax-modal-loading.gif"><br />Loading discussion, please wait...',
                css: {
                    background: 'none',
                    border: 'none',     
                    'z-index':'99999'               
                },
                baseZ: 20000,
            });
        },
        success: function (response) {
            $.unblockUI();

            if (typeof (response.notes) != 'undefined') {
                $('.modal-container').html(response.notes);
                $('.modal-container').modal();          
            }
            handle_ajax_message( response.message );
        }
    });
}

function view_transaction_logs( appraisal_id, user_id )
{
	$.blockUI({ message: loading_message(),
		onBlock: function(){
			var data = {
				appraisal_id: appraisal_id,
				user_id:user_id
			};
			$.ajax({
				url: base_url + module.get('route') + '/view_transaction_logs',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( typeof(response.trans_logs) != 'undefined' )
					{
						$('.modal-container').attr('data-width', '800');
						$('.modal-container').html(response.trans_logs);
						$('.modal-container').modal();
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}

function get_section_item( section_id )
{
	$('tbody.section-'+section_id).block({ message: '<div>Loading section items, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
		onBlock: function(){
			var data = {
				planning_id: $('input[name="planning_id"]').val(),
				appraisal_id: $('input[name="appraisal_id"]').val(),
				user_id: $('input[name="user_id"]').val(),
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
					total_rating();
					total_weight();

					$('tbody.section-'+section_id).unblock();
					$('textarea:visible').textareaAutoSize();
				}
			});
		},
		baseZ: 300000000
	});	
}

function total_weight()
{
	$('tbody.get-section').each(function(){
		var $this = $(this);
		var total = 0;
		$this.find('input.weight-field').each(function(){
			total = total + parseFloat( $(this).val() );
		});
		
		if( !isNaN(total) )
			$(this).find('input.weight-total').val( round(total,2) );
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
		//find weight
		var td = $(this).parent().parent();
		var weight = td.find('input.weight-field');
		if( weight != "undefined" && weight.val() )
		{
			//find weighted rating field
			var weighted_rating = td.find('input.weighted_rating-field');
			if( weighted_rating != "undefined")
			{
				var score = $("option:selected", this).attr("score");
				var x = parseFloat(weight.val()) / 100 * parseFloat(score);
				weighted_rating.val( round(x,2) );
			}
		}

		total_rating();
	});
	$('select.rating-field').trigger('change');
}

function total_rating()
{
	$('tbody.get-section').each(function(){
		var $this = $(this);
		var total = 0;
		$this.find('input.weighted_rating-field').each(function(){
			total = total + parseFloat( $(this).val() );
		});
		
		if( !isNaN(total) )
			$(this).find('input.weight_rating-total').val( round(total,2) );
	});	
}

function get_observations( performance_appraisal_year, user_id, fullname )
{
    data ={
        performance_appraisal_year : performance_appraisal_year,
        user_id : user_id,
        fullname : fullname
    }
    $.ajax({
        url: base_url + module.get('route') + '/get_observations',
        type: "POST",
        async: false,
        data: data,
        dataType: "json",
        beforeSend: function () {
            $.blockUI({
                message: '<img src="'+ base_url +'assets/img/ajax-modal-loading.gif"><br />Loading discussion, please wait...',
                css: {
                    background: 'none',
                    border: 'none',     
                    'z-index':'99999'               
                },
                baseZ: 20000,
            });
        },
        success: function (response) {
            $.unblockUI();

            if (typeof (response.notes) != 'undefined') {
                $('.modal-container').html(response.notes);
                $('.modal-container').modal();           
            }
            handle_ajax_message( response.message );
        }
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

function contributor_form(template_section_id)
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			data = {
				appraisal_id: $('#record_id').val(),
				user_id: $('input[name="user_id"]').val(),
				template_section_id: template_section_id,
			};
			$.ajax({
				url: base_url + module.get('route') + '/contributor_form',
				type:"POST",
				async: false,
				dataType: "json",
				data: data,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( typeof(response.contributor_form) != undefined )
					{
						$('.modal-container').html(response.contributor_form);
						$('.modal-container').modal();
						init_tags();
					}
				}
			});
		},
		baseZ: 20000
	});
	$.unblockUI();
}

function init_tags()
{
	
	$('#contributors').tagsinput({
    	itemValue: 'value',
      	itemText: 'label',
      	allowDuplicates: false,
      	maxTags: 5,
      	typeahead: {
        	source: function(query) {
          		return $.getJSON(base_url + module.get('route') + '/tag_user');
        	}
      	}

    });

    if( $('#contributors').val() != "" )
    {            
        var current = $('#contributors').val().split(',');
        for(var i in current)
        {
            $('#contributors').tagsinput('add', { "value": current[i], "label": current_draft[current[i]]});                     
            	
        	var tag_class = $('#contributors').parent().find('.tag');

        	if (typeof (current_approve[current[i]]) != 'undefined') {            
            	tag_class.each(function (index, elem) {
        			if($(this).text() == current_approve[current[i]]){
        				$(this).find('span').hide();
        			}
        		});
            	
            }
        	 
        }      

    }
}

function add_contributors()
{
	if($('#contributors').val() == "")
	{
		notify('warning', 'No one selected, please type contributor(s) in the box.');
		return;
	}

	$.blockUI({ message: '<div>Adding contributors, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/add_contributors',
				type:"POST",
				async: false,
				dataType: "json",
				data: $('#contributor-form').serialize(), 
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if(response.close_modal){
						$('.modal-container').modal('hide');
						get_section_item( response.section_id )
					}

					if(response.hasOwnProperty('notify'))
					{
						for(var i in response.notify)
							socket.emit('get_push_data', {channel: 'get_user_'+response.notify[i]+'_notification', args: { broadcaster: user_id, notify: true }});
					}
				}
			});
		},
		baseZ: 20000
	});
	$.unblockUI();
}

function del_cs(appraisal_id, auser_id, template_section_id, contributor_id)
{
	bootbox.confirm("Are you sure you want to delete this crowdsource?", function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: '<div>Deleting, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/remove_contributor',
						type:"POST",
						async: false,
						dataType: "json",
						data: {appraisal_id:appraisal_id, user_id:auser_id, template_section_id:template_section_id, contributor_id:contributor_id}, 
						beforeSend: function(){
						},
						success: function ( response ) {
							handle_ajax_message( response.message );
							$('.modal-container').modal('hide');
							get_section_item( template_section_id )
						}
					});
				},
				baseZ: 20000
			});
			$.unblockUI();
		}
	});
}