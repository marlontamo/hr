$(document).ready(function(){
$('#partners_safe_manhour-attachment-fileupload').fileupload({
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
        $('#partners_safe_manhour-attachment').val(file.url);
    	$('#partners_safe_manhour-attachment-container .fileupload-preview').html(file.name);
    	$('#partners_safe_manhour-attachment-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
    	$('#partners_safe_manhour-attachment-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
    }
}).bind('fileuploadfail', function (e, data) {
	$.unblockUI();
	notify('error', data.errorThrown);
});

$('#partners_safe_manhour-attachment-container .fileupload-delete').click(function(){
	$('#partners_safe_manhour-attachment').val('');
	$('#partners_safe_manhour-attachment-container .fileupload-preview').html('');
	$('#partners_safe_manhour-attachment-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
	$('#partners_safe_manhour-attachment-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
});

if( $('#partners_safe_manhour-attachment').val() != "" )
{
	$('#partners_safe_manhour-attachment-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
	$('#partners_safe_manhour-attachment-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
}
$('#partners_safe_manhour-status_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
if (jQuery().datepicker) {
    $('#partners_safe_manhour-date_return_to_work').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
if (jQuery().datepicker) {
    $('#partners_safe_manhour-date_incident').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
$('#partners_safe_manhour-nature_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#partners_safe_manhour-partner_id').select2({
    placeholder: "Select an option",
    allowClear: true
});});