function get_movement_details(movement_id){
    $.ajax({
        url: base_url + module.get('route') + '/get_movement_details',
        type:"POST",
        async: false,
        data: 'movement_id='+movement_id,
        dataType: "json",
        success: function ( response ) {
            $('#manage_dialog-'+movement_id).attr('data-content', response.movement_details);
        }
    });
}

function approve_movement( form, action, callback )
{
	$.blockUI({ message: saving_message(),
		onBlock: function(){

			var data = form.find(":not('.dontserializeme')").serialize();

			$.ajax({
				url: base_url + module.get('route') + '/approve_movement',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}
function save_movement( form, action, callback )
{
	$.blockUI({ message: saving_message(),
		onBlock: function(){

			var data = form.find(":not('.dontserializeme')").serialize();
			var movement_data = '';
			if(action == 'modal'){				
				data = data + '&record_id='+ $('#record_id').val();
				data = data + '&partners_movement[remarks]=' +$('#partners_movement-remarks').val();
				data = data + '&partners_movement[due_to_id]=' +$('#partners_movement-due_to_id').val();
			}
			data = data + '&save_from='+ action;

			$.ajax({
				url: base_url + module.get('route') + '/save_movement',
				type:"POST",
				data: data + movement_data,
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

						if(action == 'modal')
						{						
							$.ajax({
								url: base_url + module.get('route') + '/movement_details_list',
								type:"POST",
								async: false,
								data: 'record_id='+response.record_id,
								dataType: "json",
								success: function ( response ) {
									$('#movement_count').val(response.count);
									$('#movement_details-list').html();
							  		$('#movement_details-list').hide().html(response.lists).fadeIn('fast');
								}
							});
							$('.modal-container-action').modal('hide');
						}
						else{
							setTimeout(function(){window.location.replace(base_url + module.get('route'))},2000);
						}
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}

//get employee details
function get_employee_details(user_id, count){
	var data = {
		user_id: user_id,
		count: count
	};
		$.ajax({
			url: base_url + module.get('route') + '/get_employee_details',
			type:"POST",
			async: false,
			data: data,
			dataType: "json",
			beforeSend: function(){
			},
			success: function ( response ) {

				if( typeof(response.retrieved_partners) != 'undefined' )
				{	
					var partner_details = response.partner_info[0];
					$('#company-from_id').val(partner_details.company_id);
					$('#company-from_name').val(partner_details.company);					
					$('#department-from_id').val(partner_details.department_id);
					$('#department-from_name').val(partner_details.department);
					$('#division-from_id').val(partner_details.division_id);
					$('#division-from_name').val(partner_details.division);
					$('#location-from_id').val(partner_details.location_id);
					$('#location-from_name').val(partner_details.location);
					$('#position-from_id').val(partner_details.position_id);
					$('#position-from_name').val(partner_details.position);
					$('#job_level-from_id').val(partner_details.job_grade_id);
					$('#job_level-from_name').val(partner_details.job_level);					
					$('#reports_to-from_id').val(partner_details.reports_to_id);
					$('#reports_to-from_name').val(partner_details.reports_to);
					$('#role-from_id').val(partner_details.role_id);
					$('#role-from_name').val(partner_details.role);
					$('#employment_status-from_id').val(partner_details.employment_status_id);
					$('#employment_status-from_name').val(partner_details.employment_status);
					$('#employment_type-from_id').val(partner_details.employment_type_id);
					$('#employment_type-from_name').val(partner_details.employment_type);
					//no value yet
					$('#rank-from_id').val('');
					$('#rank-from_name').val('');
					$('#project-from_id').val(partner_details.project_id);
					$('#project-from_name').val(partner_details.project);
				}
			}
		});	
}

//add movement 
function edit_movement_display(record_id){
	var data = {
		record_id: record_id
	};
	if(data.record_id > 0){
		$.ajax({
			url: base_url + module.get('route') + '/edit_movement_display',
			type:"POST",
			async: false,
			data: data,
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
				if( typeof(response.add_movement) != 'undefined' && typeof(response.type_of_movement) != 'undefined' )
				{	
					$('#movement_count').val(response.count);
					for( var res in response.add_movement )
					{
						$('#nature_movement').append(response.add_movement[res]);
						$('#movement_type_file-'+response.count).append(response.type_of_movement[res]);
					}
				}
			}
		});	
	}
}


function edit_movement_details(type_id, action_id){	
	if(type_id > 0){
		var data = {
			type_id: type_id,
			action_id: action_id
		};
	}else{		
		var data = {
			type_id: $('#type_id').val(),
			type_name: $('#type_id option:selected').text(),
			action_id: 0
		}
	}
	if($('#partners_movement-due_to_id').val() > 0){
		if(data.type_id > 0){
			$.ajax({
				url: base_url + module.get('route') + '/get_action_movement_details',
				type:"POST",
				async: false,
				data: data,
				dataType: "json",
				beforeSend: function(){
							$('body').modalmanager('loading');
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

							if( typeof(response.add_movement) != 'undefined' )
							{	
								$('.modal-container-action').html(response.add_movement);
								$('.move_action_modal').append(response.type_of_movement);	
								$('.modal-container-action').modal('show');	

								$('#partners_movement-photo-fileupload').fileupload({ 
									url: base_url + module.get('route') + '/single_upload',
									autoUpload: true,
									contentType: false,
								}).bind('fileuploadadd', function (e, data) {
									$.blockUI({ message: '<div>Attaching file, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />' });
								}).bind('fileuploaddone', function (e, data) { 

								    $.unblockUI();
								    var file = data.result.file;
								    if(file.error != undefined && file.error != "")
									{
										notify('error', file.error);
									}
									else{
										$('.files').append(data.result.html);
									}
								}).bind('fileuploadfail', function (e, data) { 
									$.unblockUI();
									notify('error', data.errorThrown);
								});

								$('.delete_attachment').live('click', function(){
									$(this).closest('tr').remove();
								});			

								$(":input").inputmask();							
								// FormComponents.init();
							}

						}
				});	
		}else{
			notify('warning', 'Please select a movement Type.');
		}
	}else{
			notify('warning', 'Please select Due To.');
		}
}

function edit_movement_signatory(user_id, movement_id){	
	if(user_id > 0){
		var data = {
			user_id: user_id,
			movement_id: movement_id
		};
	}

	if($('#partners_movement-due_to_id').val() > 0){
		if(data.user_id > 0){
			$.ajax({
				url: base_url + module.get('route') + '/get_movement_signatory',
				type:"POST",
				async: false,
				data: data,
				dataType: "json",
				beforeSend: function(){
							$('body').modalmanager('loading');
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

							if( typeof(response.add_movement) != 'undefined' )
							{	
								$('.modal-container-action').html(response.add_movement);
								// $('.move_action_modal').append(response.type_of_movement);	
								$('.modal-container-action').modal('show');	
								// FormComponents.init();
							}

						}
				});	
		}else{
			notify('warning', 'Please select a movement Type.');
		}
	}else{
			notify('warning', 'Please select Due To.');
		}
}

//remove phone
function remove_movement(div_form){
	$('#'+div_form).parent().parent().parent().remove();
	// var count = ($('#movement_count').val() - 1);
	// $('#movement_count').val(count);
}

function delete_movement_type( record_id, callback )
{
	bootbox.confirm("Are you sure you want to delete this record?", function(confirm) {
		if( confirm )
		{
			_delete_movement_type( record_id, callback );
		} 
	});
}

function _delete_movement_type( records, callback )
{
	$.ajax({
		url: base_url + module.get('route') + '/delete_movement_type',
		type:"POST",
		data: 'records='+records,
		dataType: "json",
		async: false,
		beforeSend: function(){
			$('body').modalmanager('loading');
		},
		success: function ( response ) {		
			$.ajax({
				url: base_url + module.get('route') + '/movement_details_list',
				type:"POST",
				async: false,
				data: 'record_id='+$('#record_id').val(),
				dataType: "json",
				success: function ( response ) {
					$('#movement_count').val(response.count);
					$('#movement_details-list').html();
			  		$('#movement_details-list').hide().html(response.lists).fadeIn('fast');
				}
			});
			$('body').modalmanager('removeLoading');
			handle_ajax_message( response.message );

		}
	});
}

$(document).ready(function(){
	$(":input").inputmask();
	//UIExtendedModals.init();
	$('.approve').click(function(){
        var movement_id     = $(this).data('movement-id');
        var user_id     = $(this).data('user-id');
        var user_name   = $(this).data('user-name');
        var movement_owner  = $(this).data('movement-owner');
        var decission   = $(this).data('decission');

        comment = '';

        var data = {
            movementid: movement_id,
            userid: user_id,
            username: user_name,
            decission: decission,
            movementownerid: movement_owner,
            comment: comment
        };

        submitDecission(data,'');	
	});

	$('.decline').click(function(){
        var movement_id     = $(this).data('movement-id');
        var user_id     = $(this).data('user-id');
        var user_name   = $(this).data('user-name');
        var movement_owner  = $(this).data('movement-owner');
        var decission   = $(this).data('decission');
        comment = '';

        if (!$("#comment").val()) {
            $("#comment").focus();
            notify("warning", "The Remarks field is required");
            return false;
        } else {
            comment = $("#comment").val();
        }

        var data = {
            movementid: movement_id,
            userid: user_id,
            username: user_name,
            decission: decission,
            movementownerid: movement_owner,
            comment: comment
        };

        submitDecission(data,'');	
	});	
});


function submitDecission(data,view) {
    $.blockUI({ message: saving_message(),
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/movement_decission',
                type: "POST",
                async: false,
                data: data,
                dataType: "json",
                beforeSend: function () {
                    $('.popover-content').block();
                },
                success: function (response) {
                    $('.popover-content').unblock();
                    for (var i in response.message) {
                        notify(response.message[i].type, response.message[i].message);
                    }

                    if (response.action == 'insert') {
                        after_save(response);
                    }
                    if( view == 'index' ){
                        $('.custom_popover').popover('hide');
                    }
                    else{
                        setTimeout(function(){window.location.replace(base_url + module.get('route'))},2000);
                    }
                }
            });
        },
        baseZ: 300000000
    });
    setTimeout(function(){$.unblockUI()},2000);
}

function after_save( response ){    

    //console.log('PERFORMING NODE+SOCKET NOTIFICATION AND LOADING...');
   // console.log('THE RESPONSE DATA: ');
    //console.log(response);
    //console.log('CURRENT USER ID: ');
    //console.log(user_id);
    
    if(response.action == 'insert'){

        if(response.type == 'feed'){ console.log('you have just been FED up!!!... ');


            /*!*
            * The following are socket actions performing
            * dashboard feed notification and post feed
            * broadcast.
            **/

            socket.emit(
                'get_push_data', 
                {
                    channel: 'get_notification', 
                    args: { 
                        broadcaster: user_id, 
                        notify: true 
                    }
                }
            );
            
            // autoload feeds to their respective recipient/s
            socket.emit(
                'get_push_data', 
                {
                    channel: 'get_feed', 
                    args: { 
                        broadcaster: user_id,
                        target: response.target, 
                        notify: false 
                    }
                }
            );
        }
        else if(response.type == 'greetings'){ console.log('loading greetings!!!... ');

            /*!*
            * The following is/are socket actions performing
            * dashboard Birthday Greetings notifications
            * broadcast.
            **/
            socket.emit(
                'get_push_data', 
                {
                    channel: 'get_notification', 
                    args: { 
                        broadcaster: user_id, 
                        notify: true 
                    }
                }
            );
        }
        else if(response.type == 'todo'){ console.log('commencing to do... ');

            /*!*
            * The following is/are socket actions performing
            * dashboard Todo notification and Todo update 
            * broadcast on/with their respective recipient.
            **/

            // notify recipients with the results of their
            // submitted forms
            socket.emit(
                'get_push_data', 
                {
                    channel: 'get_notification', 
                    args: { 
                        broadcaster: user_id, 
                        notify: true 
                    }
                }
            );          
        }

    }
}

//get employee details
function get_current_salary(user_id){
	var data = {
		user_id: user_id
	};
		$.ajax({
			url: base_url + module.get('route') + '/get_current_salary',
			type:"POST",
			async: false,
			data: data,
			dataType: "json",
			beforeSend: function(){
			},
			success: function ( response ) {

				if( typeof(response.retrieved_salary) != 'undefined' )
				{	
					$('#partners_movement_action_compensation-current_salary').val(response.current_salary);
				}
			}
		});	
}

//get last_probationary 
function get_end_date(user_id){
	var data = {
		user_id: user_id,
		months: $('#partners_movement_action_extension-no_of_months').val(),
		effective_date: $('#partners_movement_action-effectivity_date').val()
	};
		$.ajax({
			url: base_url + module.get('route') + '/get_end_date',
			type:"POST",
			async: false,
			data: data,
			dataType: "json",
			beforeSend: function(){
			},
			success: function ( response ) {
				if( typeof(response.retrieved_enddate) != 'undefined' )
				{	
					$('#partners_movement_action_extension-end_date').val(response.end_date);
				}else{
					$('#partners_movement_action_extension-end_date').val('');
				}
			}
		});	
}