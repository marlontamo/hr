$(document).ready(function(e) { 
	$('.list-filter').unbind('click').click(function(){
		$('.list-filter').removeClass('label-success');
		$('.list-filter').addClass('label-default');
		$(this).removeClass('label-default');
		$(this).addClass('label-success');
		
		create_list();
	});	
});

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

function create_list()
{
	var appraisal_id = $('#appraisal_id').val();
	var search = $('input[name="list-search"]').val();
	var filter_by = $('.list-filter.label-success').attr('filter_by');
	var filter_value = $('.list-filter.label-success').attr('filter_value');

	$('#record-list').empty().stop().die().infiniteScroll({
		dataPath: base_url + module.get('route') + '/get_list/'+appraisal_id,
		itemSelector: 'tr.record',
		onDataLoading: function(){ 
			$("#loader").show();
			$("#no_record").hide();
		},
		onDataLoaded: function(page, records){ 
			$("#loader").hide();
			if( page == 0 && records == 0)
			{
				$("#no_record").show();
				$("#record-list").hide();
			}else{
				$("#no_record").hide();
				$("#record-list").show();
			}
		},
		onDataError: function(){ 
			return;
		},
		search: search,
		filter_by: filter_by,
		filter_value: filter_value
	});
}

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
				$('#greetings_dialog').modal('show');	*/            
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