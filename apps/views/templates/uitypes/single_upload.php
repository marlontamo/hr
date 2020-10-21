$('#<?php echo $table?>-<?php echo $column?>-fileupload').fileupload({
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
		$('#<?php echo $table?>-<?php echo $column?>').val(file.url);
		$('#<?php echo $table?>-<?php echo $column?>-container .fileupload-preview').html(file.name);
		$('#<?php echo $table?>-<?php echo $column?>-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		$('#<?php echo $table?>-<?php echo $column?>-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
	}
}).bind('fileuploadfail', function (e, data) {
	$.unblockUI();
	notify('error', data.errorThrown);
});

$('#<?php echo $table?>-<?php echo $column?>-container .fileupload-delete').click(function(){
	$('#<?php echo $table?>-<?php echo $column?>').val('');
	$('#<?php echo $table?>-<?php echo $column?>-container .fileupload-preview').html('');
	$('#<?php echo $table?>-<?php echo $column?>-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
	$('#<?php echo $table?>-<?php echo $column?>-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
});

if( $('#<?php echo $table?>-<?php echo $column?>').val() != "" )
{
	$('#<?php echo $table?>-<?php echo $column?>-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
	$('#<?php echo $table?>-<?php echo $column?>-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
}