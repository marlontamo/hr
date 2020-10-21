$(document).ready(function(){

	$('#partners_incident_nte-attachments-fileupload').fileupload({
	    url: base_url + module.get('route') + '/single_upload',
	    autoUpload: true,
	}).bind('fileuploadadd', function (e, data) {
		$.blockUI({ message: '<div>Attaching file, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />' });
	}).bind('fileuploaddone', function (e, data) {
		$.unblockUI();
		var file = data.result.file;
		if(file.error != undefined && file.error != "")
		{
			notify('error', file.error);
		}
		else{
			$('#partners_incident_nte-attachments').val(file.url);
			$('#partners_incident_nte-attachments-container .fileupload-preview').html(file.name);
			$('#partners_incident_nte-attachments-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
			$('#partners_incident_nte-attachments-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
		}
	}).bind('fileuploadfail', function (e, data) {
		$.unblockUI();
		notify('error', data.errorThrown);
	});

	$('#partners_incident_nte-attachments-container .fileupload-delete').click(function(){
		$('#partners_incident_nte-attachments').val('');
		$('#partners_incident_nte-attachments-container .fileupload-preview').html('');
		$('#partners_incident_nte-attachments-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
		$('#partners_incident_nte-attachments-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
	});

	if( $('#partners_incident_nte-attachments').val() != "" )
	{
		$('#partners_incident_nte-attachments-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		$('#partners_incident_nte-attachments-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
	}
});

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