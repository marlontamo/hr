$(document).ready(function(){
	$('select[name="class_id"]').change(function(){
		if( $(this).val() == '' )
		{
			$('input[name="set_for"]').val('');
			$('input[name="set_for_id"]').val('');
			$('#signatory-listing').html('');
		}
	});

	$('button[data-action="expand-company"], button[data-action="collapse-company"]').click(function(){
		var $this = $(this);
		$this.css('display', 'none');
		var action = $this.attr('data-action');
		var li = $this.parent();
		var company_id = li.attr('company_id');
		
		switch( action )
		{
			case 'expand-company':
				li.find('button[data-action="collapse-company"]').css('display', 'block');
				var deparments = li.find('ol.dd-list');
				if( deparments.html() == "" )
				{
					$.blockUI({ message: loading_message(), 
						onBlock: function(){
							$.ajax({
								url: base_url + module.get('route') + '/get_company_department',
								type:"POST",
								data: {company_id: company_id},
								dataType: "json",
								async: false,
								beforeSend: function(){
								},
								success: function ( response ) {
									handle_ajax_message( response.message );
									$('ol.dd-list[company_id="'+company_id+'"]').html(response.department);
									$('input[type="checkbox"]').uniform();
									init_departments();
								}
							});
						}
					});
					$.unblockUI();
				}
				$('ol.dd-list[company_id="'+company_id+'"]').show();
				break;
			case 'collapse-company':
				li.find('button[data-action="expand-company"]').css('display', 'block');
				$('ol.dd-list[company_id="'+company_id+'"]').hide();
				break; 
		}
	});
});

function set_hidden_val( company_id, department_id, position_id, user_id )
{
	$('input[name="company_id"]').val( company_id );
	$('input[name="department_id"]').val( department_id );
	$('input[name="position_id"]').val( position_id );
	$('input[name="user_id"]').val( user_id );
}

function init_departments(){
	$('button[data-action="expand-department"], button[data-action="collapse-department"]').click(function(){
		var $this = $(this);
		$this.css('display', 'none');
		var action = $this.attr('data-action');
		var li = $this.parent();
		var department_id = li.attr('department_id');
		var company_id = li.attr('company_id');

		switch( action )
		{
			case 'expand-department':
				li.find('button[data-action="collapse-department"]').css('display', 'block');
				var positions = li.find('ol.dd-list');
				if( positions.html() == "" )
				{
					$.blockUI({ message: loading_message(), 
						onBlock: function(){
							$.ajax({
								url: base_url + module.get('route') + '/get_department_position',
								type:"POST",
								data: {department_id: department_id, company_id: company_id},
								dataType: "json",
								async: false,
								beforeSend: function(){
								},
								success: function ( response ) {
									handle_ajax_message( response.message );
									$('ol.dd-list[department_id="'+department_id+'"]').html(response.position);
									$('input[type="checkbox"]').uniform();

									init_users();
								}
							});
						}
					});
					$.unblockUI();
				}
				$('ol.dd-list[department_id="'+department_id+'"]').show();
				break;
			case 'collapse-department':
				li.find('button[data-action="expand-department"]').css('display', 'block');
				$('ol.dd-list[department_id="'+department_id+'"]').hide();
				break; 
		}
	});
}

function init_users()
{
	$('button[data-action="expand-position"], button[data-action="collapse-position"]').click(function(){
		var $this = $(this);
		$this.css('display', 'none');
		var action = $this.attr('data-action');
		var li = $this.parent();
		var department_id = li.attr('department_id');
		var company_id = li.attr('company_id');
		var position_id = li.attr('position_id');

		switch( action )
		{
			case 'expand-position':
				li.find('button[data-action="collapse-position"]').css('display', 'block');
				var users = li.find('ol.dd-list');
				if( users.html() == "" )
				{
					$.blockUI({ message: loading_message(), 
						onBlock: function(){
							$.ajax({
								url: base_url + module.get('route') + '/get_position_employees',
								type:"POST",
								data: {department_id: department_id, company_id: company_id, position_id: position_id},
								dataType: "json",
								async: false,
								beforeSend: function(){
								},
								success: function ( response ) {
									handle_ajax_message( response.message );
									$('ol.dd-list[position_id="'+position_id+'"]').html(response.user);
									$('input[type="checkbox"]').uniform();
								}
							});
						}
					});
					$.unblockUI();
				}
				$('ol.dd-list[position_id="'+position_id+'"]').show();
				break;
			case 'collapse-position':
				li.find('button[data-action="expand-position"]').css('display', 'block');
				$('ol.dd-list[position_id="'+position_id+'"]').hide();
				break; 
		}
	});	
}

function get_signatory()
{
	var set_for = $('input[name="set_for"]').val();
	var company_id = $('input[name="company_id"]').val();
	var department_id = $('input[name="department_id"]').val();
	var position_id = $('input[name="position_id"]').val();
	var user_id = $('input[name="user_id"]').val();
	switch( set_for )
	{
		case "company":
			get_company_signatories( company_id );
			break;
		case "department":
			get_department_signatories( department_id, company_id );
			break;
		case "position":
			get_position_signatories( position_id, department_id, company_id );
			break;
		case "user":
			get_user_signatories( user_id, position_id, department_id, company_id );
			break;	
	}	
}

function get_company_signatories( company_id ){
	set_hidden_val( company_id, '', '', '');
	var class_id = $('select[name="class_id"]').val();
	if( class_id != "" ){
		$('#signatory-listing').html('');
		$('#signatory-listing').block({ message: loading_message(),
			onBlock: function(){
				$('input[name="set_for"]').val("company");
				$('input[name="set_for_id"]').val(company_id);
				$.ajax({
					url: base_url + module.get('route') + '/get_company_signatories',
					type:"POST",
					data: "class_id="+class_id+"&company_id="+company_id,
					dataType: "json",
					async: false,
					success: function ( response ) {
						$('#signatory-listing').html(response.signatories);
						handle_ajax_message( response.message );
					}
				});
				$('#signatory-listing').unblock();
				App.initUniform('.record-checker');
				App.initUniform('.group-checkable');
			}
		 });
	}
	else{
		notify('warning', 'Please select a class firsts.');
	}
}

function get_department_signatories( department_id, company_id ){
	set_hidden_val(company_id, department_id, '', '');
	var class_id = $('select[name="class_id"]').val();
	if( class_id != "" ){
		$('#signatory-listing').html('');
		$('#signatory-listing').block({ message: loading_message(),
			onBlock: function(){
				$('input[name="set_for"]').val("department");
				$('input[name="set_for_id"]').val(department_id);
				$.ajax({
					url: base_url + module.get('route') + '/get_department_signatories',
					type:"POST",
					data: {class_id: class_id, department_id: department_id, company_id: company_id},
					async: false,
					dataType: "json",
					success: function ( response ) {
						$('#signatory-listing').html(response.signatories);
						handle_ajax_message( response.message );
					}
				});
				$('#signatory-listing').unblock();
				App.initUniform('.record-checker');
				App.initUniform('.group-checkable');
			}
		 });
	}
	else{
		notify('warning', 'Please select a class firsts.');
	}
}

function get_position_signatories( position_id, department_id, company_id ){
	set_hidden_val(company_id, department_id, position_id, '');
	var class_id = $('select[name="class_id"]').val();
	if( class_id != "" ){
		$('#signatory-listing').html('');
		$('#signatory-listing').block({ message: loading_message(),
			onBlock: function(){
				$('input[name="set_for"]').val("position");
				$('input[name="set_for_id"]').val(position_id);
				$.ajax({
					url: base_url + module.get('route') + '/get_position_signatories',
					type:"POST",
					data: {class_id: class_id, department_id: department_id, company_id: company_id, position_id: position_id},
					async: false,
					dataType: "json",
					success: function ( response ) {
						$('#signatory-listing').html(response.signatories);
						handle_ajax_message( response.message );
					}
				});
				$('#signatory-listing').unblock();
				App.initUniform('.record-checker');
				App.initUniform('.group-checkable');
			}
		 });
	}
	else{
		notify('warning', 'Please select a class firsts.');
	}
}

function get_user_signatories( user_id, position_id, department_id, company_id ){
	set_hidden_val(company_id, department_id, position_id, user_id);
	var class_id = $('select[name="class_id"]').val();
	if( class_id != "" ){
		$('#signatory-listing').html('');
		$('#signatory-listing').block({ message: loading_message(),
			onBlock: function(){
				$('input[name="set_for"]').val("user");
				$('input[name="set_for_id"]').val(user_id);
				$.ajax({
					url: base_url + module.get('route') + '/get_user_signatories',
					type:"POST",
					data: {class_id: class_id, department_id: department_id, company_id: company_id, position_id: position_id, user_id: user_id},
					dataType: "json",
					async: false,
					success: function ( response ) {
						$('#signatory-listing').html(response.signatories);
						handle_ajax_message( response.message );
					}
				});
				$('#signatory-listing').unblock();
				App.initUniform('.record-checker');
				App.initUniform('.group-checkable');
			}
		 });
	}
	else{
		notify('warning', 'Please select a class firsts.');
	}
}


function edit_signatory( sig_id )
{
	var set_for = $('input[name="set_for"]').val();
	if( set_for != "" )
	{
		var class_id = $('select[name="class_id"]').val();
		var set_for_id = $('input[name="set_for_id"]').val();
		var company_id = $('input[name="company_id"]').val();
		var department_id = $('input[name="department_id"]').val();
		var position_id = $('input[name="position_id"]').val();
		var user_id = $('input[name="user_id"]').val();
		var data = {
			sig_id: sig_id,
			set_for: set_for,
			class_id: class_id,
			company_id: company_id,
			department_id: department_id,
			position_id: position_id,
			user_id: user_id
		};

		$.blockUI({ message: loading_message(), 
			onBlock: function(){
				$.ajax({
					url: base_url + module.get('route') + '/edit_signatory',
					type:"POST",
					data: data,
					dataType: "json",
					async: false,
					beforeSend: function(){
					},
					success: function ( response ) {
						handle_ajax_message( response.message );
						if( typeof(response.edit_form) != 'undefined' )
						{
							$('.modal-container').html(response.edit_form);
							$('.modal-container').modal();
							$('form#edit_signatory .make-switch').not(".has-switch")['bootstrapSwitch']();
							$('form#edit_signatory .select2me').select2({
							    placeholder: "Select an option",
							    allowClear: true
							});
						}
					}
				});
			}
		});
		$.unblockUI();
	}
	else{
		if(set_for == '')
		{
			notify('warning', 'Please select an option to set firsts.');	
		}
	}
}

function delete_signatory( sig_id )
{	
	var set_for = $('input[name="set_for"]').val();
	if( set_for != "" )
	{
		$.ajax({
			url: base_url + module.get('route') + '/count_affected_forms',
			type:"POST",
			data: {set_for: set_for, sig_id: sig_id},
			dataType: "json",
			async: false,
			beforeSend: function(){
			},
			success: function ( response ) {
				if(response.timeforms == 1){
					var affected_count = response.pending_forms_count;
					var affected = 'forms';
				}else if(response.performance == 1){
					var affected_count = response.pending_performance_count;
					var affected = 'performance planning/appraisal';
				}else if(response.change_request == 1){
					var affected_count = response.pending_change_request_count;
					var affected = 'change requests';
				}else if(response.mrf == 1){
					var affected_count = response.pending_mrf_count;
					var affected = 'manpower requests';
				}else if(response.erequest == 1){
					var affected_count = response.pending_erequest_count;
					var affected = 'online requests';
				}else if(response.ir == 1){
					var affected_count = response.pending_ir_count;
					var affected = 'incident reports';
				}else if(response.amp == 1){
					var affected_count = response.pending_amp_count;
					var affected = 'Manpower Planning';
				}				
				if(affected_count == 0){
					_delete_signatory( sig_id );
				}else{
					bootbox.confirm("There are "+affected_count+" "+affected+" affected.<br> Are you sure you want to delete selected record(s)?", function(confirm) {
						if( confirm )
						{
							_delete_signatory( sig_id );
						}
					});
				}
			}
		});
	}
	else{
		if( set_for == '' )
		{
			notify('warning', 'Please select an option to set firsts.');	
		}
	}
}

function _delete_signatory( records )
{
	var set_for = $('input[name="set_for"]').val();
	if( set_for != "" )
	{
		$.blockUI({ message: loading_message(), 
			onBlock: function(){
				$.ajax({
					url: base_url + module.get('route') + '/delete_signatory',
					type:"POST",
					data: {set_for: set_for, sig_id: records},
					dataType: "json",
					async: false,
					beforeSend: function(){
					},
					success: function ( response ) {
						handle_ajax_message( response.message );

	                    if( typeof (response.notified) != 'undefined' )
	                    {
	                        for(var i in response.notified)
	                        {
	                            socket.emit('get_push_data', {channel: 'get_user_'+response.notified[i]+'_notification', args: { broadcaster: user_id, notify: true }});
	                        }
	                    }

						get_signatory();
					}
				});
			}
		});
		$.unblockUI();
	}
	else{
		if( set_for == '' )
		{
			notify('warning', 'Please select an option to set firsts.');	
		}
	}
}

function _save_signatory()
{
	$.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_signatory',
				type:"POST",
				data: $('form#edit_signatory').serialize(),
				dataType: "json",
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					$('.modal-container').modal('hide');
					handle_ajax_message( response.message );

                    if( typeof (response.notified) != 'undefined' )
                    {
                        for(var i in response.notified)
                        {
                            socket.emit('get_push_data', {channel: 'get_user_'+response.notified[i]+'_notification', args: { broadcaster: user_id, notify: true }});
                        }
                    }

					get_signatory();
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();	
}


function save_signatory()
{	
	var set_for = $('input[name="set_for"]').val();
	var sig_id = $('input[name="id"]').val();
	var company_id = $('input[name="company_id"]').val();
	var department_id = $('input[name="department_id"]').val();
	var position_id = $('input[name="position_id"]').val();
	var user_id = $('input[name="user_id"]').val();
	var class_id = $('input[name="class_id"]').val();
	if( set_for != "" )
	{
		$.ajax({
			url: base_url + module.get('route') + '/count_affected_forms',
			type:"POST",
			data: {set_for: set_for, sig_id: sig_id, company_id: company_id, department_id: department_id, position_id: position_id, class_id: class_id, user_id: user_id},
			dataType: "json",
			async: false,
			beforeSend: function(){
			},
			success: function ( response ) {
				if(response.timeforms == 1){
					var affected_count = response.pending_forms_count;
					var affected = 'forms';
				}else if(response.performance == 1){
					var affected_count = response.pending_performance_count;
					var affected = 'performance planning/appraisal';
				}else if(response.change_request == 1){
					var affected_count = response.pending_change_request_count;
					var affected = 'change requests';
				}else if(response.mrf == 1){
					var affected_count = response.pending_mrf_count;
					var affected = 'manpower requests';
				}else if(response.erequest == 1){
					var affected_count = response.pending_erequest_count;
					var affected = 'online requests';
				}else if(response.ir == 1){
					var affected_count = response.pending_ir_count;
					var affected = 'incident reports';
				}else if(response.amp == 1){
					var affected_count = response.pending_amp_count;
					var affected = 'Manpower Planning';					
				}else if(response.mv == 1){
					var affected_count = response.pending_mv_count;
					var affected = 'movement';
				}

				if(affected_count == 0){
					_save_signatory( $('form#edit_signatory').serialize() );
				}else{
					bootbox.confirm("There are "+affected_count+ " "+affected+" affected.<br> Are you sure you want to continue saving?", function(confirm) {
						if( confirm )
						{
							_save_signatory( $('form#edit_signatory').serialize() );
						}
					});
				}
			}
		});
	}
	else{
		if( set_for == '' )
		{
			notify('warning', 'Please select an option to set firsts.');	
		}
	}
}