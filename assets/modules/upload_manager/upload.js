$(document).ready(function(){
    $('#upload-excel').fileupload({
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
        if(data.result.status == true){
            $('#count-valid-files').html(data.result.count_success);
            $('#success-upload-excel').show();
            $('#error-upload-excel').hide();
        }else{
            if(data.result.count_empty > 0){
                $('#count-empty-files').html('You have '+ data.result.count_empty +' empty record/s.');
            } else {
                $('#count-empty-files').html('Your file/s are not supported.');
            }
            $('#error-upload-excel').show();
            $('#success-upload-excel').hide();
        }


    }).bind('fileuploadfail', function (e, data) {
        $.unblockUI();
        notify('error', data.errorThrown);
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

    if( $('#template').val() == "" )
    {
        notify('warning', 'Please attached a file to upload.' )
        return;
    }

    $.blockUI({ message: '<div>Uploading File</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
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
                    // if(response.status == true){
                    //     $('#count-valid-files').html(response.count);
                    //     $('#success-upload-excel').show();
                    // }else{
                    //     $('#error-upload-excel').show();
                    // }
                    handle_ajax_message( response.message );
                    create_list();
                }
            });
        }
    });
    $.unblockUI();
}