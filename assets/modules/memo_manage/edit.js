$(document).ready(function(){
$('#memo-attachment-fileupload').fileupload({
    url: base_url + module.get('route') + '/single_upload',
    autoUpload: true,
}).bind('fileuploadadd', function (e, data) {
	$.blockUI({ message: '<div>Attaching file, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />' });
}).bind('fileuploaddone', function (e, data) {
	$.unblockUI();

	var file = data.result.file;
	if(file){
		if(file.error != undefined && file.error != "")
		{
			notify('error', file.error);
		}
		else{
			$('#memo-attachment').val(file.url);
			$('#memo-attachment-container .fileupload-preview').html(file.name);
			$('#memo-attachment-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
			$('#memo-attachment-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
		}
	}else{		
		for( var i in data.result.message )
		{
			if(data.result.message[i].message != "")
			{
				var message_type = data.result.message[i].type;
				notify(data.result.message[i].type, data.result.message[i].message);
			}
		}
		$('#memo-attachment').val('');
		$('#memo-attachment-container .fileupload-preview').html('');
		$('#memo-attachment-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
		$('#memo-attachment-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
	}
}).bind('fileuploadfail', function (e, data) {
	$.unblockUI();
	notify('error', data.errorThrown);
});

$('#memo-attachment-container .fileupload-delete').click(function(){
	$('#memo-attachment').val('');
	$('#memo-attachment-container .fileupload-preview').html('');
	$('#memo-attachment-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
	$('#memo-attachment-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
});

if( $('#memo-attachment').val() != "" )
{
	$('#memo-attachment-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
	$('#memo-attachment-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
}
$('#memo-memo_type_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#memo-apply_to_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
if (jQuery().datepicker) {
    $('#memo-publish_from').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
if (jQuery().datepicker) {
    $('#memo-publish_to').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
$('#memo-publish-temp').change(function(){
	if( $(this).is(':checked') )
		$('#memo-publish').val('1');
	else
		$('#memo-publish').val('0');
});
$('#memo-comments-temp').change(function(){
	if( $(this).is(':checked') )
		$('#memo-comments').val('1');
	else
		$('#memo-comments').val('0');
});

$('#memo-email-temp').change(function(){
	if( $(this).is(':checked') )
		$('#memo-email').val('1');
	else
		$('#memo-email').val('0');
});

$('#reemail-temp').change(function(){
	if( $(this).is(':checked') )
		$('#reemail').val('1');
	else
		$('#reemail').val('0');
});

});