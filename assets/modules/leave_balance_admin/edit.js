$(document).ready(function(){
    if (jQuery().datepicker) {
        $('#time_form_balance-period_extension').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    if (jQuery().datepicker) {
        $('#time_form_balance-period_to').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    if (jQuery().datepicker) {
        $('#time_form_balance-period_from').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    $('#time_form_balance-form_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#time_form_balance-year').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#time_form_balance-user_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
});

function add_leave_accrual(record_id = false){ 
    if (!record_id){
        var record_id = $('#record_id').val();
    }
    var data = {
        //type_id: $('#type_id').val(),
        //type_name: $('#type_id option:selected').text(),
        record_id: record_id
    }    

    $.ajax({
        url: base_url + module.get('route') + '/get_leave_accrual',
        type:"POST",
        async: false,
        data: data,
        dataType: "json",
        beforeSend: function(){
            $('body').modalmanager('loading');
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

            if( typeof(response.edit_accrual) != 'undefined' )
            {   
                $('.modal-container-action').html(response.edit_accrual);
                $('.modal-container-action').modal('show'); 
            }

        }
    });    
}

function edit_credits(record_id,date){
    var data = {
        existing: 1,
        date: date,
        record_id: record_id
    }    

    $.ajax({
        url: base_url + module.get('route') + '/get_leave_accrual',
        type:"POST",
        async: false,
        data: data,
        dataType: "json",
        beforeSend: function(){
            $('body').modalmanager('loading');
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

            if( typeof(response.edit_accrual) != 'undefined' )
            {   
                $('.modal-container-action').html(response.edit_accrual);
                $('.modal-container-action').modal('show'); 
            }

        }
    });     
}

function delete_credit(record_id,date,elem)
{
    var data = {
        existing: 1,
        date: date,
        record_id: record_id
    }   

    bootbox.confirm(lang.confirm.delete_single, function(confirm) {
        if( confirm )
        {
            $.ajax({
                url: base_url + module.get('route') + '/delete_credit',
                type:"POST",
                data: data,
                dataType: "json",
                async: false,
                beforeSend: function(){
                    $('body').modalmanager('loading');
                },
                success: function ( response ) {     
                    $('#time_form_balance-current').val(response.credit_current);

                    $(elem).closest('tr').remove();

                    $('body').modalmanager('removeLoading');
                }
            });
        } 
    });
}

function save_credits( form, action, callback )
{
    $.blockUI({ message: saving_message(),
        onBlock: function(){

            var data = form.find(":not('.dontserializeme')").serialize();
            data = data + '&record_id='+ $('#record_id').val();

            $.ajax({
                url: base_url + module.get('route') + '/save_credits',
                type:"POST",
                data: data,
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );
                    $('.modal-container-action').modal('hide');

                    $('#record-list').html(response.list_accrual);

                    $('#time_form_balance-current').val(response.credit_current);
                }
            });
        },
        baseZ: 300000000
    });
    $.unblockUI();
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

                    if( response.saved )
                    {
                        $('#goadd').show();  

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

                    /*if(response.notify != "undefined")
                    {
                        for(var i in response.group_notif)
                            socket.emit('get_push_data', {channel: 'get_user_'+response.notify[i]+'_notification', args: { broadcaster: user_id, notify: true }});
                    }*/

                    if(response.group_notif != "undefined")
                    {
                        for(var i in response.group_notif)
                            socket.emit('get_push_data', {channel: 'get_group_'+response.group_notif[i]+'_notification', args: { broadcaster: user_id, notify: true }});
                    }
                }
            });
        },
        baseZ: 300000000
    });
    $.unblockUI();
}