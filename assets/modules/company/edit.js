


    $('#config-general-header_logo').fileupload({ 
        url: base_url + module.get('route') + '/single_upload_header',
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
            $('#header_logo-img-preview').attr('src',root_url + file.site_url);
            $('#header_logo-photo-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
            $('#header_logo-photo-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
            $('#header_logo-image_filename').val(file.url);
        }
    }).bind('fileuploadfail', function (e, data) {
        $.unblockUI();
        notify('error', data.errorThrown);
    });

    $('#header_logo-photo-container .fileupload-delete').click(function(){
        $('#header_logo-image_filename').val('');
        $('#header_logo-img-preview').attr('src','');
        $('#header_logo-photo-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
        $('#header_logo-photo-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
    });

    if( $('#header_logo-image_filename').val() != "" )
    {
        $('#header_logo-photo-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
        $('#header_logo-photo-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
    }


    $('#config-general-print_logo').fileupload({ 
        url: base_url + module.get('route') + '/single_upload_print',
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
            $('#print_logo-img-preview').attr('src',root_url + file.site_url);
            $('#print_logo-photo-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
            $('#print_logo-photo-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
            $('#print_logo-image_filename').val(file.url);
        }
    }).bind('fileuploadfail', function (e, data) {
        $.unblockUI();
        notify('error', data.errorThrown);
    });

    $('#print_logo-photo-container .fileupload-delete').click(function(){
        $('#print_logo-image_filename').val('');
        $('#print_logo-img-preview').attr('src','');
        $('#print_logo-photo-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
        $('#print_logo-photo-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
    });

    if( $('#print_logo-image_filename').val() != "" )
    {
        $('#print_logo-photo-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
        $('#print_logo-photo-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
    }