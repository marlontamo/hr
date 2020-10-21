$(document).ready(function(){
	$('#recruitment_manpower_plan-department_id').change(function(){
		update_depthead( $(this).val() );
		validate_department();
	});

	$('#recruitment_manpower_plan-company_id').change(function(){
		validate_department();
	});

	$('#recruitment_manpower_plan-year').change(function(){
		validate_department();
	});

	if( $('#record_id').val() != "" )
	{
		get_incumbent();
		get_to_hire();
		after_save();
	}

    var count_newjobs = $('.count_newjobs').length;
    if(!(count_newjobs > 1)){
        $("#no_recordjobs").show();
    }
});
function save_record( form, action, callback, manpower_plan_status_id )
{
	$.blockUI({ message: saving_message(),
		onBlock: function(){

			var hasCKItem = form.find("textarea.ckeditor");

			if(hasCKItem && (typeof editor != 'undefined')){
				
				for ( instance in CKEDITOR.instances )
        			CKEDITOR.instances[instance].updateElement();
			}

			if (manpower_plan_status_id && manpower_plan_status_id != '' && $('#recruitment_manpower_plan-manpower_plan_status_id').length == 0){
				$('#recruitment_manpower_plan-year').after('<input class="form-control" name="recruitment_manpower_plan[manpower_plan_status_id]" id="recruitment_manpower_plan-manpower_plan_status_id" value="'+manpower_plan_status_id+'" type="hidden">');
			}
			else{
				$('#recruitment_manpower_plan-manpower_plan_status_id').val(manpower_plan_status_id);
			}

			var data = form.find(":not('.dontserializeme')").serialize();
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

						
						get_incumbent();
						get_to_hire();
						after_save();

						switch( action )
						{
							case 'new':
								document.location = base_url + module.get('route') + '/add';
								break;
							case 'back':
								document.location = base_url + module.get('route');
								break;								
							default:
								if (manpower_plan_status_id && manpower_plan_status_id != 2 && $('.btn-send').length == 0){
									$('.btn-savenew').after('<button type="button" class="btn green btn-sm btn-send" onclick="save_record( $(this).closest(&apos;form&apos;), \'back\', \'\', 2)">Send for Approval</button>');
								}
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

function update_depthead( department_id )
{
	if($('#recruitment_manpower_plan-department_id').val() != "" )
	{
		$('#recruitment_manpower_plan-departmenthead').block({ message: '<div>Updating, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
			onBlock: function(){
				$.ajax({
					url: base_url + module.get('route') + '/get_depthead',
					type:"POST",
					data: {department_id:department_id},
					dataType: "json",
					async: false,
					success: function ( response ) {
						handle_ajax_message( response.message );
						$('#recruitment_manpower_plan-departmenthead').val(response.depthead);
					}
				});
			}
		});
		$('#recruitment_manpower_plan-departmenthead').unblock();
	}
	else{
		$('#recruitment_manpower_plan-departmenthead').val('');
	}
}

function validate_department()
{
	var data = {
		company_id: $('#recruitment_manpower_plan-company_id').val(),
		department_id: $('#recruitment_manpower_plan-department_id').val(),
		year: $('#recruitment_manpower_plan-year').val()
	};
	if( data.company_id != "" && data.department_id != "" && data.year != "" )
	{
		$.blockUI({ message: '<div>Validating, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
			onBlock: function(){
				$.ajax({
					url: base_url + module.get('route') + '/validate_department',
					type:"POST",
					data: data,
					dataType: "json",
					async: false,
					success: function ( response ) {
						handle_ajax_message( response.message );

						if( response.check && $('#record_id').val() != "")
						{
							get_incumbent();
							get_to_hire();
						}
					}
				});
			}
		});	
		$.unblockUI();
	}
}

function get_incumbent()
{
	var data = {
		plan_id: $('#record_id').val(),
		company_id: $('#recruitment_manpower_plan-company_id').val(),
		department_id: $('#recruitment_manpower_plan-department_id').val(),
		year: $('#recruitment_manpower_plan-year').val(),
		view_type: $('#view_type').val(),
	};
	
	if( data.company_id != "" && data.department_id != "" && data.year != "" )
	{
		$('tbody#incumbents').block({ message: loading_message(),
			onBlock: function(){
				$.ajax({
					url: base_url + module.get('route') + '/get_incumbent',
					type:"POST",
					data: data,
					dataType: "json",
					async: false,
					success: function ( response ) {
						handle_ajax_message( response.message );

						if( typeof response.incumbent != "undefined" )
						{
							$('tbody#incumbents').html('');
							for( var i in response.incumbent )
							{
								$('tbody#incumbents').append( response.incumbent[i] );
							}
						}
					}
				});
			}
		});
		$('tbody#incumbents').unblock();	
	}
}

function get_to_hire()
{
	var data = {
		plan_id: $('#record_id').val(),
		company_id: $('#recruitment_manpower_plan-company_id').val(),
		department_id: $('#recruitment_manpower_plan-department_id').val(),
		year: $('#recruitment_manpower_plan-year').val(),
		view_type: $('#view_type').val(),
	};
	
	if( data.company_id != "" && data.department_id != "" && data.year != "" )
	{
		$('tbody#positions').block({ message: loading_message(),
			onBlock: function(){
				$.ajax({
					url: base_url + module.get('route') + '/get_to_hire',
					type:"POST",
					data: data,
					dataType: "json",
					async: false,
					success: function ( response ) {
						handle_ajax_message( response.message );

						if( typeof response.position != "undefined" )
						{
							$('tbody#positions').html('');
							for( var i in response.position )
							{
								$('tbody#positions').append( response.position[i] );
							}
						}
					}
				});
			}
		});
		$('tbody#positions').unblock();	
	}
}

function edit_incumbent( user_id, position_id )
{
	$.blockUI({ message: loading_message(),
		onBlock: function(){
			var data = {
				plan_id: $('#record_id').val(),
				user_id: user_id,
				position_id: position_id,
			};
			$.ajax({
				url: base_url + module.get('route') + '/get_incumbent_form',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( typeof(response.incumbent_form) != 'undefined' )
					{
						$('.modal-container').attr('data-width', '850');
						$('.modal-container').html(response.incumbent_form);
						$('.modal-container').modal();
					}	
				}
			});
		}
	});
	$.unblockUI();
}

function edit_to_hire( position_id )
{
	$.blockUI({ message: loading_message(),
		onBlock: function(){
			var data = {
				plan_id: $('#record_id').val(),
				position_id: position_id,
			};
			$.ajax({
				url: base_url + module.get('route') + '/get_tohire_form',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( typeof(response.tohire_form) != 'undefined' )
					{
						$('.modal-container').attr('data-width', '900');
						$('.modal-container').html(response.tohire_form);
						$('.modal-container').modal();
					}
				}
			});
		}
	});
	$.unblockUI();
}

function after_save()
{
	$('div.portlet.plan-details').show('slow');
}

function delete_incumbent_plan( tr )
{
	bootbox.confirm(lang.amp.confirm_delete_plan, function(confirm) {
		if( confirm )
		{
			tr.remove();			
		    var count_plans = $('.count_plans').length;
		    if(!count_plans > 0){
		        $("#no_record").show();
		    }
		}
	});
}

function delete_position_plan( tr )
{
	bootbox.confirm(lang.amp.confirm_delete_plan, function(confirm) {
		if( confirm )
		{
			tr.remove();
		    var count_tohire = $('.count_tohire').length;
		    if(!count_tohire > 0){
		        $("#no_record").show();
		    }
		}
	});
}

function delete_new_position_plan( tr )
{
	bootbox.confirm(lang.amp.confirm_delete_plan, function(confirm) {
		if( confirm )
		{
			tr.remove();
    		var count_newjobs = $('.count_newjobs').length;
		    if(!(count_newjobs > 1)){
		        $("#no_recordjobs").show();
		    }
		}
	});
}

// function add_incumbent_plan()
// {
// 	var selected = $('form#incumbent-form select[name="action_id"]').val();
// 	$('tbody.row-template select[name="action[]"]').val( selected );
// 	$('tbody.saved-plans').append( $('tbody.row-template').html() );
// }

//add incumbent plan 
function add_incumbent_plan(add_form, mode, sequence){

     form_value = $('#action_id').val();
     add_form = 'plan'

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
                    // $('#'+add_form).val('');
                    // $('#add_'+mode).remove();
                    $('.saved-plans').append(response.add_form);
        			$("#no_record").hide("fast");
                }

            }
        }); 
    }else{
        notify('warning', 'Please input rating score.');
    }
}

//add position plan 
function add_position_plan(add_form, mode, sequence){

     form_value = $('#employment_status_selected').val();
     add_form = 'tohire'

    if($.trim(form_value) != ""){    
        $.ajax({
            url: base_url + module.get('route') + '/add_tohire',
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
                    // $('#'+add_form).val('');
                    // $('#add_'+mode).remove();
                    $('.saved-plans').append(response.add_form);	
        			$("#no_record").hide("fast");
                }

            }
        }); 
    }else{
        notify('warning', 'Please select employment status.');
    }
}

// function add_position_plan()
// {
// 	var quantity = $('form#position-form input[name="needed-add"]').val();
// 	$('tbody.row-template input[name="needed[]"]').attr("value", quantity );
// 	$('tbody.saved-plans').append( $('tbody.row-template').html() );
// }

function add_new_job()
{
	var new_position = $('input[name="new_position-add"]').val();

    $.ajax({
        url: base_url + module.get('route') + '/check_position',
        type:"POST",
        async: false,
        data: 'new_position='+new_position,
        dataType: "json",
        beforeSend: function(){
        },
        success: function ( response ) {
            if( response.message_type == 'error' )
            {   
            	notify('error', response.message);
            }
            else{
				$('tbody.new-job-row-template input[name="new_position[position][]"]').attr("value", new_position );
				$('tbody.new-jobs').append( $('tbody.new-job-row-template').html() );

				$('tbody.new-jobs .select2menow').select2({
			        placeholder: "Select",
			        allowClear: true
			    });

				$('tbody.new-jobs .select2menow').removeClass('dontserializeme');
				$('tbody.new-jobs input').removeClass('dontserializeme');
			    $('tbody.new-jobs .select2menow').removeClass('select2menow');

			    $("#no_recordjobs").hide();            	
            }

        }
    }); 
}

function save_incumbent()
{
	$.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
		onBlock: function(){
			var data = $('form#incumbent-form').serialize();
			$.ajax({
				url: base_url + module.get('route') + '/save_incumbent_plans',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );
					$('.modal-container').modal('hide');
					get_incumbent();
				}
			});
		}
	});
	$.unblockUI();	
}

function save_position()
{
	$.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
		onBlock: function(){
			var data = $('form#position-form').serialize();
			$.ajax({
				url: base_url + module.get('route') + '/save_position_plans',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );
					$('.modal-container').modal('hide');
					get_to_hire();
				}
			});
		}
	});
	$.unblockUI();	
}

