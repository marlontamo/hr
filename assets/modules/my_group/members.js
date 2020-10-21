$(document).ready(function(){
	$('.list-filter').unbind('click').click(function(){
		$('.list-filter').removeClass('label-success');
		$('.list-filter').addClass('label-info');
		$(this).removeClass('label-info');
		$(this).addClass('label-success');

		create_list();
	});	
});

function create_list()
{
	var search = $('input[name="list-search"]').val();
	var filter_by = $('.list-filter.label-success').attr('filter_by');
	var filter_value = $('.list-filter.label-success').attr('filter_value');
	
	$('#record-list').empty().die().infiniteScroll({
		dataPath: base_url + module.get('route') + '/get_members_list/'+$('input[name="group_id"].filter').val(),
		itemSelector: 'tr.record',
		onDataLoading: function(){ 
			$("#loader").show();
			$("#no_record").hide();
		},
		onDataLoaded: function(page, records){ 
			$("#loader").hide();
			if( page == 0 && records == 0)
			{
				$("#no_record").show();
			}
		},
		onDataError: function(){ 
			return;
		},
		search: search,
		filter_by: filter_by,
		filter_value: filter_value
	});
}

function accept_request( group_id, user_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/accept_request',
				type:"POST",
				dataType: "json",
				data: {group_id: group_id, user_id:user_id},
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if(response.refresh)
						$('#record-list').infiniteScroll('search');

					if(response.group_notif != "undefined")
					{
						for(var i in response.group_notif)
							socket.emit('get_push_data', {channel: 'get_group_'+response.group_notif[i]+'_notification', args: { broadcaster: user_id, notify: true }});
					}
				}
			});
		}
	});
	$.unblockUI();
}