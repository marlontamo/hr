
function ajax_export( record_id )
{
	$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				// {{ get_mod_route('report_generator') }}
				url: base_url + module.get('route') +'/view_file',
				type:"POST",
				dataType: "json",
				data:'record_id='+record_id,
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