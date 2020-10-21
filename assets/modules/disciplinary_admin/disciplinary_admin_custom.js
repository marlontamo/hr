$(document).ready(function(){

});

function print_disciplinary (record_id)
{
    var data = {
        record_id:record_id
        }
    $.blockUI({ message: '<div>Loading, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/print_disciplinary',
                type:"POST",
                async: false,
                data: data,
                dataType: "json",
                success: function ( response ) {
                    if( response.filename != undefined )
                    {
                        window.open( root_url + response.filename );
                    }
                    $.unblockUI();
                    handle_ajax_message( response.message );
                }
            });
        },
        baseZ: 999999999
    });
}