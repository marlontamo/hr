$(document).ready(function(){
    $(".delete_row").live('click', function(){
        delete_record( $(this), '' )
    });
});

function show_cr_form()
{
	$.blockUI({ message: loading_message(), 
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/cr_form',
                type:"POST",
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );

                    if( typeof(response.cr_form) != 'undefined' )
                    {
                        $('.modal-container').attr('data-width', '600');
                        $('.modal-container').html(response.cr_form);
                        $('.modal-container').modal();
                    }  
                }
            });
        }
    });
    $.unblockUI();
}

function add_class()
{
    var key_class_id = $('select[name="key_class_id"]').val();
    $('#draft-keys').block({ message: '<div>Adding profile class keys, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/add_class_draft',
                type:"POST",
                data: {key_class_id:key_class_id},
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );
                    $('select[name="key_class_id"] option:selected').remove();
                    if( typeof(response.class_draft) != 'undefined' )
                    {
                        $('#draft-keys').append( response.class_draft );
                    }  
                }
            });
        }
    });
    $('#draft-keys').unblock();
}

function remove_class( key_class_id )
{
    bootbox.confirm("Are you sure you want to remove all keys from selected class?", function(confirm) {
        if( confirm )
        {
            $('#class-'+key_class_id).remove();
        }
    });
}

function init_city()
{
    $('select.select2mecity').select2({
        placeholder: "Select an option",
        allowClear: true
    });
}

function init_country()
{
    $('select.select2mecountry').select2({
        placeholder: "Select an option",
        allowClear: true
    });
}

function save_request(action)
{
    switch(action)
    {
        case 1:
            var q = "Are you sure you want to save as draft only?";
            break;
        case 2:
            var q = "Are you sure you want to send your request?";
            break;
    }

    bootbox.confirm( q, function(confirm) {
        if( confirm )
        {
            $.blockUI({ message: loading_message(), 
                onBlock: function(){
                    var data = $('#draft-keys-form').serialize();
                    data = data + '&status='+action;
                    $.ajax({
                        url: base_url + module.get('route') + '/save_request',
                        type:"POST",
                        data: data,
                        dataType: "json",
                        async: false,
                        success: function ( response ) {
                            handle_ajax_message( response.message ); 
                            $('.modal-container').modal('hide');
                        }
                    });
                },
                baseZ: 300000000
            });
            $.unblockUI();
        }
    });
}

function save_record( form, action, callback )
{
    $.blockUI({ message: saving_message(),
        onBlock: function(){
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

//add phone 
function add_form(add_form, mode, sequence){
    var form_category = ( $('#'+mode+'_category').length ) ? $('#'+mode+'_category').val() : '';
    
    if(add_form == 'language_spoken'){        
     form_value = $('#language').val();
     form = 'language';
     forms = 'languages';
    }else if(add_form == 'social_networks'){    
     form_value = $('#social').val();
     form = 'social';
     forms = 'socials';
    }

    if($.trim(form_value) != ""){
        $.ajax({
            url: base_url + module.get('route') + '/add_form',
            type:"POST",
            async: false,
            data: 'add_form='+add_form+'&category='+form_category+'&form_value='+form_value,
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
                    $('#'+form).val('');
                    $('#add_'+mode).remove();
                    $('#'+forms).append(response.add_form);
                    // handleSelect2();
                    FormComponents.init();
                }

            }
        }); 
    }else{
        notify('warning', 'Please input language.');
    }
}

function delete_record( record, callback )
{
    bootbox.confirm("Are you sure you want to delete this item?", function(confirm) {
        if( confirm )
        {
            _delete_record( record, callback );
        } 
    });
}

function _delete_record( record, callback )
{
    notify('success', "Item successfully deleted");
    setTimeout(function(){
        $('body').modalmanager('removeLoading');
        record.closest('tr').remove();
    }, 500);

}

    function reset_form(column, table, record_id){
        var data = {
            column : column,
            table : table,
            record_id : record_id
        };

        $.ajax({
            url: base_url + module.get('route') + '/reset_form',
            type:"POST",
            data: data,
            dataType: "json",
            async: false,
            success: function ( response ) {
                $('#'+table+'-'+column).val(response.public_data)
                if(column != 'summary'){
                    $('.'+column).html(response.reset_public);
                    if(column=='interest'){
                        $('#'+table+'-'+column).tagsInput({
                            width: 'auto',
                            autocomplete_url:base_url + module.get('route') + '/get_public_data?column=interest',
                            'onAddTag': function () {
                            },
                        });
                    }
                }
            }
        });
    }