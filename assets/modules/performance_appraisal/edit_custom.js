$(document).ready(function(){
    $(".delete_row").live('click', function(){
        delete_child( $(this), '' )
    });

    $('#performance_appraisal-planning_id').change(function(){
        if($(this).val() > 0){
            get_planning( $(this).val(), $('#record_id').val() );
        }else{
            notify('warning', 'Please Select Planning.');
        }
    });

    if($('#record_id').val() > 0 ){
            get_planning( $('#performance_appraisal-planning_id').val(), $('#record_id').val() );
    }else{
        // $("#ddlMultiselect").multiselect("clearSelection");
        $('#performance_appraisal-performance_type_id').html('');
        // $('#performance_appraisal-template_id').multiselect("destroy");        
        // $('#performance_appraisal-template_id').html('').multiselect();        
        $('#performance_appraisal-template_id').html('');
        // $('#performance_appraisal-employment_status_id').multiselect("destroy");        
        // $('#performance_appraisal-employment_status_id').html('').multiselect();    
        $('#performance_appraisal-employment_status_id').html('');
        $('#performance_appraisal-filter_by').html('');
        $('#performance_appraisal-filter_id').multiselect("destroy");        
        $('#performance_appraisal-filter_id').html('').multiselect();
        $('#performance_appraisal_applicable-user_id').multiselect("destroy");        
        $('#performance_appraisal_applicable-user_id').html('').multiselect();
    }

    if (jQuery().datepicker) {
        $('.reminder_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }

    $('.reminder_stat').change(function(){
        if( $(this).is(':checked') ){
            $(this).parent().next().val(1);
        }
        else{
            $(this).parent().next().val(0);
        }
    });

    if (jQuery().datepicker) {
        $('.remind_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }

    //attachments
    $('.reminder_file').fileupload({
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
            $(this).parent().parent().parent().parent().children('input:hidden:first').val(file.url);
            $(this).parent().parent().children('ul').children('span').html(file.name);
            $(this).parent().children('span.fileupload-new').css('display', 'none');
            $(this).parent().children('span.fileupload-exists').css('display', 'inline-block');
            $(this).parent().parent().children('a.fileupload-exists').css('display', 'inline-block');
        }
    }).bind('fileuploadfail', function (e, data) {
        $.unblockUI();
        notify('error', data.errorThrown);
    });

    $('.fileupload-delete').click(function(){
        $(this).parent().parent().parent().children('input:hidden:first').val('');
        $(this).parent().children('ul').children('span.fileupload-preview').html('');
        $(this).parent().children('span.add_file').children('span.fileupload-new').css('display', 'inline-block');
        $(this).parent().children('span.add_file').children('span.fileupload-exists').css('display', 'none');
        $(this).css('display', 'none');
    });

    $('.reminder_file').each(function () {
        if( $(this).parent().parent().parent().parent().children('input:hidden:first').val() != "" )
        {
            $(this).parent().children('span.fileupload-new').css('display', 'none');
            $(this).parent().children('span.fileupload-exists').css('display', 'inline-block');
            $(this).parent().parent().children('a.fileupload-exists').css('display', 'inline-block');
        }
    });

});
//add score 
function add_form(add_form, mode, sequence){
    var form_value = $("#notification_id").val();
    if($.trim(form_value) != ""){
        $.ajax({
            url: base_url + module.get('route') + '/add_form',
            type:"POST",
            async: false,
            data: 'add_form='+add_form+'&form_value='+form_value+'&start_date='+$('#performance_appraisal-date_from').val(),
            dataType: "json",
            beforeSend: function(){
            },
            success: function ( response ) {

                for( var i in response.message )
                {
                    if(response.message[i].message != "")
                    {
                        var message_type = response.message[i].type;
                        notify(response.message[i].type, response.message[i].message);
                    }
                }
                if( typeof(response.add_form) != 'undefined' )
                {   
                    $('#'+add_form).val('');
                    // $('#add_'+mode).remove();
                    $('#'+mode).append(response.add_form);
                    if( mode == 'reminder' )
                    {
                        $('#reminder-table').removeClass('hidden');
                        $('#reminder-note').hide('slow');
                    }
                }

            }
        }); 
    }else{
        notify('warning', 'Please Select Reminder Type.');
    }
}

function delete_child( record, callback )
{
    bootbox.confirm("Are you sure you want to delete this item?", function(confirm) {
        if( confirm )
        {
            _delete_child( record, callback );
        } 
    });
}

function _delete_child( records, callback )
{
    var child_id = records.data('record-id');
    if(child_id > 0){
        $.ajax({
            url: base_url + module.get('route') + '/delete_child',
            type:"POST",
            data: 'records='+records+'&child_id='+child_id,
            dataType: "json",
            async: false,
            beforeSend: function(){
                $('body').modalmanager('loading');
            },
            success: function ( response ) {
                $('body').modalmanager('removeLoading');
                handle_ajax_message( response.message );
                if(response.record_deleted == 1){
                    setTimeout(function(){
                        $('body').modalmanager('removeLoading');
                        records.closest('tr').remove();
                    }, 500);
                }
            }
        });
    }else{
        notify('success', "Record successfully deleted");
        setTimeout(function(){
            $('body').modalmanager('removeLoading');
            records.closest('tr').remove();
        }, 500);
    }
}

//add score 
function get_appplicable_references(record_id){
    $.ajax({
        url: base_url + module.get('route') + '/get_appplicable_references',
        type:"POST",
        async: false,
        data: 'record_id='+record_id,
        dataType: "json",
        beforeSend: function(){
        },
        success: function ( response ) {
            console.log(response)
            if( typeof(response.applicable_for) != 'undefined' )
            {   
                for( var i in response.applicable_for )
                {
                    if(response.applicable_for[i].label != "")
                    {
                        $('#performance_appraisal_applicable-reference_id').tagsinput('add', { "value": response.applicable_for[i].value , "label": response.applicable_for[i].label  });
                    }
                }
            }

        }
    }); 
}

//get filters 
function get_planning(planning_id, appraisal_id){
    data = {
        planning_id     : planning_id,
        appraisal_id    : appraisal_id
    }
    $.ajax({
        url: base_url + module.get('route') + '/get_planning',
        type:"POST",
        async: false,
        data: data,
        dataType: "json",
        beforeSend: function(){
        },
        success: function ( response ) {
            if( typeof(response.user_id) != 'undefined' )
            {   
                $('#performance_appraisal-year').val(response.year);
                $('#performance_appraisal-filter_id').html(response.filter_id);
                $("#performance_appraisal-filter_id").multiselect("destroy");
                $('#performance_appraisal-filter_id').multiselect({
                    numberDisplayed: response.filter_id_count
                });
                $('input[name="multiselect_performance_appraisal-filter_id"]').each( function() {
                    $(this).attr('checked',true);
                    $(this).attr('aria-selected',true);
                });
                $('#performance_appraisal-template_id').html(response.template_id);
                $("#performance_appraisal-template_id").select2('destroy');
                $("#performance_appraisal-template_id").select2();
                
                // $("#performance_appraisal-template_id").multiselect("destroy");
                // $('#performance_appraisal-template_id').multiselect({
                //     numberDisplayed: response.template_id_count
                // });
                // $('input[name="multiselect_performance_appraisal-template_id"]').each( function() {
                //     $(this).attr('checked',true);
                //     $(this).attr('aria-selected',true);
                // });
                $('#performance_appraisal-employment_status_id').html(response.employment_status_id);
                $("#performance_appraisal-employment_status_id").select2('destroy');
                $("#performance_appraisal-employment_status_id").select2();
                    //  $("#performance_appraisal-employment_status_id").select2({
                    //     tags:["red", "green", "blue"],
                    //     maximumInputLength: 10
                    // });
                // $("#performance_appraisal-employment_status_id").multiselect("destroy");
                // $('#performance_appraisal-employment_status_id').multiselect({
                //     numberDisplayed: response.employment_status_id_count
                // });
                // $('input[name="multiselect_performance_appraisal-employment_status_id"]').each( function() {
                //     $(this).attr('checked',true);
                //     $(this).attr('aria-selected',true);
                // });

                $('#performance_appraisal-performance_type_id').html(response.performance_type_id);
                $('#performance_appraisal-filter_by').html(response.filter_by);
                $("#performance_appraisal-filter_by").select2('destroy');
                $("#performance_appraisal-filter_by").select2();
                $("#performance_appraisal-performance_type_id").select2('destroy');
                $("#performance_appraisal-performance_type_id").select2();

                $('.ui-multiselect-checkboxes').find('li input[type="checkbox"]').remove();
                $('.select2-search-choice-close').remove();
                $('.ui-multiselect-all').parent().parent().parent().hide();
                
                setTimeout(function(){
                    $('#performance_appraisal_applicable-user_id').html(response.user_id);
                    $("#performance_appraisal_applicable-user_id").multiselect("destroy");
                    $('#performance_appraisal_applicable-user_id').multiselect({
                        numberDisplayed: response.user_id_count
                    });
                    if(!(response.selected_filter) == 1){
                        $('input[name="multiselect_performance_appraisal_applicable-user_id"]').each( function() {
                            $(this).attr('checked',true);
                            $(this).attr('aria-selected',true);
                        });
                    }
                }, 500);

            }
        }
    }); 
}

//get filters 
function get_filters(record_id, appraisal_id){
    data = {
        record_id : record_id,
        appraisal_id : appraisal_id
    }
    $.ajax({
        url: base_url + module.get('route') + '/get_filters',
        type:"POST",
        async: false,
        data: data,
        dataType: "json",
        beforeSend: function(){
        },
        success: function ( response ) {
            if( typeof(response.filter_by) != 'undefined' )
            {   
                $('#performance_appraisal-filter_id').html(response.filter_by);
                $("#performance_appraisal-filter_id").multiselect("destroy");
                $('#performance_appraisal-filter_id').multiselect({
                    numberDisplayed: response.count
                });
                if(!(response.selected_filter) == 1){
                    $('input[name="multiselect_performance_appraisal-filter_id"]').each( function() {
                        $(this).attr('checked',true);
                        $(this).attr('aria-selected',true);
                    });
                }
            }
        }
    }); 
}

//get filters 
function get_selection_filters(template_id, filter_by, filter_id, appraisal_id, employment_status_id){
    data = {
        template_id : template_id,
        filter_by : filter_by,
        filter_id : filter_id,
        appraisal_id : appraisal_id,
        employment_status_id : employment_status_id
    }
    $.ajax({
        url: base_url + module.get('route') + '/get_selection_filters',
        type:"POST",
        async: false,
        data: data,
        dataType: "json",
        beforeSend: function(){
        },
        success: function ( response ) {
            if( typeof(response.employees) != 'undefined' )
            {   
                $('#performance_appraisal_applicable-user_id').html(response.employees);
                $("#performance_appraisal_applicable-user_id").multiselect("destroy");
                $('#performance_appraisal_applicable-user_id').multiselect({
                    numberDisplayed: response.count
                });
                if(!(response.selected_filter) == 1){
                    $('input[name="multiselect_performance_appraisal_applicable-user_id"]').each( function() {
                        $(this).attr('checked',true);
                        $(this).attr('aria-selected',true);
                    });
                }
            }

        }
    }); 
}


function save_record( form, action, callback )
{
    $.blockUI({ message: saving_message(),
        onBlock: function(){

            var hasCKItem = form.find("textarea.ckeditor");

            if(hasCKItem && (typeof editor != 'undefined')){
                
                for ( instance in CKEDITOR.instances )
                    CKEDITOR.instances[instance].updateElement();
            }

            var data = form.find(":not('.dontserializeme')").serialize();
            $.ajax({
                url: base_url + module.get('route') + '/save',
                type:"POST",
                data: data,
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );

                    if(response.notify != "undefined")
                    {
                        for(var i in response.notify)
                            socket.emit('get_push_data', {channel: 'get_user_'+response.notify[i]+'_notification', args: { broadcaster: user_id, notify: true }});
                    }
                    
                    if( response.saved )
                    {
                        if( response.action == 'insert' )
                            $('#record_id').val( response.record_id );

                        if (typeof(after_save) == typeof(Function)) after_save( response );
                        if (typeof(callback) == typeof(Function)) callback( response );

                        switch( action )
                        {
                            case 'new':
                                document.location = base_url + module.get('route') + '/add';
                                break;
                        }
                    }
                }
            });
        },
        baseZ: 300000000
    });
    $.unblockUI();
}