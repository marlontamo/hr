

function quick_view( record_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/quick_edit',
				type:"POST",
				async: false,
				data: 'record_id='+record_id,
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( typeof(response.quick_edit_form) != 'undefined' )
					{
						$('.modal-container').attr('data-width', '800');
						$('.modal-container').html(response.quick_edit_form);
						$('.modal-container').modal();
					}
				}
			});
		}
	});
	$.unblockUI();	
}