

function quick_view( record_id )
{
	var view = 'detail';
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/quick_edit',
				type:"POST",
				async: false,
				data: 'record_id='+record_id+'&view='+view,
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

/*function save( form, action, callback )
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
						
						setTimeout(function(){ 
							document.location = base_url + module.get('route');
						}, 500);
						
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}*/