function join_group( group_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/join_group',
				type:"POST",
				dataType: "json",
				data: {group_id: group_id},
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if(response.group_notif != "undefined")
					{
						for(var i in response.group_notif)
							socket.emit('get_push_data', {channel: 'get_group_'+response.group_notif[i]+'_notification', args: { broadcaster: user_id, notify: true }});
					}
					setTimeout(function(){
			    		window.location.reload();
			        }, 3000);
				}
			});
		}
	});
	$.unblockUI();
}