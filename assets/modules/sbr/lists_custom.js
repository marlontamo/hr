$(document).ready(function () {     

    $('#cancel').die().live('click', function () {
        Boxy.get($(this)).hide();
    });

    $('#statutory-type').die().live('change', function () {
        $.ajax({
            url: base_url + module.get('route') + '/get_dropdown_options',
            type: 'post',
            data: $('#form-period-options').serialize(),
            dataType: 'json',
            beforeSend: function(){
                // $('.fa-spin').addClass('fa-spinner');
            },              
            success: function (response) {
                handle_ajax_message( response.message );
                $('#values').html( response.options );
                $('#values').select2();
            }
        });
    });
    window.onload = function(){
        $('.multi-select').trigger('multiselectclose');

    };
});

function quick_edit( record_id )
{
    $.blockUI({ message: loading_message(), 
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/quick_edit',
                type:"POST",
                async: false,
                data: 'record_id='+record_id,
                dataType: "json",
                beforeSend: function(){
                },
                success: function ( response ) {
                    handle_ajax_message( response.message );

                    if( typeof(response.quick_edit_form) != 'undefined' )
                    {
                        $('.modal-container').attr('data-width', '800');
                        $('.modal-container').html(response.quick_edit_form);
                        $('.modal-container').modal();                     

                    }
                }
            });
        }
    });
    $.unblockUI();  
}

function process_form( record_id )
{
    $.ajax({
        url: base_url + module.get('route') + '/process_form',
        type:"POST",
        async: false,
        data: 'record_id='+record_id,
        dataType: "json",
        beforeSend: function(){
            $('body').modalmanager('loading');
        },
        success: function ( response ) {
            // $("#tran_date").parent().datepicker('setStartDate',  $(this).val())
            $('.modal-container').attr('data-width', '780');
            $('.modal-container').html(response.process_form);
            $('.modal-container').modal();
        }
    });
}

function process_sbr( record_id )
{
    $.ajax({
        url: base_url + module.get('route') + '/process',
        type:"POST",
        data: $('#form-period-options').serialize() + '&record_id=' + record_id,
        dataType: "json",
        async: false,
        beforeSend: function(){
            $('.fa-spin').addClass('fa-spinner');
        },
        success: function ( response ) {  
            $('.fa-spin').removeClass('fa-spinner');
            $('.modal-container').modal('hide');
            handle_ajax_message( response.message );  
        }
    });
    $.unblockUI(); 
}