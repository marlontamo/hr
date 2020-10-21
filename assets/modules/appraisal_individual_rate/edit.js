

function view_discussion( form, status_id )
{
    $.ajax({
        url: base_url + module.get('route') + '/view_discussion',
        type: "POST",
        async: false,
        data: form.find(":not('.dontserializeme')").serialize() + '&status_id='+status_id,
        dataType: "json",
        beforeSend: function () {
            $.blockUI({
                message: '<img src="'+ base_url +'assets/img/ajax-modal-loading.gif"><br />Loading discussion, please wait...',
                css: {
                    background: 'none',
                    border: 'none',     
                    'z-index':'99999'               
                },
                baseZ: 20000,
            });
        },
        success: function (response) {
            $.unblockUI();

            if (typeof (response.notes) != 'undefined') {
                $('.modal-container').html(response.notes);
                $('.modal-container').modal();          
            }
            handle_ajax_message( response.message );
        }
    });
}