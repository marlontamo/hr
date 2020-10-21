$(document).ready(function(){
$(":input").inputmask();
$('#recruitment_manpower_plan-company_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#recruitment_manpower_plan-department_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#recruitment_manpower_plan-attachment-fileupload').fileupload({
    url: base_url + module.get('route') + '/multiple_upload',
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
		var cur_val = $('#recruitment_manpower_plan-attachment').val();
		if( cur_val == '' )
			$('#recruitment_manpower_plan-attachment').val(file.upload_id);
		else
			$('#recruitment_manpower_plan-attachment').val(cur_val + ',' +file.upload_id);
		$('#recruitment_manpower_plan-attachment-container ul').append(file.icon);
	}
}).bind('fileuploadfail', function (e, data) {
	$.unblockUI();
	notify('error', data.errorThrown);
});

$('#recruitment_manpower_plan-attachment-container .fileupload-delete').stop().live('click', function(event){
	event.preventBubble=true;
	var upload_id = $(this).attr('upload_id');
	$('li.fileupload-delete-'+upload_id).remove();
	var cur_val = $('#recruitment_manpower_plan-attachment').val();
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
		$('#recruitment_manpower_plan-attachment').val( '' );
	else
		$('#recruitment_manpower_plan-attachment').val( new_val.join(',') );
});});