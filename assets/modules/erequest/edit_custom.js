function save_record( form, action, callback )
{
	$.blockUI({ message: saving_message(),
		onBlock: function(){

			var hasCKItem = form.find("textarea.ckeditor");

			if(hasCKItem && (typeof editor != 'undefined')){
				
				for ( instance in CKEDITOR.instances )
        			CKEDITOR.instances[instance].updateElement();
			}

			var data = form.find(":not('.dontserializeme')").serialize();
			data = data +'&request_status_id='+ action;
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
							case 6:
								document.location = base_url + module.get('route');
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
    if (!$("#discussion_notes").val().trim()) {
        $("#discussion_notes").focus();
        return false;
    };

    var data = {
        discussion_notes: $("#discussion_notes").val(),
        message_type: $("#message_type").val(),
        user_id: $("#user_id").val()
    };
    
	$.blockUI({ message: '<div>Loading notes, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
		onBlock: function(){
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
		                    // $('.greetings_container li.no-greetings').remove();
		                    
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
		},
		baseZ: 300000000
	});
	$.unblockUI();
}