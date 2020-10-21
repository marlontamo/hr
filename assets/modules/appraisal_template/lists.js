function copy_record( record_id )
{
	bootbox.prompt('Enter Template title', function(title){
		if( title !== null )
		{
			if( title == "" )
			{
				copy_record( record_id );
				notify('warning', 'Please enter title');
				return;
			}

			$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/duplicate',
						type:"POST",
						async: false,
						data: {record_id:record_id, title: title},
						dataType: "json",
						beforeSend: function(){
						},
						success: function ( response ) {
							handle_ajax_message( response.message );

							if( response.record_id != null )
							{
								window.location = base_url + module.get('route') + '/edit/' + response.record_id;
							}
						}
					});
				}
			});
			$.unblockUI();
		}
	});
}