$(document).ready(function(){
    $('#performance_planning-template_id').change(function(){
        var template_id = $(this).val();
        get_section(template_id);
    });  

    if($('#record_id').val() > 0 ){
        var template_id = $('#performance_planning-template_id').val();
        if (template_id != ''){
            get_section(template_id);
        }
    }
        
    $(".delete_row").live('click', function(){
        delete_child( $(this), '' )
    });

    $(".delete_item").live('click', function(){
        var elem = $(this);
        bootbox.confirm("Are you sure you want to delete this item?", function(confirm) {
            if( confirm )
            {
                $(elem).closest('tr').remove();
                calc_weight();
            } 
        });
    });

    $('#performance_planning-filter_by').change(function(){
        if($(this).val() > 0){
            $('#performance_planning_applicable-user_id').html('');
            $("#performance_planning_applicable-user_id").multiselect("refresh");             
            get_filters( $(this).val() );
        }else{
            notify('warning', 'Please Select Filter By.');
        }
    });

    $('#performance_planning-filter_id').change(function(){
        if($(this).val()){
            get_selection_filters( $('#performance_planning-template_id').val(), $('#performance_planning-filter_by').val(), $(this).val(), $('#record_id').val(), $('#performance_planning-employment_status_id').val() );
        }else{
            notify('warning', 'Please Select Filters.');
        }
    });

    $('#performance_planning-employment_status_id').change(function(){
        if($(this).val()){
            get_selection_filters( $('#performance_planning-template_id').val(), $('#performance_planning-filter_by').val(), $('#performance_planning-filter_id').val(), $('#record_id').val(), $(this).val() );
        }else{
            notify('warning', 'Please Select Status Filters.');
        }
    });

    $('#performance_planning-template_id').change(function(){
        if($(this).val()){
            get_selection_filters( $(this).val(), $('#performance_planning-filter_by').val(), $('#performance_planning-filter_id').val(), $('#record_id').val(), $('#performance_planning-employment_status_id').val() );
        }else{
            notify('warning', 'Please Select Template.');
        }
    });

    $("#performance_planning-applicable_for_id").change(function(){ 
        $('#performance_planning-applicable_for').val($("#performance_planning-applicable_for_id option:selected").text());
        $('#performance_planning_applicable-reference_id').val('');
        $('#performance_planning_applicable-reference_id').tagsinput('removeAll');
    });

    // $('#performance_planning_applicable-reference_id').tagsinput({
    //     itemValue: 'value',
    //     itemText: 'label',
    //     typeahead: {
    //         source: function(query) {
    //             return $.getJSON(base_url + module.get('route') + '/applicable_selection?category='+$("#performance_planning-applicable_for_id").val());
    //         }
    //     }
    // });


    if($('#record_id').val() > 0 ){
            get_filters( $('#performance_planning-filter_by').val(), $('#record_id').val() );
            get_selection_filters( $('#performance_planning-template_id').val(), $('#performance_planning-filter_by').val(), $('#performance_planning-filter_id').val(), $('#record_id').val(), $('#performance_planning-employment_status_id').val() );
    }else{

        $('#performance_planning-filter_by').select2().select2('val', $('#performance_planning-filter_by option:eq(1)').val());
        //employees select all
        $('#performance_planning-filter_id option').attr('selected', 'selected');
        $('input[name="multiselect_performance_planning-filter_id"]').each( function() {
            $(this).attr('checked',true);
            $(this).attr('aria-selected',true);
        });
        $("#performance_planning-filter_id").multiselect("destroy");
        $('#performance_planning-filter_id').multiselect({
          numberDisplayed: $('input[name="multiselect_performance_planning-filter_id"]').length
        });

        //employees select all
        $('#performance_planning_applicable-user_id option').attr('selected', 'selected');
        $('input[name="multiselect_performance_planning_applicable-user_id"]').each( function() {
            $(this).attr('checked',true);
            $(this).attr('aria-selected',true);
        });
        $("#performance_planning_applicable-user_id").multiselect("destroy");
        $('#performance_planning_applicable-user_id').multiselect({
          numberDisplayed: $('input[name="multiselect_performance_planning_applicable-user_id"]').length
        });
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

    $('.test_attach').each(function () {
        if( $(this).parent().parent().parent().parent().children('input:hidden:first').val() != "" )
        {
            $(this).parent().children('span.fileupload-new').css('display', 'none');
            $(this).parent().children('span.fileupload-exists').css('display', 'inline-block');
            $(this).parent().parent().children('a.fileupload-exists').css('display', 'inline-block');
        }
    });

    // for planning section module
});

// for planning section module
function get_section( template_id )
{ 
    $.ajax({
        url: base_url + module.get('route') + '/get_section_header',
        type:"POST",
        data: 'template_id=' + template_id + '&planning_id=' + $('#record_id').val(),
        dataType: "json",
        async: true,
        success: function ( response ) {
            handle_ajax_message( response.message );
            $('#planning_section').html(response.section_header);
            calc_weight();
        }
    });
}


function view_transaction_logs( planning_id, user_id )
{
    $.blockUI({ message: loading_message(),
        onBlock: function(){
            var data = {
                planning_id: planning_id,
                user_id:user_id
            };
            $.ajax({
                url: base_url + module.get('route') + '/view_transaction_logs',
                type:"POST",
                data: data,
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );

                    if( typeof(response.trans_logs) != 'undefined' )
                    {
                        $('.modal-container').attr('data-width', '800');
                        $('.modal-container').html(response.trans_logs);
                        $('.modal-container').modal();
                    }
                }
            });
        },
        baseZ: 300000000
    });
    $.unblockUI();
}

function add_item( column_id, item_id, parent_id, section_id, elem )
{
    $('tbody.section-'+section_id).block({ message: '<div>Loading section items, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
        onBlock: function(){
            var data = {
                planning_id: $('input[name="planning_id"]').val(),
                user_id: $('input[name="user_id"]').val(),
                template_id: $('input[name="template_id"]').val(),
                section_id: section_id,
                parent_id: parent_id
            };

            $.ajax({
                url: base_url + module.get('route') + '/get_section_items',
                type:"POST",
                data: data,
                dataType: "json",
                async: true,
                success: function ( response ) {
                    handle_ajax_message( response.message );
                    if (!parent_id){
                        $('tbody.section-'+section_id).find('tr.markings').before( response.items );
                    }
                    else{
                        $(elem).closest('tr').after(response.items);
                        $(elem).parent('span').remove();                        
                    }
                    calc_weight();

                    if( !response.show_add_row )
                    {
                        $('button.add-kra-'+response.section_column_id).closest('tr').addClass('hidden');
                    }
                    else{
                        $('button.add-kra-'+response.section_column_id).closest('tr').removeClass('hidden');
                    }
                    $('tbody.section-'+section_id).unblock();
                }
            });
        },
        baseZ: 300000000
    }); 
}

function save_item()
{
    $.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
        onBlock: function(){            
            save_form($("#planning-form"), 1);
            $.ajax({
                url: base_url + module.get('route') + '/save_item',
                type:"POST",
                data: $('form#item-form').serialize(),
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );
                    if(response.close_modal)
                        $('.modal-container').modal('hide');
                    get_items( $('form#item-form input[name="section_column_id"]').val() );

                    if( !response.show_add_row )
                    {
                        $('button.add-kra-'+response.section_column_id).closest('tr').addClass('hidden');
                    }
                    else{
                        $('button.add-kra-'+response.section_column_id).closest('tr').removeClass('hidden');
                    }
                }
            });
        },
        baseZ: 300000000
    });
    $.unblockUI();  
}

function get_items( column_id )
{
    $.blockUI({ message: '<div>Reloading section items, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
        onBlock: function(){
            var data = {
                planning_id: $('input[name="planning_id"]').val(),
                user_id: $('input[name="user_id"]').val(),
                template_id: $('input[name="template_id"]').val(),
                column_id: column_id
            };
            $.ajax({
                url: base_url + module.get('route') + '/get_items',
                type:"POST",
                data: data,
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );
                    $('tbody.section-'+response.section_id + ' tr:not(.first-row)').each(function(){
                        $(this).remove();
                    });
                    $('tbody.section-'+response.section_id).prepend( response.items );
                    calc_weight();
                }
            });
        },
        baseZ: 300000000
    });
    $.unblockUI();
}

function get_section_item( section_id )
{
    $('tbody.section-'+section_id).block({ message: '<div>Loading section items, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
        onBlock: function(){
            var data = {
                planning_id: $('input[name="planning_id"]').val(),
                user_id: $('input[name="user_id"]').val(),
                template_id: $('input[name="template_id"]').val(),
                section_id: section_id
            };

            $.ajax({
                url: base_url + module.get('route') + '/get_section_items',
                type:"POST",
                data: data,
                dataType: "json",
                async: true,
                success: function ( response ) {
                    handle_ajax_message( response.message );
                    $('tbody.section-'+section_id + ' tr:not(.first-row)').each(function(){
                        $(this).remove();
                    });
                    $('tbody.section-'+section_id).prepend( response.items );
                    calc_weight();

                    if( !response.show_add_row )
                    {
                        $('button.add-kra-'+response.section_column_id).closest('tr').addClass('hidden');
                    }
                    else{
                        $('button.add-kra-'+response.section_column_id).closest('tr').removeClass('hidden');
                    }
                    $('tbody.section-'+section_id).unblock();
                }
            });
        },
        baseZ: 300000000
    }); 
}

function calc_weight()
{
    $('tbody.get-section').each(function(){
        var $this = $(this);
        var total = 0;
        $this.find('input.weight').each(function(){
            $(this).stop().change(function(){
                calc_weight();  
            });
            total = total + parseFloat( $(this).val() );

            if (total > 100){
                notify('error', 'Total weight must not greater to 100');
                $(this).val('');
                return;
            }            
        });

        if( !isNaN(total) )
            $(this).find('input#total-weight').val( round(total,2) );
    });
}

function get_section_items()
{
    $('tbody.get-section').each(function(){
        var section_id = $(this).attr('section');
        get_section_item(section_id);
    });
}

function delete_item( item_id )
{
    bootbox.confirm("Are you sure you want to delete this item?", function(confirm) {
        if( confirm )
        {
            save_form($("#planning-form"), 1);
            $.blockUI({ message: '<div>Deleting, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
                onBlock: function(){
                    $.ajax({
                        url: base_url + module.get('route') + '/delete_item',
                        type:"POST",
                        async: false,
                        data: {item_id:item_id},
                        dataType: "json",
                        success: function ( response ) {
                            get_section_items()     
                        }
                    });
                }
            });
            $.unblockUI();
        }
    });
}

function change_status(form, status_id)
{
    validation = 1;
    $.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
        onBlock: function(){
            var data = form.find(":not('.dontserializeme')").serialize() 
            + '&status_id='+status_id + 
            '&validation='+validation;
            $.ajax({
                url: base_url + module.get('route') + '/change_status',
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

                    if(response.redirect)
                        window.location = response.redirect;
                }
            });
        },
        baseZ: 300000000
    });
    $.unblockUI();  
}

function save_form(form, status_id)
{
    validation = 0;
    form.find('input[name="status_id"]').val(status_id);
    $.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
        onBlock: function(){
            var data = form.find(":not('.dontserializeme')").serialize() 
            +'&validation='+validation;
            $.ajax({
                url: base_url + module.get('route') + '/change_status',
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

                    // if(response.redirect)
                    //  window.location = response.redirect;
                }
            });
        },
        baseZ: 300000000
    });
    $.unblockUI();  
}

function for_discussion( form, status_id )
{
    $.ajax({
        url: base_url + module.get('route') + '/get_notes',
        type: "POST",
        async: false,
        data: form.find(":not('.dontserializeme')").serialize() + '&status_id='+status_id,
        dataType: "json",
        beforeSend: function () {
            $.blockUI({
                message: '<img src="'+ base_url +'assets/img/ajax-modal-loading.gif"><br />Loading discussion, please wait...',
                css: {
                    background: 'none',
                    border: 'none',     
                    'z-index':'99999'               
                },
                baseZ: 20000,
            });
        },
        success: function (response) {
            $.unblockUI();

            if (typeof (response.notes) != 'undefined') {
                $('.modal-container').html(response.notes);
                $('.modal-container').modal();

                /*$('#greetings_dialog').html(response.greetings);
                $('#greetings_dialog').modal('show');   */            
            }
            handle_ajax_message( response.message );
        }
    });
}

function init_notes()
{
    $('#note-form').stop().submit(function(e){
        e.preventDefault();
        add_note();
    });
}

function add_note()
{
    $.blockUI({ message: '<div>Loading notes, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/save_note',
                type:"POST",
                data: $('#discussion-form').serialize() +'&'+$('#note-form').serialize() 
                +'&'+ $('#planning-form').find(":not('.dontserializeme')").serialize()
                + '&validation=1',
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );
                    submitDiscussion();
                    //console.log(response.weight_error);
                    if(!response.weight_error){
                        window.location = response.redirect;
                    }
                }
            });     
        },
        baseZ: 300000000
    });
    $.unblockUI();
}


function view_discussion( form, status_id )
{
    $.ajax({
        url: base_url + module.get('route') + '/view_discussion',
        type: "POST",
        async: false,
        data: form.find(":not('.dontserializeme')").serialize() + '&status_id='+status_id,
        dataType: "json",
        beforeSend: function () {
            $.blockUI({
                message: '<img src="'+ base_url +'assets/img/ajax-modal-loading.gif"><br />Loading discussion, please wait...',
                css: {
                    background: 'none',
                    border: 'none',     
                    'z-index':'99999'               
                },
                baseZ: 20000,
            });
        },
        success: function (response) {
            $.unblockUI();

            if (typeof (response.notes) != 'undefined') {
                $('.modal-container').html(response.notes);
                $('.modal-container').modal();

                /*$('#greetings_dialog').html(response.greetings);
                $('#greetings_dialog').modal('show');   */            
            }
            handle_ajax_message( response.message );
        }
    });
}

$(document).on('keypress', '#discussion_notes', function (e) {  
    if (e.which == 13) {
        e.preventDefault();
        submitDiscussion();
    } else return;
});

$(document).on('click', '#discussion_notes_btn', function (e) {
    e.preventDefault();
    submitDiscussion();
});

var submitDiscussion = function () {
    if (!$("#discussion_notes").val().trim()) {
        $("#discussion_notes").focus();
        return false;
    };

    var data = {
        discussion_notes: $("#discussion_notes").val(),
        message_type: $("#message_type").val(),
        user_id: $("#user_id").val()
    };
    
    $.blockUI({ message: '<div>Loading notes, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/submitDiscussion',
                type: "POST",
                async: false,
                data: $('#discussion-form').serialize() ,
                dataType: "json",
                beforeSend: function () {

                    $("#discussion_notes").attr('disabled', true);
                    $("#icn-greetings-update").removeClass().addClass('fa fa-spinner icon-spin');
                },
                success: function (response) {
                    setTimeout(function () {

                        $("#discussion_notes").val('');
                        $("#discussion_notes").attr('disabled', false);

                        if (typeof (response.new_discussion) != 'undefined') {

                            $(".discussions").prepend(response.new_discussion).fadeIn();
                            // $('.greetings_container li.no-greetings').remove();
                            
                        }

                    }, 1000);

                    $.unblockUI();

                    for (var i in response.message) {
                        if (response.message[i].message != "") {
                            notify(response.message[i].type, response.message[i].message);
                        }
                    }
                }
            });
        },
        baseZ: 300000000
    });
    $.unblockUI();
}

//add score 
function add_form(add_form, mode, sequence){
    var form_value = $("#notification_id").val();
    if($.trim(form_value) != ""){
        $.ajax({
            url: base_url + module.get('route') + '/add_form',
            type:"POST",
            async: false,
            data: 'add_form='+add_form+'&form_value='+form_value+'&start_date='+$('#performance_planning-date_from').val(),
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
                        $('#performance_planning_applicable-reference_id').tagsinput('add', { "value": response.applicable_for[i].value , "label": response.applicable_for[i].label  });
                    }
                }
            }

        }
    }); 
}

//get filters 
function get_filters(record_id, planning_id){
    data = {
        record_id : record_id,
        planning_id : planning_id
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
                $('#performance_planning-filter_id').html(response.filter_by);
                $("#performance_planning-filter_id").multiselect("destroy");
                $('#performance_planning-filter_id').multiselect({
                    numberDisplayed: response.count
                });
/*                if(!(response.selected_filter) == 1){
                    $('input[name="multiselect_performance_planning-filter_id"]').each( function() {
                        $(this).attr('checked',true);
                        $(this).attr('aria-selected',true);
                    });
                }*/
            }
        }
    }); 
}

//get filters 
function get_selection_filters(template_id, filter_by, filter_id, planning_id, employment_status_id){
    data = {
        template_id : template_id,
        filter_by : filter_by,
        filter_id : filter_id,
        planning_id : planning_id,
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
                $('#performance_planning_applicable-user_id').html(response.employees);
                $("#performance_planning_applicable-user_id").multiselect("destroy");
                $('#performance_planning_applicable-user_id').multiselect({
                    numberDisplayed: response.count
                });
/*                if(!(response.selected_filter) == 1){
                    $('input[name="multiselect_performance_planning_applicable-user_id"]').each( function() {
                        $(this).attr('checked',true);
                        $(this).attr('aria-selected',true);
                    });
                }*/
            }

        }
    }); 
}

function save_record( form, action, callback, applicable_status = 0 )
{
    var ctr = 0;
    var check = 0;
    $('tbody.get-section').each(function(){
        var $this = $(this);
        var total = 0;

        if ($this.attr('section') != 4){
            ctr+= 1;
            total = parseFloat($this.find('input#total-weight').val())

            if (total == 100){
                check+= 1;
            }    
        }        
    });

    var error = false;
    if (ctr != check){
        var error = true;
    }

    $.blockUI({ message: saving_message(),
        onBlock: function(){

            var hasCKItem = form.find("textarea.ckeditor");

            if(hasCKItem && (typeof editor != 'undefined')){
                
                for ( instance in CKEDITOR.instances )
                    CKEDITOR.instances[instance].updateElement();
            }

            var data = form.find(":not('.dontserializeme')").serialize() 
            + '&applicable_status='+applicable_status + '&error='+error;

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