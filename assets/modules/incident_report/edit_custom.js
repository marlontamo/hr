function save_record( form, action, callback )
{
	$.blockUI({ message: saving_message(),
		onBlock: function(){

			var hasCKItem = form.find("textarea.ckeditor");

			if(hasCKItem && (typeof editor != 'undefined')){
				
				for ( instance in CKEDITOR.instances )
        			CKEDITOR.instances[instance].updateElement();
			}

			var data = form.find(":not('.dontserializeme')").serialize();
			data = data +'&incident_status_id='+ action;
			$.ajax({
				url: base_url + module.get('route') + '/save',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( response.saved )
					{
						if( response.action == 'insert' )
							$('#record_id').val( response.record_id );

						if (typeof(after_save) == typeof(Function)) after_save( response );
						if (typeof(callback) == typeof(Function)) callback( response );

						switch( action )
						{
							case 'new':
								document.location = base_url + module.get('route') + '/add';
								break;
							case 6:
							case 2:
								document.location = base_url + module.get('route');
								break;
						}
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}

function cancel_report_form(form)
{
	bootbox.confirm(lang.incident_report.confirm_cancel_report, function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: '<div>'+lang.common.processing+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/get_cancel_form',
						type:"POST",
						async: false,
						dataType: "json",
						data: form.find(":not('.dontserializeme')").serialize(),
						success: function ( response ) {
							$.unblockUI();	
							handle_ajax_message( response.message );

							if( typeof(response.cancel_form) != 'undefined' )
							{
								$('.modal-container').html(response.cancel_form);
								$('.modal-container').modal();
							}
						}
					});
				}
			});
		}
	});
}

function cancel_report()
{
	$.blockUI({ message: '<div>'+lang.common.processing+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/cancel_report',
				type:"POST",
				async: false,
				dataType: "json",
				data: $('#cancel-form').serialize(),
				success: function ( response ) {
					handle_ajax_message( response.message );
					if(response.saved)
					{
						if(response.notify != "undefined")
						{
							for(var i in response.notify)
								socket.emit('get_push_data', {channel: 'get_user_'+response.notify[i]+'_notification', args: { broadcaster: user_id, notify: true }});
						}
						$('.modal-container').modal('hide');
						window.location = base_url + module.get('route');
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();	
}

