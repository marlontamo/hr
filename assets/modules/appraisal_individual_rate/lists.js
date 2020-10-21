

function get_observations( performance_appraisal_year, user_id, fullname )
{
    data ={
        performance_appraisal_year : performance_appraisal_year,
        user_id : user_id,
        fullname : fullname
    }
    $.ajax({
        url: base_url + module.get('route') + '/get_observations',
        type: "POST",
        async: false,
        data: data,
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

                /*$('#greetings_dialog').html(response.greetings);
                $('#greetings_dialog').modal('show');   */            
            }
            handle_ajax_message( response.message );
        }
    });
}

$(document).on('keypress', '#observation_message', function (e) {	
    if (e.which == 13) {
    	e.preventDefault();
        submitObservation();
    } else return;
});

$(document).on('click', '#observation_button', function (e) {
    e.preventDefault();
    submitObservation();
});

var submitObservation = function () {
    if (!$("#observation_message").val()) {
        $("#observation_message").focus();
        return false;
    }

    var data = {
        observation_message: $("#observation_message").val(),
        message_type: $("#message_type").val(),
        user_id: $("#user_id").val()
    };
    
// console.log(data);return false;
    $.ajax({
        url: base_url + module.get('route') + '/submitObservation',
        type: "POST",
        async: false,
        data: data,
        dataType: "json",
        beforeSend: function () {

            $("#observation_message").attr('disabled', true);
            $("#icn-greetings-update").removeClass().addClass('fa fa-spinner icon-spin');
        },
        success: function (response) {
            setTimeout(function () {

                $("#observation_message").val('');
                $("#observation_message").attr('disabled', false);

                if (typeof (response.new_feedback) != 'undefined') {

                    $(".observation_feedback").prepend(response.new_feedback).fadeIn();
                    // $('.greetings_container li.no-greetings').remove();
                    
                    // NOW NOTIFY THEM!!!
                    if (typeof (after_save) == typeof (Function)) after_save(response);
                }

            }, 1000);

            $.unblockUI();

            for (var i in response.message) {
                if (response.message[i].message != "") {
                    notify(response.message[i].type, response.message[i].message);
                }
            }
        }
    });
}