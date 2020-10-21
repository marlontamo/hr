

function view_transaction_logs( appraisal_id, user_id )
{
    $.blockUI({ message: loading_message(),
        onBlock: function(){
            var data = {
                appraisal_id: appraisal_id,
                user_id:user_id
            };
            $.ajax({
                url: base_url + module.get('route') + '/view_transaction_logs',
                type:"POST",
                data: data,
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );

                    if( typeof(response.trans_logs) != 'undefined' )
                    {
                        $('.modal-container').attr('data-width', '800');
                        $('.modal-container').html(response.trans_logs);
                        $('.modal-container').modal();
                    }
                }
            });
        },
        baseZ: 300000000
    });
    $.unblockUI();
} 

function get_observations( performance_appraisal_year, user_id, fullname )
{
    data ={
        performance_appraisal_year : performance_appraisal_year,
        user_id : user_id,
        fullname : fullname
    }
    $.ajax({
        url: base_url + 'appraisal/individual_rate/get_observations',
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

    $.ajax({
        url: base_url + 'appraisal/individual_rate/submitObservation',
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

                /*$('#greetings_dialog').html(response.greetings);
                $('#greetings_dialog').modal('show');   */            
            }
            handle_ajax_message( response.message );
        }
    });
}

$(document).on('keypress', '#discussion_notes', function (e) {  
    if (e.which == 13) {
        e.preventDefault();
        submitDiscussion();
    } else return;
});

$(document).on('click', '#discussion_notes_btn', function (e) {
    e.preventDefault();
    submitDiscussion();
});

var submitDiscussion = function () {
    if (!$("#discussion_notes").val()) {
        $("#discussion_notes").focus();
        return false;
    }

    $.ajax({
        url: base_url + module.get('route') + '/submitDiscussion',
        type: "POST",
        async: false,
        data: $('#discussion-form').serialize() ,
        dataType: "json",
        beforeSend: function () {

            $("#discussion_notes").attr('disabled', true);
            $("#icn-greetings-update").removeClass().addClass('fa fa-spinner icon-spin');
        },
        success: function (response) {
            setTimeout(function () {

                $("#discussion_notes").val('');
                $("#discussion_notes").attr('disabled', false);

                if (typeof (response.new_discussion) != 'undefined') {

                    $(".discussions").prepend(response.new_discussion).fadeIn();
                }

            }, 1000);

            $.unblockUI();

            for (var i in response.message) {
                if (response.message[i].message != "") {
                    notify(response.message[i].type, response.message[i].message);
                }
            }

            if(response.redirect)
                window.location = response.redirect;
        }
    });
}