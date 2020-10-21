$(document).ready(function() {
	$('#partners_clinic_records-attachments-fileupload').fileupload({
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
			$('#partners_clinic_records-attachments').val(file.url);
			$('#partners_clinic_records-attachments-container .fileupload-preview').html(file.name);
			$('#partners_clinic_records-attachments-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
			$('#partners_clinic_records-attachments-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
		}
	}).bind('fileuploadfail', function (e, data) {
		$.unblockUI();
		notify('error', data.errorThrown);
	});

	$('#partners_clinic_records-attachments-container .fileupload-delete').click(function(){
		$('#partners_clinic_records-attachments').val('');
		$('#partners_clinic_records-attachments-container .fileupload-preview').html('');
		$('#partners_clinic_records-attachments-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
		$('#partners_clinic_records-attachments-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
	});

	if( $('#partners_clinic_records-attachments').val() != "" )
	{
		$('#partners_clinic_records-attachments-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		$('#partners_clinic_records-attachments-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
	}
});