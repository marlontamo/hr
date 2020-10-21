$(document).ready(function(){
$('#play_badges-image_path-fileupload').fileupload({
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
		$('#play_badges-image_path').val(file.url);
		$('#play_badges-image_path-container .fileupload-preview').html(file.name);
		$('#play_badges-image_path-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		$('#play_badges-image_path-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
	}
}).bind('fileuploadfail', function (e, data) {
	$.unblockUI();
	notify('error', data.errorThrown);
});

$('#play_badges-image_path-container .fileupload-delete').click(function(){
	$('#play_badges-image_path').val('');
	$('#play_badges-image_path-container .fileupload-preview').html('');
	$('#play_badges-image_path-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
	$('#play_badges-image_path-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
});

if( $('#play_badges-image_path').val() != "" )
{
	$('#play_badges-image_path-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
	$('#play_badges-image_path-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
}});