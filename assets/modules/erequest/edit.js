$(document).ready(function(){
$('#resources_request-user_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#resources_request_upload-upload_id-fileupload').fileupload({
    url: base_url + module.get('route') + '/multiple_upload',
    autoUpload: true,
}).bind('fileuploadadd', function (e, data) {
	$.blockUI({ message: '<div>Attaching file, please wait...</div><img src="'+base_url+'assets/img/ajax-loading.gif" />' });
}).bind('fileuploaddone', function (e, data) {
	$.unblockUI();
	var file = data.result.file;
	var cur_val = $('#resources_request_upload-upload_id').val();
	if(file.error != undefined && file.error != "")
	{
		notify('error', file.error);
	}
	else{
		if( cur_val == '' )
			$('#resources_request_upload-upload_id').val(file.upload_id);
		else
			$('#resources_request_upload-upload_id').val(cur_val + ',' +file.upload_id);
		$('#resources_request_upload-upload_id-container ul').append(file.icon);
	}
}).bind('fileuploadfail', function (e, data) {
	$.unblockUI();
	notify('error', data.errorThrown);
});

$('#resources_request_upload-upload_id-container .fileupload-delete').stop().live('click', function(event){
	event.preventBubble=true;
	var upload_id = $(this).attr('upload_id');
	$('li.fileupload-delete-'+upload_id).remove();
	var cur_val = $('#resources_request_upload-upload_id').val();
	var new_val = new Array();
	new_val_ctr = 0;
	if(cur_val != ""){
		cur_val = cur_val.split(',');
		for(var i in cur_val)
		{
			if( cur_val[i] != upload_id )
			{
				new_val[new_val_ctr] = cur_val[i];
				new_val_ctr++;
			}
		}
	}

	if( new_val_ctr == 0 )
		$('#resources_request_upload-upload_id').val( '' );
	else
		$('#resources_request_upload-upload_id').val( new_val.join(',') );
});
if (jQuery().datepicker) {
    $('#resources_request-date_needed').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}});