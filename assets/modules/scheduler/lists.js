function process_form( record_id )
{
	$.ajax({
		url: base_url + module.get('route') + '/process_form',
		type:"POST",
		async: false,
		data: 'record_id='+record_id,
		dataType: "json",
		beforeSend: function(){
			$('.fa-spin').addClass('fa-spinner');
		},
		success: function ( response ) {
			handle_ajax_message( response.message );	
		}
	});
}