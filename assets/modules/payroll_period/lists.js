function process_record( record_id )
{
	bootbox.confirm("Are you sure you want to process this period?", function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: lang.common.processing, 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/process_record',
						type:"POST",
						data: 'record_id='+record_id,
						dataType: "json",
						async: false,
						success: function ( response ) {
							handle_ajax_message( response.message );	
							$('.modal-container').modal('hide');
							$.unblockUI();
							self.location.reload();
						}
					});
				}
			});
		}
	});
}

function closed_record( record_id )
{
	bootbox.confirm("Are you sure you want to close this period?", function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: lang.common.closing, 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/closed_record',
						type:"POST",
						data: 'record_id='+record_id,
						dataType: "json",
						async: false,
						beforeSend: function(){
							
						},
						success: function ( response ) {
							handle_ajax_message( response.message );	
							$('.modal-container').modal('hide');
							$.unblockUI();
							self.location.reload();
						}
					});
				}
			});
		}
	});
}