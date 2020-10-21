$(document).ready(function(){
$('#users_profile-company_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#users-role_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#users-active-temp').change(function(){
	if( $(this).is(':checked') )
		$('#users-active').val('1');
	else
		$('#users-active').val('0');
});
$('#users_profile-photo-fileupload').fileupload({
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
		$('#users_profile-photo').val(file.url);
		$('#users_profile-photo-container .fileupload-preview').html(file.name);
		$('#users_profile-photo-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		$('#users_profile-photo-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });	
	}
	
}).bind('fileuploadfail', function (e, data) {
	$.unblockUI();
	notify('error', data.errorThrown);
});

$('#users_profile-photo-container .fileupload-delete').click(function(){
	$('#users_profile-photo').val('');
	$('#users_profile-photo-container .fileupload-preview').html('');
	$('#users_profile-photo-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
	$('#users_profile-photo-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
});

if( $('#users_profile-photo').val() != "" )
{
	$('#users_profile-photo-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
	$('#users_profile-photo-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
}


if (jQuery().datepicker) {
    $('#users_profile-birth_date').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}

});