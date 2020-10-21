$(document).ready(function(){
    $('#generate').live('click',function(e){
        e.preventDefault();
        var data = {
            record_id: $('#record_id').val(),
            company_id: $('#users_coordinator-company_id').val(),
            branch_id: $('#users_coordinator-branch_id').val()
        };        
        $.ajax({
            url: base_url + module.get('route') + '/get_add_employee',
            type:"POST",
            data: data,
            dataType: "json",
            async: false,
            success: function ( response ) {
                handle_ajax_message( response.message );
                $('#record-list-coordinator').html(response.list_user);
            }
        });
    });
});