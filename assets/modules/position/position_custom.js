$(document).ready(function(){

	$('select[name="users_position[immediate_id]"]').live('change',function(){
		get_immediate_position($(this).val());
	});

	$('#users_position-photo-fileupload').fileupload({ 
		url: base_url + module.get('route') + '/single_upload',
		autoUpload: true,
		contentType: false,
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
		    $('#users_position-photo-container .fileupload-preview').html(file.name);
		    $('#photo-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		    $('#photo-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
		    $('#users_position-photo').val(file.url);
		}
	}).bind('fileuploadfail', function (e, data) { 
		$.unblockUI();
		notify('error', data.errorThrown);
	});

	$('#photo-container .fileupload-delete').click(function(){
		$('#users_position-photo').val('');
		$('#users_position-photo-container .fileupload-preview').html('');
	    // $("#img-preview").attr('src', base_url + 'assets/img/avatar.png');
		$('#photo-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
		$('#photo-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
	});

	if( $('#users_position-photo').val() != "" )
	{
		$('#users_position-photo-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		$('#users_position-photo-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
	}

});


function get_immediate_position(user_id){


	var url = base_url + module.get('route') + '/get_immediate_position';
	var data = 'user_id='+user_id;

	$.ajax({
	    url: url,
	    dataType: 'json',
	    type:"POST",
	    data: data,
	    success: function (response) {
	    	$('input[name="users_position[immediate_position]"]').val(response.position);

	    }
	});



}