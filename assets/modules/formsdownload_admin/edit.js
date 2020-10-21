$(document).ready(function(){
$('#resources_downloadable-attachments-fileupload').fileupload({
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
		$('#resources_downloadable-attachments').val(file.url);
		$('#resources_downloadable-attachments-container .fileupload-preview').html(file.name);
		$('#resources_downloadable-attachments-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		$('#resources_downloadable-attachments-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
	}
}).bind('fileuploadfail', function (e, data) {
	$.unblockUI();
	notify('error', data.errorThrown);
});

$('#resources_downloadable-attachments-container .fileupload-delete').click(function(){
	$('#resources_downloadable-attachments').val('');
	$('#resources_downloadable-attachments-container .fileupload-preview').html('');
	$('#resources_downloadable-attachments-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
	$('#resources_downloadable-attachments-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
});

if( $('#resources_downloadable-attachments').val() != "" )
{
	$('#resources_downloadable-attachments-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
	$('#resources_downloadable-attachments-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
}
$('#resources_downloadable-category').select2({
    placeholder: "Select an option",
    allowClear: true
});});