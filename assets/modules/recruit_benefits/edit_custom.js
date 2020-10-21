$(document).ready(function(){
    $(".delete_row").live('click', function(){
        delete_child( $(this), '' )
    });
});
//add benefit 
function add_form(add_form, mode, sequence){

     form_value = $('#'+add_form).val();

    if($.trim(form_value) != ""){
        $.ajax({
            url: base_url + module.get('route') + '/add_form',
            type:"POST",
            async: false,
            data: 'add_form='+add_form+'&form_value='+form_value,
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
                }

            }
        }); 
    }else{
        notify('warning', 'Please input benefit name.');
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
                console.log()
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