$(document).ready(function(){
	$('#template-fileupload').fileupload({
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
			$('#template').val(file.url);
			$('#template-container .fileupload-preview').html(file.name);
			$('#template-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
			$('#template-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
		}
	}).bind('fileuploadfail', function (e, data) {
		$.unblockUI();
		console.log(data.errorThrown);
		//notify('error', data.errorThrown);
	});


	$('#template_id').change(function(){
		if( $(this).val() != "" )
		{
			load_template( $(this).val() )
		}
	});

	$('#template-container .fileupload-delete').click(function(){
		$('#template').val('');
		$('#template-container .fileupload-preview').html('');
		$('#template-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
		$('#template-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
	});

	if( $('#template').val() != "" )
	{
		$('#template-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		$('#template-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
	}	
});

function load_template( template_id )
{
	$('a.fileupload-delete').trigger('click');
	//reload list
	create_list();
}

function start_upload()
{
	if( $('#template_id').val() == "" )
	{
		notify('warning', lang.upload_utility.choose_template )
		return;
	}
	if( $('#template').val() == "" )
	{
		notify('warning', lang.upload_utility.missing_file )
		return;
	}

	$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/upload',
				type:"POST",
				data: $('form[name="upload-form"]').serialize(),
				dataType: "json",
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					create_list();
				}
			});
		}
	});
	$.unblockUI();
}