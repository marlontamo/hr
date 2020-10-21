$(document).ready(function(){
    init_form();
});

function init_form()
{
    if (jQuery().datepicker) {
        $('#time_forms-focus_date').parent('.date-picker').datepicker({
            autoclose: true 
        }).on('changeDate', function(ev) {
            var focus_date = Date.parse($('#time_forms-focus_date').val());  

            if ($('#time_forms-date_to').length > 0){
                var date_from = Date.parse($('#time_forms-date_from').val());
                var date_to = Date.parse($('#time_forms-date_to').val());
            }
            else{
                var data = $('#time_forms-datetime_from').val();
                var current_time = data.split(' - ');
                var focus_date_original = $('#time_forms-focus_date').val() + ' - ' + current_time[1];

                $('#time_forms-datetime_from').val(focus_date_original);
                $('#time_forms-datetime_to').val(focus_date_original);

                var date_from = Date.parse($('#time_forms-datetime_from').val());
                var date_to = Date.parse($('#time_forms-datetime_to').val());
            }

            var no_days_before = dateDiff(focus_date,date_from,'days');
            var no_days_after = dateDiff(focus_date,date_to,'days');

            if ((focus_date < date_from) && no_days_before > 1){
                $('#time_forms-focus_date').val('')
                notify('error', 'Focus date should less than or equal to 1 day');
            }

            if ((focus_date > date_to) && no_days_after > 1){
                $('#time_forms-focus_date').val('')
                notify('error', 'Focus date should less than or equal to 1 day');
            }    

            if ($('form_code').val() == 'DTRP'){
                if ((focus_date < date_to) && no_days_after > 1){
                    $('#time_forms-focus_date').val('')
                    notify('error', 'Focus date should less than or equal to 1 day');
                }   
            }   

        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }

    if (jQuery().datepicker) {
    $('#time_forms-date_from').parent('.date-picker').datepicker({
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    
    if (jQuery().datepicker) {
        $('#time_forms-date_to').parent('.date-picker').datepicker({
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }

    $('#time_forms_maternity-delivery_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });

    $('#time_forms_paternity-delivery_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });

    if (jQuery().datepicker) {
        $('#time_forms_maternity-expected_date').parent('.date-picker').datepicker({
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    if (jQuery().datepicker) {
        $('#time_forms_maternity-actual_date').parent('.date-picker').datepicker({
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    if (jQuery().datepicker) {
        $('#time_forms_maternity-return_date').parent('.date-picker').datepicker({
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }

    $("#time_forms-datetime_from").datetimepicker({
        format: "MM dd, yyyy - HH:ii p",
        autoclose: true,
        todayBtn: false,
        pickerPosition: "bottom-left",
        minuteStep: 1
    });

    $("#time_forms-datetime_to").datetimepicker({
        format: "MM dd, yyyy - HH:ii p",
        autoclose: true,
        todayBtn: false,
        pickerPosition: "bottom-left",
        minuteStep: 1
    });

    $("#ut_time_in_out").datetimepicker({
        format: "MM dd, yyyy - HH:ii p",
        autoclose: true,
        todayBtn: false,
        pickerPosition: "bottom-left",
        minuteStep: 1
    });
    
    if (jQuery().timepicker) {
        $('.timepicker-default').timepicker({
            autoclose: true
        });
    }

        //disabled datepicker
        if($('#form_status_id').val()>2){
            $('.date-picker').removeClass('date-picker');
        }

        $('#change_options').hide();

        if( $('#goto_vl_co').length > 0 ){
            get_selected_dates($('#record_id').val(), $('#form_status_id').val(), $('#time_forms-date_from').val(), $('#time_forms-date_to').val());
       }


    $('.maternity_date_from').change(function(){
        set_date_to($('#time_forms_maternity-delivery_id').val());

    });
    $('.paternity_date_from').change(function(){
        set_paternity_date_to($('#time_forms_maternity-delivery_id').val());

    });

    $('#time_forms_maternity-delivery_id').change(function(){
        set_date_to($(this).val());

    });

    $('#time_forms_paternity-delivery_id').change(function(){
        set_paternity_date_to($(this).val());

    });

    $('#time_forms-datetime_from,#time_forms-datetime_to,#time_forms-date_to').change(function(e){
        var focus_date = Date.parse($('#time_forms-focus_date').val());
        if ($('#time_forms-date_to').length > 0){
            var date_from = Date.parse($('#time_forms-date_to').val());
            var date_to = Date.parse($('#time_forms-date_to').val());
        }
        else{
            var date_from = Date.parse($('#time_forms-datetime_from').val());
            var date_to = Date.parse($('#time_forms-datetime_to').val());
        }

        var no_days_before = dateDiff(focus_date,date_from,'days');
        var no_days_after = dateDiff(focus_date,date_to,'days');

        if ((focus_date < date_from) && no_days_before > 1){
            $('#time_forms-focus_date').val('')
            notify('error', 'Focus date should less than or equal to 1 day');
        }

        if ((focus_date > date_to) && no_days_after > 1){
            $('#time_forms-focus_date').val('')
            notify('error', 'Focus date should less than or equal to 1 day');
        }  
    });

    $('#time_forms_upload-upload_id-fileupload').fileupload({
        url: base_url + module.get('route') + '/multiple_upload',
        autoUpload: true,
    }).bind('fileuploadadd', function (e, data) {
        $.blockUI({ message: '<div>'+lang.form_app.attach_files+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />' });
    }).bind('fileuploaddone', function (e, data) {
        $.unblockUI();
        var file = data.result.file;
        if(file.error != undefined && file.error != "")
        {
            notify('error', file.error);
        }
        else{
            var cur_val = $('#time_forms_upload-upload_id').val();
            if( cur_val == '' )
                $('#time_forms_upload-upload_id').val(file.upload_id);
            else
                $('#time_forms_upload-upload_id').val(cur_val + ',' +file.upload_id);
            $('#time_forms_upload-upload_id-container ul').append(file.icon);
        }
    }).bind('fileuploadfail', function (e, data) {
        $.unblockUI();
        notify('error', data.errorThrown);
    });

    $('#time_forms_upload-upload_id-container .fileupload-delete').on('click', function(event){
        event.preventBubble=true;
        var upload_id = $(this).attr('upload_id');
        $('li.fileupload-delete-'+upload_id).remove();
        var cur_val = $('#time_forms_upload-upload_id').val();
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
            $('#time_forms_upload-upload_id').val( '' );
        else
            $('#time_forms_upload-upload_id').val( new_val.join(',') );
    });

    $('#goto_vl_co').click(function () {
        $('#main_form').hide();
        $('.form-actions').hide();
        $('#change_options').show();
    });

    $('#goto_addl_co').click(function () {
        $('#main_form').hide();
        // $('.form-actions').hide();
        $('#change_options').show();
    });

    $('#time_forms-date_from').change(function () {
        if($('#time_forms-date_to').val() != "" && $('#goto_vl_co').length > 0 ){
            get_selected_dates($('#record_id').val(), $('#form_status_id').val(), $('#time_forms-date_from').val(), $('#time_forms-date_to').val());
            $('#change_options_note').show();
        }
    })

    $('#time_forms-date_to').change(function () {
        if($('#time_forms-date_from').val() != "" && $('#goto_vl_co').length > 0 ){
            get_selected_dates($('#record_id').val(), $('#form_status_id').val(), $('#time_forms-date_from').val(), $('#time_forms-date_to').val());
            $('#change_options_note').show();
        }
    })
}



    

    function back_to_mainform(cancel){
        if(cancel==1){
            get_selected_dates($('#record_id').val(), $('#form_status_id').val(), $('#time_forms-date_from').val(), $('#time_forms-date_to').val());    
        }
        $('#change_options').hide();
        $('#main_form').show();
        $('.form-actions').show();
    }

    function get_selected_dates(forms_id, form_status_id, date_from, date_to, view){
        if( mobileapp )
        {
            var params = {
                'forms_id': forms_id,
                'form_status_id': form_status_id,
                'date_from': date_from,
                'date_to': date_to,
                'view': $('#view').val(),
                'form_code': $('#form_code').val()   
            };
            ajax( base_url + module.get('route') + '/get_selected_dates', params, function( response ){
                $('#change_options').html(response.selected_dates);
                $('#days').html(response.days);
            });
        }
        else{
            $.ajax({
                url: base_url + module.get('route') + '/get_selected_dates',
                type:"POST",
                async: false,
                data: 'forms_id='+forms_id+'&form_status_id='+form_status_id+'&date_from='+date_from+'&date_to='+date_to+'&view='+$('#view').val()+'&form_code='+$('#form_code').val(),
                dataType: "json",
                success: function ( response ) {
                    $('#change_options').html(response.selected_dates);
                    $('#days').html(response.days);
                }
            });
        }
    }

    function get_shift_details(date_from, date_to, form_type, type, utype){ 
        if( mobileapp )
        {
            var params = {
                'date_from': date_from,
                'date_to': date_to,
                'type': type,
                'form_type': form_type,
                'utype': utype
            };
            ajax( base_url + module.get('route') + '/get_shift_details', params, function( response ){
                if(form_type == 11){ //DTRP
                    $('#time_forms-datetime_from').val( response.shift_details.date_from );
                    $('#time_forms-datetime_to').val( response.shift_details.date_to );
                }

                $('#ut_time_in_out').val( response.shift_details.ut_time_in_out ); //undertime form only
                $('#shift_time_end').html( response.shift_details.shift_time_end );
                $('#shift_time_start').html( response.shift_details.shift_time_start );
                $('#logs_time_out').html( response.shift_details.logs_time_out );
                $('#logs_time_in').html( response.shift_details.logs_time_in );
            });
        }
        else{
            $.ajax({
                url: base_url + module.get('route') + '/get_shift_details',
                type:"POST",
                async: false,
                data: 'date_from='+date_from+'&date_to='+date_to+'&type='+type+'&form_type='+form_type+'&utype='+utype,
                dataType: "json",
                success: function ( response ) {
                    // console.log(response);
                    if(form_type == 11){ //DTRP
                        $('#time_forms-datetime_from').val( response.shift_details.date_from );
                        $('#time_forms-datetime_to').val( response.shift_details.date_to );
                    }

                    $('#ut_time_in_out').val( response.shift_details.ut_time_in_out ); //undertime form only
                    $('#shift_time_end').html( response.shift_details.shift_time_end );
                    $('#shift_time_start').html( response.shift_details.shift_time_start );
                    $('#logs_time_out').html( response.shift_details.logs_time_out );
                    $('#logs_time_in').html( response.shift_details.logs_time_in );
                }
            });
}
    }

    function save_form( forms, status )
    {
        if ($('#time_forms-focus_date').length > 0){
            if ($('#form_code').val() == 'OT'){
                if ($('#time_forms-focus_date').val() == ''){
                    notify('error', 'Focus date is required');
                    return false;
                }
            }
            else if ($('#form_code').val() == 'DTRP' && $('#dtrp_type').val() == 2){
                if ($('#time_forms-focus_date').val() == ''){
                    notify('error', 'Focus date is required');
                    return false;
                }
            }            
        }

        $.blockUI({ message: saving_message(),
            onBlock: function(){
                forms.submit( function(e){ e.preventDefault(); } );
                var save_url = forms.attr('action');
                var data = forms.find(":not('.dontserializeme')").serialize()
                if( mobileapp )
                {
                    $('form#edit-forms-form').block({ message: '<div> '+lang.form_app.saving+' '+$('#forms_title').val()+', '+lang.form_app.please_wait+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />' });
                    ajax( save_url, data+'&form_status_id='+status, function( response ){
                        $('form#edit-forms-form').unblock();
                            
                        if( typeof response.forms_id != 'undefiend' )
                        {
                            $('form#edit-forms-form input[name="forms_id"]').val( response.forms_id );
                        }

                        handle_ajax_message( response.message );

                        if( typeof (response.notified) != 'undefined' )
                        {
                            for(var i in response.notified)
                            {
                                socket.emit('get_push_data', {channel: 'get_user_'+response.notified[i]+'_notification', args: { broadcaster: user_id, notify: true }});
                            }
                        }

                        if(response.saved )
                        {
                            $('#btn-close-modal').trigger('click');    
                            init_tab_app( true );    
                        }    
                    });
                }
                else{  
                    $.ajax({
                        url: save_url,
                        type:"POST",
                        data: data + "&form_status_id=" + status,
                        dataType: "json",
                        async: false,
                        beforeSend: function(){
                            
                        },
                        success: function ( response ) {
                            $('form#edit-forms-form').unblock();
                            
                            if( typeof response.forms_id != 'undefiend' )
                            {
                                $('form#edit-forms-form input[name="forms_id"]').val( response.forms_id );
                            }

                            handle_ajax_message( response.message );

                            if( typeof (response.notified) != 'undefined' )
                            {
                                for(var i in response.notified)
                                {
                                    socket.emit('get_push_data', {channel: 'get_user_'+response.notified[i]+'_notification', args: { broadcaster: user_id, notify: true }});
                                }
                            }

                            if(response.saved )
                            {
                                setTimeout(function(){window.location.replace(base_url + module.get('route'))},1000);    
                            }
                        }
                    });
                }
            },
            baseZ: 300000000
        });
        setTimeout(function(){$.unblockUI()},2000);
        // $.unblockUI();
    }

    function cancel_record( record_id, callback )
    {
        bootbox.confirm(lang.form_app.you_sure, function(confirm) {
            if( confirm )
            {
                _cancel_record( record_id, callback );
            } 
        });
    }

    function _cancel_record( records, callback )
    {
        if( mobileapp )
        {
            var params = {
                records: records
            };
            ajax( base_url + module.get('route') + '/cancel_record', params, function(response){
                $('body').modalmanager('removeLoading');
                handle_ajax_message( response.message );

                if (typeof(callback) == typeof(Function))
                    callback();
                else
                    $('#form-list').infiniteScroll('search');
            });
        }
        else{
            $.ajax({
                url: base_url + module.get('route') + '/cancel_record',
                type:"POST",
                async: false,
                data: 'records='+records,
                dataType: "json",
                beforeSend: function(){
                    $('body').modalmanager('loading');
                },
                success: function ( response ) {
                    
                }
            });    
        }
        
    }


    function set_date_to(delivery_id){
        var date_from = $('#time_forms-date_from').val();
        if( mobileapp )
        {
            var params = {
                'date_from': date_from,
                'delivery_id': delivery_id
            };
            ajax( base_url + module.get('route') + '/compute_maternity_days', params, function( response ){
                $('#time_forms-date_to').val(response.date_to);
                $('#time_forms-date_from').val(response.date_from);
                $('#days').html(response.days);
                get_selected_dates($('#record_id').val(), $('#form_status_id').val(), $('#time_forms-date_from').val(), $('#time_forms-date_to').val());
            });
        }
        else{
            $.ajax({
                url: base_url + module.get('route') + '/compute_maternity_days',
                type:"POST",
                async: false,
                data: 'date_from='+date_from+'&delivery_id='+delivery_id,
                dataType: "json",
                success: function ( response ) {
                    
                }
            });
        }
    }

    function set_paternity_date_to(delivery_id){
        var date_from = $('#time_forms-date_from').val();
        if( mobileapp )
        {
            var params = {
                'date_from': date_from,
                'delivery_id': delivery_id
            };
            ajax( base_url + module.get('route') + '/compute_paternity_days', params, function( response ){
                $('#time_forms-date_to').val(response.date_to);
                $('#time_forms-date_from').val(response.date_from);
                $('#days').html(response.days);
                get_selected_dates($('#record_id').val(), $('#form_status_id').val(), $('#time_forms-date_from').val(), $('#time_forms-date_to').val());
            });
        }
        else{
            $.ajax({
                url: base_url + module.get('route') + '/compute_paternity_days',
                type:"POST",
                async: false,
                data: 'date_from='+date_from+'&delivery_id='+delivery_id,
                dataType: "json",
                success: function ( response ) {
                    // disable since it was overriden the original application 06-01-2017 
                    //$('#time_forms-date_to').val(response.date_to);
                    //$('#time_forms-date_from').val(response.date_from);
                    $('#days').html(response.days);
                    get_selected_dates($('#record_id').val(), $('#form_status_id').val(), $('#time_forms-date_from').val(), $('#time_forms-date_to').val());
                }
            });
        }
    }
    
//close filter dropdown once orientation change
window.addEventListener("orientationchange", function() {
    $( ".btn-group" ).trigger( "click" );
}, false);   