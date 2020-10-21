$(document).ready(function(){
    if (jQuery().datepicker) {
        $('#time_forms_maternity-actual_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    if (jQuery().datepicker) {
        $('#time_forms_maternity-return_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }

    $('#time_forms_maternity-delivery_id').change(function(){
        set_date_to($(this).val());
    });

        set_date_to($('#time_forms_maternity-delivery_id').val());

});

function set_date_to(delivery_id){
    var date_from = $('#time_forms-date_from').val();
    var record_id = $('#record_id').val();

    $.ajax({
        url: base_url + module.get('route') + '/compute_maternity_days',
        type:"POST",
        async: false,
        data: 'date_from='+date_from+'&delivery_id='+delivery_id+'&record_id='+record_id,
        dataType: "json",
        success: function ( response ) {
            $('#time_forms-date_to').val(response.date_to);
            $('#time_forms-date_from').val(response.date_from);
            $('#date_to').html(response.date_to_display);
            $('#days_leaved').html(response.days_leaved);                
            $('#days').html(response.days);
        }
    });

}

function update_details( form, action, callback )
{
    $.blockUI({ message: saving_message(),
        onBlock: function(){

            var hasCKItem = form.find("textarea.ckeditor");

            if(hasCKItem && (typeof editor != 'undefined')){
                
                for ( instance in CKEDITOR.instances )
                    CKEDITOR.instances[instance].updateElement();
                
                // console.log('form has CK Editor Instance');
                // console.log(hasCKItem);
                // console.log(editor);
                //console.log(CKEDITOR);
            }


            var data = form.find(":not('.dontserializeme')").serialize();
            $.ajax({
                url: base_url + module.get('route') + '/update_details',
                type:"POST",
                data: data,
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );

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