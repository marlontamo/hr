function send_sign( form, action, record_id, callback )
{
	$.blockUI({ message: saving_message(),
		onBlock: function(){

			var hasCKItem = form.find("textarea.ckeditor");

			if(hasCKItem && (typeof editor != 'undefined')){
				
				for ( instance in CKEDITOR.instances )
        			CKEDITOR.instances[instance].updateElement();
			}

			var data = form.find(":not('.dontserializeme')").serialize();
			// console.log(data);
			$.ajax({
				url: base_url + module.get('route') + '/send_sign',
				type:"POST",
				data: data+'&status_id='+action+'&record_id='+record_id,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( response.saved )
					{
						document.location = base_url + module.get('route') ;
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}


function cancel_clearance( user_id, action_id, clearance_id )
{
	$.blockUI({ message: saving_message(),
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/cancel_clearance',
				type:"POST",
				data: 'user_id='+user_id+'&action_id='+action_id+'&clearance_id='+clearance_id,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( response.saved )
					{
						document.location = base_url + module.get('route') ;
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}