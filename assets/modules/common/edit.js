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
						}
					}

					/*if(response.notify != "undefined")
					{
						for(var i in response.group_notif)
							socket.emit('get_push_data', {channel: 'get_user_'+response.notify[i]+'_notification', args: { broadcaster: user_id, notify: true }});
					}*/

					if(response.group_notif != "undefined")
					{
						for(var i in response.group_notif)
							socket.emit('get_push_data', {channel: 'get_group_'+response.group_notif[i]+'_notification', args: { broadcaster: user_id, notify: true }});
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}

function save_fg( fg )
{
	fg.submit( function(e){ e.preventDefault(); } );
	var fg_id = fg.attr('fg_id');
	$.blockUI({ message: saving_message(), 
		onBlock: function(){
			fg.submit( function(e){ e.preventDefault(); } );
			var fg_id = fg.attr('fg_id');
			var data = fg.find(":not('.dontserializeme')").serialize();
			data = data + '&record_id=' + $('#record_id').val();
			$.ajax({
				url: base_url + module.get('route') + '/save',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					$('#record_id').val( response.record_id );

					handle_ajax_message( response.message );
				}
			});
		}
	});
	$.unblockUI();
}

function show_pass_field( field, $this )
{
	field = '#' + field;
	$this.next().remove();
	$this.remove();
	$(field).removeClass('dontserializeme').parent().removeClass('hidden ');
	$(field+'-confirm').removeClass('dontserializeme').parent().removeClass('hidden ');
}