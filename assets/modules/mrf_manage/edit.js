$(document).ready(function(){

$('#recruitment_request-attachment-fileupload').fileupload({
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
            $('#recruitment_request-attachment').val(file.url);
            $('#recruitment_request-attachment-container .fileupload-preview').html(file.name);
            $('#recruitment_request-attachment-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
            $('#recruitment_request-attachment-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
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
        $('#recruitment_request-attachment').val('');
        $('#recruitment_request-attachment-container .fileupload-preview').html('');
        $('#recruitment_request-attachment-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
        $('#recruitment_request-attachment-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
    }
}).bind('fileuploadfail', function (e, data) {
    $.unblockUI();
    notify('error', data.errorThrown);
});

$('#recruitment_request-attachment-container .fileupload-delete').click(function(){
    $('#recruitment_request-attachment').val('');
    $('#recruitment_request-attachment-container .fileupload-preview').html('');
    $('#recruitment_request-attachment-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
    $('#recruitment_request-attachment-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
});

if( $('#recruitment_request-attachment').val() != "" )
{
    $('#recruitment_request-attachment-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
    $('#recruitment_request-attachment-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
}

$(".pop-uri").fancybox(
    {
        autoSize: false,
        width: '80%',
        height: '100%',
    }
);

$('.select2me').select2({
    placeholder: "Select an option",
    allowClear: true
});

});