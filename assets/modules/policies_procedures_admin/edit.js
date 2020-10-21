$(document).ready(function(){
$('#resources_policies-attachments-fileupload').fileupload({
    url: base_url + module.get('route') + '/single_upload',
    autoUpload: true,
}).bind('fileuploadadd', function (e, data) {
	$.blockUI({ 
		'baseZ' : 11000,
		message: '<div>Attaching file, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />' 
	});
}).bind('fileuploaddone', function (e, data) {
	$.unblockUI({'baseZ' : 11000});
	var file = data.result.file;
	if(file.error != undefined && file.error != "")
	{
		notify('error', file.error);
	}
	else{
		$('#resources_policies-attachments').val(file.url);
		$('#resources_policies-attachments-container .fileupload-preview').html(file.name);
		$('#resources_policies-attachments-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		$('#resources_policies-attachments-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
	}
}).bind('fileuploadfail', function (e, data) {
	$.unblockUI({'baseZ' : 11000});
	notify('error', data.errorThrown);
});

$('#resources_policies-attachments-container .fileupload-delete').click(function(){
	$('#resources_policies-attachments').val('');
	$('#resources_policies-attachments-container .fileupload-preview').html('');
	$('#resources_policies-attachments-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
	$('#resources_policies-attachments-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
});

if( $('#resources_policies-attachments').val() != "" )
{
	$('#resources_policies-attachments-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
	$('#resources_policies-attachments-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
}
$('#resources_policies-category').select2({
    placeholder: "Select an option",
    allowClear: true
});});