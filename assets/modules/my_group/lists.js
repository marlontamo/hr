function quick_add()
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/quick_add',
				type:"POST",
				dataType: "json",
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( typeof(response.quick_edit_form) != 'undefined' )
					{
						$('.modal-container').attr('data-width', '500');
						$('.modal-container').html(response.quick_edit_form);
						$('.modal-container').modal();
						init_tags();
					}
				}
			});
		}
	});
	$.unblockUI();	
}

var current_members = new Array();
function init_tags()
{
    $('#groups_members-user_id').tagsinput({
        itemValue: 'value',
        itemText: 'label',
        typeahead: {
            source: function(query) {
                return $.getJSON(base_url + module.get('route') + '/tag_user' );
            }
        }
    });

    if( $('#groups_members-user_id').val() != "" )
    {            
        var current = $('#groups_members-user_id').val().split(',');
        for(var i in current)
        {
            $('#groups_members-user_id').tagsinput('add', { "value": current[i], "label": current_members[current[i]]});
        }
    }
}

function leave_group( group_id )
{
	bootbox.confirm('Are you sure you want to leave this group?', function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/leave_group',
						type:"POST",
						async: false,
						dataType: "json",
						data: {group_id:group_id},
						success: function ( response ) {
							$.unblockUI();
							if(response.refresh)
								$('#record-list').infiniteScroll('search');
						}
					});
				}
			});
		}
	});
}