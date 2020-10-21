function get_param_form()
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/get_param_form',
				type:"POST",
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( typeof(response.quick_edit_form) != 'undefined' )
					{
						$('.modal-container').html(response.quick_edit_form);
						$('.modal-container').modal();
/*
						if (report_id == 92){
							$("#full_name").select2("val", response.user_id);
						}*/
					}
				}
			});
		}
	});
	$.unblockUI();	
}

function ajax_export_custom( form )
{
	$.blockUI({ message: '<div>'+lang.common.processing+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/export',
				type:"POST",
				dataType: "json",
				data: form.serialize(),
				async: false,
				success: function ( response ) {
					if( response.filename != undefined )
					{
						window.open( root_url + response.filename );
					}
					handle_ajax_message( response.message );
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();	
}