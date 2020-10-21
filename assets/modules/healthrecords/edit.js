$(document).ready(function(){
$('#partners_health_records-attachments-fileupload').fileupload({
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
		$('#partners_health_records-attachments').val(file.url);
		$('#partners_health_records-attachments-container .fileupload-preview').html(file.name);
		$('#partners_health_records-attachments-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		$('#partners_health_records-attachments-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
	}
}).bind('fileuploadfail', function (e, data) {
	$.unblockUI();
	notify('error', data.errorThrown);
});

$('#partners_health_records-attachments-container .fileupload-delete').click(function(){
	$('#partners_health_records-attachments').val('');
	$('#partners_health_records-attachments-container .fileupload-preview').html('');
	$('#partners_health_records-attachments-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
	$('#partners_health_records-attachments-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
});

if( $('#partners_health_records-attachments').val() != "" )
{
	$('#partners_health_records-attachments-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
	$('#partners_health_records-attachments-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
}
$('#partners_health_records-health_type_status_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
if (jQuery().datepicker) {
    $('#partners_health_records-date_of_completion').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
$('#partners_health_records-health_type_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#partners_health_records-partner_id').select2({
    placeholder: "Select an option",
    allowClear: true
});});