    $('#bg_image-upload_id-fileupload').fileupload({
        url: base_url + module.get('route') + '/multiple_upload_image',
        disableImageResize: false,
        imageMaxWidth: 1280,
        imageForceResize: true,
        autoUpload: true
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
            var cur_val = $('#bg_image-upload_id').val();
            if( cur_val == '' ){
                $('#bg_image-upload_id').val(file.upload_id);
            }
            else{
                $('#bg_image-upload_id').val(cur_val + ',' +file.upload_id);
            }
            $('#bg_image-upload_id-container ul').append(file.icon);
        }
    }).bind('fileuploadfail', function (e, data) {
        $.unblockUI();
        notify('error', data.errorThrown);
    });

    $('#bg_image-upload_id-container .fileupload-delete').click(function(event){
        event.stopPropagation();
        //event.preventBubble=true;
        var upload_id = $(this).attr('upload_id');
       
        var cur_val = $('#bg_image-upload_id').val();
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
            $('#bg_image-upload_id').val( '' );
        else
            $('#bg_image-upload_id').val( new_val.join(',') );

        $.ajax({
            url: base_url + module.get('route') + '/delete_bg_image',
            type:"POST",
            async: false,
            data: {'bg_image': upload_id},
            dataType: "json",
            async: false,
            success: function ( response ) {

                if(response.message.type == 'success')
                {
                     $('li.fileupload-delete-'+upload_id).remove();
                }
                else
                {
                    $('.alert-danger span').html( response.message.message );
                    $('.alert-danger').slideDown();
                }

            }
        });
    });



    $('#config-general-logo').fileupload({ 
        url: base_url + module.get('route') + '/single_upload_login',
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
            $('#logo-img-preview').attr('src',root_url + file.site_url);
            $('#logo-photo-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
            $('#logo-photo-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
            $('#image_filename').val(file.url);
        }
    }).bind('fileuploadfail', function (e, data) { 
        $.unblockUI();
        notify('error', data.errorThrown);
    });

    $('#logo-photo-container .fileupload-delete').click(function(){
        $('#image_filename').val('');
        $('#logo-img-preview').attr('src','');
        $('#logo-photo-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
        $('#logo-photo-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
    });

    if( $('#image_filename').val() != "" )
    {
        $('#logo-photo-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
        $('#logo-photo-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
    }


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

    if (jQuery().datepicker) {
        $('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
    }
       

