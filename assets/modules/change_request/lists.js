$(document).ready(function(){
    $('.make-switch').not(".has-switch")['bootstrapSwitch']();

    $('input[name="temp-personal_id[]"]').change(function(){
        var personal_id = $(this).val();
        if($(this).is(":checked"))
            $('input[name="personal_id['+personal_id+']"]').val(3);
        else
            $('input[name="personal_id['+personal_id+']"]').val(4); 
    });

    $('input[name="temp-personal_id[]"]').trigger('change');
});

function save_request_detail()
{
    bootbox.confirm(lang.change_request.confirm_save_request, function(confirm) {
        if( confirm )
        {
            $.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
                onBlock: function(){
                    $.ajax({
                        url: base_url + module.get('route') + '/save_request_detail',
                        type:"POST",
                        data: $('form[name="change-request-form"]').find(":not('.dontserializeme')").serialize(),
                        async: false,
                        dataType: "json",
                        success: function ( response ) {
                            handle_ajax_message( response.message ); 
                            document.location = base_url + module.get('route');
                        }
                    });
                }
            });
            $.unblockUI();
        }
    });  
}

function change_status( partner_id, created_on, status)
{
	switch( status )
	{
		case 3:
			var q = "Do you really want to approve selected change request?";
			break;
		case 4:
			var q = "Do you really want to decline selected change request?";
			break;	

	}

	bootbox.confirm(q, function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/change_status',
						type:"POST",
						data: {partner_id:partner_id, created_on:created_on, status:status},
						async: false,
						dataType: "json",
						success: function ( response ) {
                            handle_ajax_message( response.message ); 
							document.location = base_url + module.get('route');
                            // create_list();
						}
					});
				}
			});
			$.unblockUI();
		}
	});
}

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
    if( $('input[name="user_id"]').val() == "" )
    {
        notify('warning', 'Please select an employee');
        return;
    }
   /* if( $('#key_class_id').val() == "" )
    {alert("sfda");
        notify('warning','Please add atleast one request item');
        return;
    } */   

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
                    var data = $('#draft-keys-form').serialize()+'&user_id='+$('input[name="user_id"]').val();
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
                            create_list();
                        }
                    });
                },
                baseZ: 300000000
            });
            $.unblockUI();
        }
    });
}

function see_detail( partner_id, created_on, status)
{    
    $.blockUI({ message: loading_message(), 
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/detail',
                type:"POST",
                data: {partner_id:partner_id, created_on:created_on, status:status},
                async: false,
                dataType: "json",
                success: function ( response ) {
                    
                }
            });
        }
    });
    $.unblockUI();
}