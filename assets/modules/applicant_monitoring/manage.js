$(document).ready(function(){
	filter_all( $('form[name="filter"] input[name="year"]').val() );

    $('#recruitment_request-how_hiring_heard').on('click', function(){
        alert('q23');
    });
	
	$('.delete_sched_row').live('click',function(){
		$(this).closest('.bi_form_header').remove();
	});

	$('.template_id').live('change',function(){
		var jo_template_id = $(this).val();
		var process_id = $('#process_id').val();
		var recruit_id = $('#recruit_id').val();
		$.ajax({
			url: base_url + module.get('route') + '/get_jo_template',
			type:"POST",
			dataType: "json",
			data: {jo_template_id:jo_template_id,process_id:process_id,recruit_id:recruit_id},
			async: false,
			beforeSend: function(){
			},
			success: function ( response ) {
				$('.template_val').data("wysihtml5").editor.setValue(response.jo_template);
			}
		});		
	});
});

function get_steps()
{
	if( $('form[name="filter"] input[name="request_id"]').val() != "" )
	{
		var request_id = $('form[name="filter"] input[name="request_id"]').val();
		$('a.filter-year').removeClass('blue').addClass('default');
		$('a.filter-request').removeClass('blue').addClass('default');
		$('a[request_id="'+request_id+'"]').addClass('blue').removeClass('default');
	}
	else{
		var year = $('form[name="filter"] input[name="year"]').val();
		$('a.filter-year').removeClass('blue').addClass('default');
		$('a.filter-request').removeClass('blue').addClass('default');
		$('a[year="'+year+'"]').addClass('blue').removeClass('default');
	}

	$('div.steps-container').block({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/get_steps',
				type:"POST",
				dataType: "json",
				data: $('form[name="filter"]').serialize(),
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					$('div.steps-container').html('');
					$('div.steps-container').append(response.header);
					$('div.steps-container').append(response.steps);
				}
			});
		}
	});
	$('div.steps-container').unblock();
}

function filter_detail( request_id )
{
	$('form[name="filter"] input[name="request_id"]').val(request_id);
	get_steps();
}

function filter_all( year )
{
	$('form[name="filter"] input[name="year"]').val(year);
	$('form[name="filter"] input[name="request_id"]').val('');
	get_steps();
}

function add_schedule( process_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/get_schedule_form',
				type:"POST",
				dataType: "json",
				data: {process_id:process_id},
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( typeof response.schedule_form != 'undefined' )
					{
						$('.modal-container').attr('data-width', '900');
						$('.modal-container').html(response.schedule_form);
						$('.modal-container').modal();
						init_datepicker();
						init_searchabledd();
					}
				}
			});
		}
	});
	$.unblockUI();
}

function get_interview_list( process_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/get_interview_list',
				type:"POST",
				dataType: "json",
				data: {process_id:process_id},
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( typeof response.interview_list != 'undefined' )
					{
						$('.modal-container').attr('data-width', '900');
						$('.modal-container').addClass('modal fade');
						$('.modal-container').html(response.interview_list);
						$('.modal-container').modal();
						init_datepicker();
						init_switch_exam();
						// init_searchabledd();
					}
				}
			});
		}
	});
	$.unblockUI();
}
// function add_exam_row()
// {
// 	var new_row = $('#exam-row tbody').html();
// 	$('#saved-exams').append(new_row);
// 	init_datepicker();
// 	init_switch_exam();
// 	$("#no_record_exam").hide();
// }

//add score 
function add_exam_row(){

    $.ajax({
        url: base_url + module.get('route') + '/add_exam_form',
        type:"POST",
        async: false,
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
                $('#saved-exams').append(response.add_form);
				$("#no_record_exam").hide();
				init_datepicker();
				init_switch_exam();
            }

        }
    });     
}


// function add_sched_row()
// {
// 	var new_row = $('#sched-row tbody').html();
// 	$('#saved-scheds').append(new_row);
// 	init_sched_user_typeahead();
// 	init_datepicker()
// 	init_searchabledd();
// 	$("#no_record").hide();
// }

function add_sched_row(type=1){

    $.ajax({
        url: base_url + module.get('route') + '/add_sched_row',
        type:"POST",
        async: false,
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
                if (type == 1){
                	$('#saved-scheds').append(response.add_form);
                }
                else{
                	$('#saved-scheds-final').append(response.add_form);
                }
				$("#no_record").hide();
				init_datepicker();
				init_sched_user_typeahead();
				// init_switch_exam();
            }

        }
    });     
}

function delete_exam_row(column)
{
	column.closest("tr").remove();

    var exam_assessment = $('.exam_assessment').length;
    if( !(exam_assessment > 1) ){
        $("#no_record_exam").show();
    }
}

function add_benefit_row(add_form, mode, sequence){
    	
    $.ajax({
        url: base_url + module.get('route') + '/add_benefit_row',
        type:"POST",
        async: false,
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
            if( typeof(response.benefit) != 'undefined' )
            {   
                $('#saved-benefits').append(response.benefit);
                $("#no_record").hide();
                $(":input").inputmask();
                
            	$('.make-switch').not(".has-switch")['bootstrapSwitch']();

		        $('.recruitment-permanent-temp').change(function(){
		            if( $(this).is(':checked') ){
		                $(this).parent('div').next().val(0);
		            }
		            else{
		                $(this).parent('div').next().val(1);
		            }
		        });             	                
            }

        }
    }); 
}


function delete_row(column)
{
	column.closest("tr").remove();

    var step1_interview = $('.step1_interview').length;
    if( !(step1_interview > 1) ){
        $("#no_record").show();
    }
}

function delete_benefit_row(column)
{
	column.closest("tr").remove();
    var comben = $('.combenefits').length;
    if( !(comben > 0) ){
        $("#no_record").show();
    }
}


function init_sched_user_typeahead()
{
	$('input[name="partner_name"]').typeahead({
        source: function(query, process) {
            employees = [];
            map = {};
            
            $.getJSON(base_url + module.get('route') + '/user_lists_typeahead', function(data){
                var users = data.users;
                for( var i in users)
                {
                    employee = users[i];
                    map[employee.label] = employee;
                    employees.push(employee.label);
                }
             
                process(employees);    
            });
            
        },
        updater: function (item) {
            this.$element.parent().find('input[name="sched_user_id[]"]').val(map[item].value);
            return item;
        },
        click: function (e) {
          e.stopPropagation();
          e.preventDefault();
          this.select();
        }
    });

    $('input[name="partner_name"]').focus(function(){
        $(this).val('');
        $(this).parent().find('input[name="sched_user_id[]"]').val('');
    });
}

function save_schedule()
{
	$.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_schedule',
				type:"POST",
				dataType: "json",
				data: $('form[name="schedule-form"]').serialize(),
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if(response.notify != "undefined")
					{
						for(var i in response.notify)
							socket.emit('get_push_data', {channel: 'get_user_'+response.notify[i]+'_notification', args: { broadcaster: user_id, notify: true }});
					}
					if(response.saved){
						$('.modal-container').modal('hide');
						get_steps();
					}
				}
			});
		},
		baseZ: 999999999
	});
	$.unblockUI();
}

function save_bi()
{
	$.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_bi',
				type:"POST",
				dataType: "json",
				data: $('form[name="bi-form"]').serialize(),
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if(response.notify != "undefined")
					{
						for(var i in response.notify)
							socket.emit('get_push_data', {channel: 'get_user_'+response.notify[i]+'_notification', args: { broadcaster: user_id, notify: true }});
					}
					if(response.saved){
						// $('.modal-container').modal('hide');
						get_steps();
					}
				}
			});
		},
		baseZ: 999999999
	});
	$.unblockUI();
}

function save_exam()
{
	$.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_exam',
				type:"POST",
				dataType: "json",
				data: $('form[name="exam-form"]').serialize(),
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if(response.notify != "undefined")
					{
						for(var i in response.notify)
							socket.emit('get_push_data', {channel: 'get_user_'+response.notify[i]+'_notification', args: { broadcaster: user_id, notify: true }});
					}
					if(response.saved){
						// $('.modal-container').modal('hide');
						get_steps();
					}
				}
			});
		},
		baseZ: 999999999
	});
	$.unblockUI();
}

function save_jo()
{
	$.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_jo',
				type:"POST",
				dataType: "json",
				data: $('form[name="jo-form"]').find(":not('.dontserializeme')").serialize(),
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
                    if(response.message[0].type == "success" && response.accepted == 0)
                    {
                        $('#email_job_offer').addClass('hidden');
                        $('#move_pre_em').addClass('hidden');  
                    }  
                    else{
                        $('#email_job_offer').removeClass('hidden');
                        $('#move_pre_em').removeClass('hidden');               	
                    }                
					handle_ajax_message( response.message );
					get_steps();
				}
			});
		},
		baseZ: 999999999
	});
	$.unblockUI();
}

function save_cs()
{
	$.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_cs',
				type:"POST",
				dataType: "json",
				data: $('form[name="cs-form"]').find(":not('.dontserializeme')").serialize(),
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
                    if(response.message[0].type == "success")
                    {
                        $('#print_cs').removeClass('hidden');
                        $('#move_pre_em').removeClass('hidden');
                    }
					handle_ajax_message( response.message );
					get_steps();
					
					if (response.signing_accepted == true){
						$('#create_201').show();
					}					
				}
			});
		},
		baseZ: 999999999
	});
	$.unblockUI();
}

function init_datepicker()
{
	$(".sched_datetime").datetimepicker({
	    isRTL: App.isRTL(),
	    format: "MM dd, yyyy - hh:ii",
	    autoclose: true,
	    todayBtn: true,
	    pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
	    minuteStep: 1
	});
    $(".sched_datetime").datetimepicker('setStartDate', new Date());

	$('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
}

function init_searchabledd()
{
	$('.select2me').select2({
        placeholder: "Select",
        allowClear: true
    });
}

function edit_interview_result( schedule_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/get_interview_form',
				type:"POST",
				dataType: "json",
				data: {schedule_id:schedule_id},
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( typeof response.interview_form != 'undefined' )
					{
						$('.modal-extra').attr('data-width', '800');
						$('.modal-extra').html(response.interview_form);
						$('.modal-extra').modal();
					}
				}
			});
		},
		baseZ: 999999999
	});
	$.unblockUI();	
}

function view_interview_result( schedule_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/view_interview_result',
				type:"POST",
				dataType: "json",
				data: {schedule_id:schedule_id},
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( typeof response.interview_form != 'undefined' )
					{
						$('.modal-extra').attr('data-width', '900');
						$('.modal-extra').html(response.interview_form);
						$('.modal-extra').modal();
					}
				}
			});
		},
		baseZ: 999999999
	});
	$.unblockUI();	
}

function save_interview()
{
	$.blockUI({ message: '<div>Saving interview result, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_interview',
				type:"POST",
				dataType: "json",
				data: $('form[name="interview-form"]').serialize(),
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if (response.status_id == 2){
						if (response.interview_reult == 'Consider'){
							get_steps();
						}
					}
					else{
						get_steps();
					}
					$('.modal-extra').modal('hide');

					if (response.from_seting_final_interview == 1){
						get_interview_list( response.process_id );
					}
					else{
						$.ajax({
							url: base_url + module.get('route') + '/get_interview_list_only',
							type:"POST",
							dataType: "json",
							data: {process_id:response.process_id},
							async: false,
							beforeSend: function(){
							},
							success: function ( response ) {
								handle_ajax_message( response.message );
								if( typeof response.interview_list != 'undefined' )
								{
									$('#saved-interviews').html(response.interview_list);
									init_datepicker();
									init_switch_exam();
									// init_searchabledd();
								}
							}
						});						
					}
				}
			});
		},
		baseZ: 999999999
	});
	$.unblockUI();		
}

function move_to_jo(process_id,result_id)
{
	bootbox.confirm("Are you sure you want to move this applicant to Job Offer status?", function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/move_to_jo',
						type:"POST",
						async: false,
						data: {process_id:process_id, result_id:result_id},
						dataType: "json",
						success: function ( response ) {
							$('.modal-container').modal('hide');
							$.unblockUI();
							get_steps();
						}
					});
				}
			});
		}
	});
}

function move_to_exam(process_id,result_id)
{
	bootbox.confirm("Are you sure you want to move this applicant to Examination?", function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/move_to_exam',
						type:"POST",
						async: false,
						data: {process_id:process_id, result_id:result_id},
						dataType: "json",
						success: function ( response ) {
							$('.modal-container').modal('hide');
							$.unblockUI();
							get_steps();
						}
					});
				}
			});
		}
	});
}

function move_to_bi(process_id,result_id)
{
	bootbox.confirm("Are you sure you want to move this applicant to Background Investigation?", function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/move_to_bi',
						type:"POST",
						async: false,
						data: {process_id:process_id, result_id:result_id},
						dataType: "json",
						success: function ( response ) {
							$('.modal-container').modal('hide');
							$.unblockUI();
							get_steps();
						}
					});
				}
			});
		}
	});
}

function move_to_final_interview(process_id)
{
	bootbox.confirm("Are you sure you want to move this applicant to Final Interview?", function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/move_to_final_interview',
						type:"POST",
						async: false,
						data: {process_id:process_id},
						dataType: "json",
						success: function ( response ) {
							$('.modal-container').modal('hide');
							$.unblockUI();
							get_steps();
						}
					});
				}
			});
		}
	});
}

function add_prev_work_row(){
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/add_prev_work_row',
				type:"POST",
				dataType: "json",
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( typeof response.bi_form != 'undefined' )
					{
						$('#bi-form').append(response.bi_form);

						$('.delete_sched_row').live('click',function(){
							$(this).parent('.bi_form_header').remove();
						});	
						
						$('.make-switch').not(".has-switch")['bootstrapSwitch']();		
						
						init_datepicker();									
					}
				}
			});
		}
	});
	$.unblockUI();
}

function get_jo_form( process_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/get_jo_form',
				type:"POST",
				dataType: "json",
				data: {process_id:process_id},
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( typeof response.jo_form != 'undefined' )
					{
						$('.modal-container').attr('data-width', '900');
						$('.modal-container').html(response.jo_form);
						$('.modal-container').modal();
						init_datepicker();
						$(":input").inputmask();
						$('select.select2me').select2();
						if ($('.wysihtml5').size() > 0) {
							$('.wysihtml5').wysihtml5({
								"stylesheets": ["assets/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
							});
						
							$('input[name="_wysihtml5_mode"]').addClass('dontserializeme');
						}						
					}
				}
			});
		}
	});
	$.unblockUI();
}

function get_preemp_form( process_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/get_preemp_form',
				type:"POST",
				dataType: "json",
				data: {process_id:process_id},
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( typeof response.jo_form != 'undefined' )
					{
						$('.modal-container').attr('data-width', '900');
						$('.modal-container').html(response.jo_form);
						$('.modal-container').modal();
						init_datepicker();
						$('select.select2me').select2();
						if ($('.wysihtml5').size() > 0) {
							$('.wysihtml5').wysihtml5({
								"stylesheets": ["assets/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
							});
						
							$('input[name="_wysihtml5_mode"]').addClass('dontserializeme');
						}							
					}
				}
			});
		}
	});
	$.unblockUI();
}

function move_to_preemp(process_id)
{
	bootbox.confirm("Are you sure you want to move this applicant to Pre-employment status?", function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/move_to_preemp',
						type:"POST",
						async: false,
						data: {process_id:process_id},
						dataType: "json",
						success: function ( response ) {
							handle_ajax_message( response.message );
							$('.modal-container').modal('hide');
							$.unblockUI();
							get_steps();
						}
					});
				}
			});
		}
	});
}


function move_to_cs(process_id)
{
	bootbox.confirm("Are you sure you want to move this applicant to contract Signing status?", function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/move_to_cs',
						type:"POST",
						async: false,
						data: {process_id:process_id},
						dataType: "json",
						success: function ( response ) {
							handle_ajax_message( response.message );
							if(response.moved == 1){
								$('.modal-container').modal('hide');
							}

							$.unblockUI();
							get_steps();
						}
					});
				}
			});
		}
	});
}

function ajax_export( process_id, template )
{
	$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				// {{ get_mod_route('report_generator') }}
				url: base_url + module.get('route') +'/ajax_export',
				type:"POST",
				dataType: "json",
				data:'process_id='+process_id+'&template='+template,
				async: false,
				success: function ( response ) {
					if( response.filename != undefined )
					{
						window.open( root_url + response.filename );
					}
					handle_ajax_message( response.message );
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();	
}

function get_cs_form( process_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/get_cs_form',
				type:"POST",
				dataType: "json",
				data: {process_id:process_id},
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( typeof response.cs_form != 'undefined' )
					{
						$('.modal-container').attr('data-width', '900');
						$('.modal-container').html(response.cs_form);
						$('.modal-container').modal();
						init_datepicker();
						init_switch();
					}
				}
			});
		}
	});
	$.unblockUI();
}

function move_to_preemp(process_id)
{
	bootbox.confirm("Are you sure you want to move this applicant to Pre-employment status?", function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/move_to_preemp',
						type:"POST",
						async: false,
						data: {process_id:process_id},
						dataType: "json",
						success: function ( response ) {
							$('.modal-container').modal('hide');
							$.unblockUI();
							get_steps();
						}
					});
				}
			});
		}
	});
}

function add_candid( candid_id )
{
	$.ajax({
	    url: base_url + module.get('route') + '/add_candid',
	    type: "POST",
	    async: false,
	    data: 'add_candid='+add_candid,
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
	        if (typeof (response.sign) != 'undefined') {
	        	$('.modal-container').attr('data-width', '900');
	        	$('.modal-container').html(response.sign);
				$('.modal-container').modal();
				// upload_files();
	        	/*$('#greetings_dialog').html(response.greetings);
				$('#greetings_dialog').modal('show');	*/            
	        }
	        handle_ajax_message( response.message );
	    }
	});
}

function save_applicant( partner )
{
	partner.submit( function(e){ e.preventDefault(); } );
	var user_id = $('#record_id').val();
	var partner_id = partner.attr('partner_id');
	$.blockUI({ message: "Trying to save, please wait...", 
		onBlock: function(){
			partner.submit( function(e){ e.preventDefault(); } );
			var partner_id = partner.attr('partner_id');
			var data = partner.find(":not('.dontserializeme')").serialize();
			data = data + '&record_id=' + $('#record_id').val()+ '&fgs_number=' + partner_id;
			$.ajax({
				url: base_url + module.get('route') + '/save_applicant',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					$('#record_id').val( response.record_id );

					handle_ajax_message( response.message );
					
					if(response.saved )
					{
						$('#form-1').trigger("reset");
						self.location.reload();
					}
				}
			});
		}
	});
	$.unblockUI();	
    // location.reload();
}

function init_switch()
{
	$('#signing-accepted-temp').change(function(){
		if( $(this).is(':checked') )
			$('#signing-accepted').val('1');
		else
			$('#signing-accepted').val('0');
	});
}

function init_switch_exam()
{
	$('.make-switch').not(".has-switch")['bootstrapSwitch']();

	$('.exam_status').change(function(){
	    if( $(this).is(':checked') ){
	    	$(this).parent().next().val(1);
	    }
	    else{
	    	$(this).parent().next().val(0);
	    }
	});
}

function delete_item(tr){
	tr.remove();

	$('.add-item').hide();
    $('.multiple_add tr:last-child .add-item').show();
    var add_multitem = $('.multiple-itemrow').length;
    if( !(add_multitem > 1) ){
    	$('.add-item').show();
    	$('.delete-item').hide();
    }
}

function add_item(add_form, mode, sequence){
    	
    $.ajax({
        url: base_url + module.get('route') + '/add_item',
        type:"POST",
        async: false,
        data: 'header_text='+add_form+'&key_code='+mode,
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
            if( typeof(response.add_item) != 'undefined' )
            {   
                // $('#'+add_form).val('');
                // $('#add_'+mode).remove();
                $('.add-item').hide();
    			$('.delete-item').show();
                $('.multiple_add').append(response.add_item);
            }

        }
    }); 
}

function add_item_remarks(add_form, mode, sequence){
    	
    $.ajax({
        url: base_url + module.get('route') + '/add_item_remarks',
        type:"POST",
        async: false,
        data: 'header_text='+add_form+'&key_code='+mode,
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
            if( typeof(response.add_item) != 'undefined' )
            {   
                // $('#'+add_form).val('');
                // $('#add_'+mode).remove();
                $('.add-item').hide();
    			$('.delete-item').show();
                $('.multiple_add').append(response.add_item);
                // init_searchabledd();
            }

        }
    }); 
}

function create_201( process_id, user_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/get_201_form',
				type:"POST",
				dataType: "json",
				data: {process_id:process_id, user_id:user_id},
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( typeof response.form201 != 'undefined' )
					{
						$('.modal-container').attr('data-width', '900');
						$('.modal-container').html(response.form201);
						$('.modal-container').modal();
						init_datepicker();
						init_searchabledd();
						$(":input").inputmask();
						if ($('.wysihtml5').size() > 0) {
							$('.wysihtml5').wysihtml5({
								"stylesheets": ["assets/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
							});
						
							$('input[name="_wysihtml5_mode"]').addClass('dontserializeme');
						}							
/*	                    $.ajax({
	                        url: base_url + module.get('route') + '/get_employee_id_no',
	                        type:"POST",
	                        async: false,
	                        dataType: "json",
	                        beforeSend: function(){
	                            // $('body').modalmanager('loading');
	                        },
	                        success: function ( response ) {
	                            $('#users-login').val(response.id_number);

	                        }
	                    }); */
					}
				}
			});
		}
	});
	$.unblockUI();
}

function save_201()
{
	$.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_201',
				type:"POST",
				dataType: "json",
				data: $('form[name="201-form"]').serialize(),
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if(response.notify != "undefined")
					{
						for(var i in response.notify)
							socket.emit('get_push_data', {channel: 'get_user_'+response.notify[i]+'_notification', args: { broadcaster: user_id, notify: true }});
					}
					if(response.saved){
						$('.modal-container').modal('hide');
						get_steps();
						$.unblockUI();
					}
				}
			});
		},
		baseZ: 999999999
	});
	$.unblockUI();
}

function save_preemp(checklist_id, process_id, submitted)
{
	var data = {
		checklist_id : checklist_id,
		process_id : process_id,
		submitted : submitted
	}
	$.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_preemp',
				type:"POST",
				dataType: "json",
				data: data,
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					// get_steps();
				}
			});
		},
		baseZ: 999999999
	});
	$.unblockUI();
}

function move_to_c201(process_id)
{
	bootbox.confirm("Are you sure you want this applicant to proceed to create 201?", function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/move_to_c201',
						type:"POST",
						async: false,
						data: $('form[name="preemp"]').serialize(),
						dataType: "json",
						success: function ( response ) {
							handle_ajax_message( response.message );
							$('.modal-container').modal('hide');
							$.unblockUI();
							get_steps();
						}
					});
				}
			});
		}
	});
}

function send_email(process_id, user_id)
{
	bootbox.confirm("This will send email to both the applicant and the interviewer.<br> Click OK to continue.", function(confirm) {
		if( confirm )
		{
			var data = {
				process_id:process_id, 
				user_id:user_id
				}
			$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/send_email',
						type:"POST",
						async: false,
						data: data,
						dataType: "json",
						success: function ( response ) {
							handle_ajax_message( response.message );
							// $('.modal-container').modal('hide');
							$.unblockUI();
							// get_steps();
						}
					});
				}
			});
		}
	});
}

function email_jo (process_id)
{
	bootbox.confirm("This will send email of job offer details to the applicant.<br> Click OK to continue.", function(confirm) {
		if( confirm )
		{
			var data = {
				process_id:process_id
				}
			$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/email_jo',
						type:"POST",
						async: false,
						data: data,
						dataType: "json",
						success: function ( response ) {
							handle_ajax_message( response.message );
							// $('.modal-container').modal('hide');
							$.unblockUI();
							// get_steps();
						}
					});
				}
			});
		}
	});
}

function print_jo (process_id)
{
	var data = {
		process_id:process_id
		}
	$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/print_jo',
				type:"POST",
				async: false,
				data: $('form[name="jo-form"]').serialize(),
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

function print_emp_agree (process_id)
{
	var data = {
		process_id:process_id
		}
	$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/print_emp_agree',
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

function print_interview (process_id)
{
	var data = {
		process_id:process_id
		}
	$.blockUI({ message: '<div>Loading, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/print_interview',
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

function print_bi (process_id)
{
	var data = {
		process_id:process_id
		}
	$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/print_bi',
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

function print_jd (process_id)
{
	var data = {
		process_id:process_id
		}
	$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/print_jd',
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

function print_preemp_checklist (process_id)
{
	var data = {
		process_id:process_id
		}
	$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/print_preemp_checklist',
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


function print_nondisclosure (process_id)
{
	var data = {
		process_id:process_id
		}
	$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/print_nondisclosure',
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
