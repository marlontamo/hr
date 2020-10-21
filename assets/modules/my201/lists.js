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
    $('#cities-tags').tagsInput({
        width: 'auto',
        autocomplete_url:base_url + module.get('route') + "/get_public_data?column=cities",
        'onAddTag': function () {
            $('#citiesTags .ui-autocomplete-input').hide();
        },
        'onRemoveTag': function () {
            $('#citiesTags .ui-autocomplete-input').show();
        }
    });
    if($('#cities-tags').val() != ""){
        $('#citiesTags .ui-autocomplete-input').hide();
    }

    $('select.select2mecity').select2({
        placeholder: "Select an option",
        allowClear: true
    });
}

function init_country()
{
    $('#country-tags').tagsInput({
        width: 'auto',
        autocomplete_url:base_url + module.get('route') + "/get_public_data?column=countries",
        'onAddTag': function () {
            $('#countryTags .ui-autocomplete-input').hide();
        },
        'onRemoveTag': function () {
            $('#countryTags .ui-autocomplete-input').show();
        }
    });
    if($('#country-tags').val() != ""){
        $('#countryTags .ui-autocomplete-input').hide();
    }

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


function view_movement_details(action_id, type_id, cause){  
    var data = {
        type_id: type_id,
        action_id: action_id,
        cause: cause
    };
    
    $.ajax({
    url: base_url + module.get('route') + '/get_action_movement_details',
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

                if( typeof(response.add_movement) != 'undefined' )
                {   
                    $('.modal-container-action').html(response.add_movement);
                    $('.move_action_modal').append(response.type_of_movement);  
                    $('.modal-container-action').modal('show'); 
                    // FormComponents.init();
                }

            }
    }); 
}