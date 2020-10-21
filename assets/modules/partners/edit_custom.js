
$(document).ready(function(){

	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        // save the latest tab; use cookies if you like 'em better:
        localStorage.setItem('lastTab', $(this).attr('href'));
    });

    // go to the latest tab, if it exists:
    var lastTab = localStorage.getItem('lastTab');
    if (lastTab) {
        $('[href="' + lastTab + '"]').tab('show');
    }

	$('#modal_global_id').on('hidden', function () {
		window.location.reload();
	});

	//UIExtendedModals.init();
	$('#users_profile-reports_to_id').select2({
		placeholder: "Select an option",
		allowClear: true
	});
	$('#users_profile-department_id').select2({
		placeholder: "Select an option",
		allowClear: true
	});
	$('#users_profile-group_id').select2({
		placeholder: "Select an option",
		allowClear: true
	});
	$('#users_profile-division_id').select2({
		placeholder: "Select an option",
		allowClear: true
	});
	$('#users_department-immediate_id').select2({
		placeholder: "Select an option",
		allowClear: true
	});

	$('#users_profile-coordinator_id').select2({
	    placeholder: "Select coordinator",
	    allowClear: true
	});  

	$('#users_profile-credit_setup').select2({
	    placeholder: "Select credit setup",
	    allowClear: true
	});  

/*	$('#partners_personal-city_town').select2({
	    placeholder: "Select an option",
	    allowClear: true
	});

	$('#partners_personal-emergency_city').select2({
	    placeholder: "Select an option",
	    allowClear: true
	});*/

	if (jQuery().datepicker) {
		$('.date-picker').datepicker({
			rtl: App.isRTL(),
			autoclose: true
		});
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}

	if (jQuery().datepicker) {
		$('#partners-effectivity_date').parent('.date-picker').datepicker({
			rtl: App.isRTL(),
			autoclose: true
		});
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}
	if (jQuery().datepicker) {
		$('#partners_personal-probationary_date').parent('.date-picker').datepicker({
			rtl: App.isRTL(),
			autoclose: true
		});
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}
	if (jQuery().datepicker) {
		$('#partners_personal-original_date_hired').parent('.date-picker').datepicker({
			rtl: App.isRTL(),
			autoclose: true
		});
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}
	if (jQuery().datepicker) {
		$('#partners_personal-last_probationary').parent('.date-picker').datepicker({
			rtl: App.isRTL(),
			autoclose: true
		});
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}
	if (jQuery().datepicker) {
		$('#partners_personal-last_salary_adjustment').parent('.date-picker').datepicker({
			rtl: App.isRTL(),
			autoclose: true
		});
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}
	$('#partners-status_id').select2({
		placeholder: "Select an option",
		allowClear: true
	});
	$('#users_profile-location_id').select2({
		placeholder: "Select an option",
		allowClear: true
	});
	$('#users_profile-company').select2({
		placeholder: "Select an option",
		allowClear: true
	});
	$('#users_profile-position_id').select2({
		placeholder: "Select an option",
		allowClear: true
	});
	$('#partners-shift_id').select2({
		placeholder: "Select an option",
		allowClear: true
	});
	$('#users-role_id').select2({
		placeholder: "Select an option",
		allowClear: true
	});

	$('#users_profile-photo-fileupload').fileupload({ 
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
		    $('#users_profile-photo-container .fileupload-preview').html(file.name);
		    $('#photo-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		    $('#photo-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
		    $('#users_profile-photo').val(file.url);
		}
	}).bind('fileuploadfail', function (e, data) { 
		$.unblockUI();
		notify('error', data.errorThrown);
	});

	$('#photo-container .fileupload-delete').click(function(){
		$('#users_profile-photo').val('');
		$('#users_profile-photo-container .fileupload-preview').html('');
	    // $("#img-preview").attr('src', base_url + 'assets/img/avatar.png');
		$('#photo-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
		$('#photo-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
	});

	if( $('#users_profile-photo').val() != "" )
	{
		$('#users_profile-photo-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		$('#users_profile-photo-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
	}
	
        $('.exam_result').change(function(){
            if( $(this).is(':checked') ){
                $(this).parent().next().val(1);
            }
            else{
                $(this).parent().next().val(0);
            }
        });        
        $('label[for="partners_personal_history-test-result-temp"]').css('margin-top', '0');

        $('.test_attach').fileupload({ 
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
	            $(this).parent().parent().parent().children('span').children('span').children('span.fileupload-preview').html(file.name);
	            $(this).parent().children('span.fileupload-new').css('display', 'none');
	            $(this).parent().children('.fileupload-exists').css('display', 'inline-block');
	            $(this).parent().parent().children('.fileupload-delete').css('display', 'inline-block');
            	$(this).parent().parent().parent().parent().children('input:hidden:first').val(file.url);
            }
        }).bind('fileuploadfail', function (e, data) { 
            $.unblockUI();
            notify('error', data.errorThrown);
        });

        $('.fileupload-delete').click(function(){
            $(this).parent().parent().parent().children('input:hidden:first').val('');
            $(this).parent().parent().children('span').children('span').children('span.fileupload-preview').html('');
            $(this).parent().children('span.add_file').children('span.fileupload-new').css('display', 'inline-block');
            $(this).parent().children('span.add_file').children('span.fileupload-exists').css('display', 'none');
            $(this).css('display', 'none');

            // $('#users_profile-photo').val('');
            // $('#users_profile-photo-container .fileupload-preview').html('');
            // $("#img-preview").attr('src', base_url + 'assets/img/avatar.png');
            // $('#photo-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
            // $('#photo-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
        });

	$.ajax({
		url: base_url + module.get('route') + '/get_overview_details',
		type:"POST",
		async: false,
		data: 'record_id='+$('#record_id').val(),
		dataType: "json",
		success: function ( response ) {
			$('#profile_header_overview').html();
  			$('#profile_header_overview').hide().html(response.lists).fadeIn('fast');
		}
	});

	$('#partners-emp_status_id').change(function(){
		if($(this).find(':selected').data('active') == 0){
			$('.resigned_date').removeClass('hidden');
		}else{
			$('.resigned_date').addClass('hidden');
		}
	});

	if($('#partners-emp_status_id option:selected').attr('data-active') == 0){
		$('.resigned_date').removeClass('hidden');
	}else{
		$('.resigned_date').addClass('hidden');
	}

	$('#partners_personal-solo_parent-temp').change(function(){
	    if( $(this).is(':checked') )
	        $('#partners_personal-solo_parent').val('1');
	    else
	        $('#partners_personal-solo_parent').val('0');
	});
	$('label[for="partners_personal-solo_parent-temp"]').css('margin-top', '0');

	$('#partners_personal-home_leave-temp').change(function(){
	    if( $(this).is(':checked') )
	        $('#partners_personal-home_leave').val('1');
	    else
	        $('#partners_personal-home_leave').val('0');
	});
	$('label[for="partners_personal-home_leave-temp"]').css('margin-top', '0');
	
	$('#partners_personal_history-test-result-temp').change(function(){
	    if( $(this).is(':checked') )
	        $('#partners_personal_history-test-result').val('1');
	    else
	        $('#partners_personal_history-test-result').val('0');
	});
	$('label[for="partners_personal_history-test-result-temp"]').css('margin-top', '0');

	$('#partners_personal-with_parking-temp').change(function(){
	    if( $(this).is(':checked') )
	        $('#partners_personal-with_parking').val('1');
	    else
	        $('#partners_personal-with_parking').val('0');
	});
	$('label[for="partners_personal-with_parking-temp"]').css('margin-top', '0');

        $('.make-switch').not(".has-switch")['bootstrapSwitch']();
        $('label[for="partners_personal_history-family-dependent-temp"]').css('margin-top', '0');
	$('.dependent').change(function(){
	    if( $(this).is(':checked') ){
	    	$(this).parent().next().val(1);
	    }
	    else{
	    	$(this).parent().next().val(0);
	    }
	});

	$("[id^='partners_personal_history-cost_center-cost_center']").change(function(){

	    var id = $(this).attr("id")
		id = id.replace("partners_personal_history-cost_center-cost_center", "");
	    get_project_code($('#partners_personal_history-cost_center-cost_center'+id).val(), id);
	});

	$('#partners_personal_history-licensure-attach-fileupload').fileupload({
        url: base_url + module.get('route') + '/single_upload',
        autoUpload: true,
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
            $('#partners_personal_history-licensure-attach').val(file.url);
            $('#partners_personal_history-licensure-attach-container .fileupload-preview').html(file.name);
            $('#partners_personal_history-licensure-attach-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
            $('#partners_personal_history-licensure-attach-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
        }
    }).bind('fileuploadfail', function (e, data) {
        $.unblockUI();
        notify('error', data.errorThrown);
    });

    $('#partners_personal_history-licensure-attach-container .fileupload-delete').click(function(){
        $('#partners_personal_history-licensure-attach').val('');
        $('#partners_personal_history-licensure-attach-container .fileupload-preview').html('');
        $('#partners_personal_history-licensure-attach-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
        $('#partners_personal_history-licensure-attach-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
    });

    if( $('#partners_personal_history-licensure-attach').val() != "" )
    {
        $('#partners_personal_history-licensure-attach-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
        $('#partners_personal_history-licensure-attach-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
    }
});

function _calculateAge(birthday, count) { // birthday is a date
	dateString = birthday.value;

	var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
	$( "#partners_personal_history-family-age"+count ).val(age);
}

function delete_record( record_id, key_class, callback )
{
	bootbox.confirm("Are you sure you want to this record?", function(confirm) {
		if( confirm )
		{
			_delete_record( record_id, key_class, callback );
		} 
	});
}

function delete_records(key_class)
{
	var records = new Array();
	var record_ctr = 0;
	$('.record-checker').each(function(){
		if( $(this).is(':checked') )
		{
			records[record_ctr] = $(this).val();
			record_ctr++;
		}
	});

	if( record_ctr == 0 )
	{
		notify('warning', 'Nothing selected');
		return;
	}

	records = records.join(',');

	bootbox.confirm("Are you sure you want to delete selected record(s)?", function(confirm) {
		if( confirm )
		{
			_delete_record( records, key_class )
		}
	});
}

function _delete_record( records, key_class, callback )
{
	$.ajax({
		url: base_url + module.get('route') + '/delete',
		type:"POST",
		data: 'records='+records+'&key_class='+key_class+'&record_id='+$('#record_id').val(),
		dataType: "json",
		async: false,
		beforeSend: function(){
			$('body').modalmanager('loading');
		},
		success: function ( response ) {
			$('body').modalmanager('removeLoading');
			handle_ajax_message( response.message );

			var div_list = key_class == 'accountabilities' ? 'accountabilities-list' : 'attachment-list';
			var partner_id = key_class == 'accountabilities' ? 12 : 13;
			$.ajax({
				url: base_url + module.get('route') + '/account_attach_list',
				type:"POST",
				async: false,
				data: 'record_id='+$('#record_id').val() + '&partner_id=' + partner_id,
				dataType: "json",
				success: function ( response ) {
					$('#'+div_list).html();
		  			$('#'+div_list).hide().html(response.lists).fadeIn('fast');
		  			customHandleUniform();
				}
			});

			// if (typeof(callback) == typeof(Function))
			// 	callback();
			// else
			// 	$('#record-list').infiniteScroll('search');
		}
	});
}

function edit_personal_details(modal_form, key_class, sequence){	
	$.ajax({
		url: base_url + module.get('route') + '/view_personal_details',
		type:"POST",
		async: false,
		data: 'modal_form='+modal_form+'&key_class='+key_class+'&sequence='+sequence+'&record_id='+$('#record_id').val(),
		dataType: "json",
		beforeSend: function(){
					// $('body').modalmanager('loading');
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

					if( typeof(response.view_details) != 'undefined' )
					{	
						$('.modal-container-partners').html(response.view_details).modal();		
					}

				}
		});	
}

//remove phone
function remove_form(div_form, mode, tab){
	if(tab == 'history'){
		$('#'+div_form).parent().parent().parent().remove();
		var count = ($('#'+mode+'_count').val() - 1);
		$('#'+mode+'_count').val(count);
	}else{
		$('#'+div_form).parent().parent().remove();
		var count = ($('#'+mode+'_count').val() - 1);
		var counting = $('#'+mode+'_counting').val();
		if( count == 1 ){
			$('.action_'+mode).remove();
			var span_delete_add = '<a class="btn btn-default action_'+mode+' add_'+mode+'" id="add_'+mode+'" onclick="add_form(\'contact_'+mode+'\', \''+mode+'\')" ><i class="fa fa-plus"></i></a>';
			$('.add_delete_'+mode).append(span_delete_add);
		}else{
			$( "#personal_"+mode+" div.form-group:last-child span.add_delete_"+mode+":last-child a.add_"+mode ).remove();
			var span_delete_add = '<a class="btn btn-default action_'+mode+' add_'+mode+'" id="add_'+mode+'" onclick="add_form(\'contact_'+mode+'\', \''+mode+'\')" ><i class="fa fa-plus"></i></a>';			
			$( "#personal_"+mode+" div.form-group:last-child span.add_delete_"+mode+":last-child" ).append(span_delete_add);	
		}
		$('#'+mode+'_count').val(count);	
		var count_val = 1;
		var num = 1;
		while(counting >= num){
			if( $('#'+mode+'_display_count-'+num).length ) {
				if(count_val == 1){
					$('#'+mode+'_display_count-'+num).text('');
				}else{
					$('#'+mode+'_display_count-'+num).text(count_val);
				}
				count_val++;
			}
			num++;
		}
	}
}

//add phone 
function add_form(add_form, mode, sequence){
	var count = $('#'+mode+'_count').val();
	var counting = $('#'+mode+'_counting').val();
	var form_category = ( $('#'+mode+'_category').length ) ? $('#'+mode+'_category').val() : '';
	if( count == 1 ){
		$('.action_'+mode).remove();
		var span_delete_add = '<a class="btn btn-default action_"'+mode+' id="delete_'+mode+'-'+counting+'" onclick="remove_form(this.id, \''+mode+'\')" ><i class="fa fa-trash-o"></i></a>';
		$('.add_delete_'+mode).append(span_delete_add);
	}
	$.ajax({
		url: base_url + module.get('route') + '/add_form',
		type:"POST",
		async: false,
		data: 'add_form='+add_form+'&count='+count+'&category='+form_category+'&counting='+counting,
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
				$('#add_'+mode).remove();
				$('#'+mode+'_count').val(response.count);
				$('#'+mode+'_counting').val(response.counting);
				$('#personal_'+mode).append(response.add_form);
				// handleSelect2();
				FormComponents.init();
			}

			$("[id^='partners_personal_history-cost_center-cost_center']").change(function(){

				var id = $(this).attr("id")
				id = id.replace("partners_personal_history-cost_center-cost_center", "");
			    get_project_code($('#partners_personal_history-cost_center-cost_center'+id).val(), id);
			});
		}
	});	
}

var customHandleUniform = function () {
    if (!jQuery().uniform) {
        return;
    }

    var test = $("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle, .star)");
    if (test.size() > 0) {
        test.each(function () {
            if ($(this).parents(".checker").size() == 0) {
                $(this).show();
                $(this).uniform();
            }
        });
    }
}

//education graduate/undergrad checkbox
function check_graduate_status(grad_stat, count_educ){
	if(grad_stat.checked == true){
		if(grad_stat.value == 'Graduated'){
	// console.log();
	$('#partners_personal_history-education-status-undergraduate-'+count_educ).attr('checked', false);
	$('#partners_personal_history-education-status-undergraduate-'+count_educ).parent().removeClass();
}else{
	$('#partners_personal_history-education-status-graduate-'+count_educ).attr('checked', false);
	$('#partners_personal_history-education-status-graduate-'+count_educ).parent().removeClass();
}
}
}

function save_partner( partner )
{
	partner.submit( function(e){ e.preventDefault(); } );
	var user_id = $('#record_id').val();
	var partner_id = partner.attr('partner_id');
	$.blockUI({ message: saving_message(), 
		onBlock: function(){
			partner.submit( function(e){ e.preventDefault(); } );
			var partner_id = partner.attr('partner_id');
			var data = partner.find(":not('.dontserializeme')").serialize();
			data = data + '&record_id=' + $('#record_id').val()+ '&fgs_number=' + partner_id + '&rehire=' + $('input[name="rehire"]').val();
			$.ajax({
				url: base_url + module.get('route') + '/save',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					$('#record_id').val( response.record_id );

					handle_ajax_message( response.message );
					
					if(response.saved )
					{
						$('.modal-container-partners').modal('hide');
					}
					if(partner_id == 12 || partner_id == 13){
						var div_list = partner_id == 12 ? 'accountabilities-list' : 'attachment-list';
						$.ajax({
							url: base_url + module.get('route') + '/account_attach_list',
							type:"POST",
							async: false,
							data: 'record_id='+user_id + '&partner_id=' + partner_id,
							dataType: "json",
							success: function ( response ) {
								$('#'+div_list).html();
					  			$('#'+div_list).hide().html(response.lists).fadeIn('fast');
					  			customHandleUniform();
							}
						});
					}else if(partner_id >= 1 && partner_id <= 4){
						$.ajax({
							url: base_url + module.get('route') + '/get_overview_details',
							type:"POST",
							async: false,
							data: 'record_id='+user_id + '&partner_id=' + partner_id,
							dataType: "json",
							success: function ( response ) {
								$('#profile_header_overview').html();
					  			$('#profile_header_overview').hide().html(response.lists).fadeIn('fast');
							}
						});
					}
				}
			});
		}
	});
	$.unblockUI();	
    // location.reload();
}

function save_modal( fg )
{
	fg.submit( function(e){ e.preventDefault(); } );
	var save_url = fg.attr('action');
	var data = fg.find(":not('.dontserializeme')").serialize()
	$.ajax({
		url: base_url + module.get('route') + '/save',
		type:"POST",
		data: data,
		dataType: "json",
		async: false,
		beforeSend: function(){
			$('form#edit-fg-form').block({ message: '<div>Saving item, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />' });
		},
		success: function ( response ) {
			$('form#edit-fg-form').unblock();
			
			if( typeof response.fg_id != 'undefiend' )
			{
				$('form#edit-fg-form input[name="fg_id"]').val( response.fg_id );
			}

			handle_ajax_message( response.message );

			if(response.saved )
			{
				$('.modal-container').modal('hide');
				get_fg_list( $('#record_id').val() );
			}
		}
	});
}

function view_movement_details(action_id, type_id, cause){	
	var data = {
		type_id: type_id,
		action_id: action_id,
		cause: cause
	};
	
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
					// FormComponents.init();
				}

			}
	});	
}

function set_hidden_val( company_id, department_id, position_id, user_id, class_id )
{
	$('input[name="company_id"]').val( company_id );
	$('input[name="department_id"]').val( department_id );
	$('input[name="position_id"]').val( position_id );
	$('input[name="user_id"]').val( user_id );
	$('input[name="class_id"]').val( class_id );
}

function get_signatory()
{
	var set_for = $('input[name="set_for"]').val();
	var class_id = $('input[name="class_id"]').val();
	var company_id = $('input[name="company_id"]').val();
	var department_id = $('input[name="department_id"]').val();
	var position_id = $('input[name="position_id"]').val();
	var user_id = $('input[name="user_id"]').val();
	switch( set_for )
	{
		case "user":
			get_user_signatories( class_id, user_id, position_id, department_id, company_id );
			break;	
	}	
}

function get_user_signatories( class_id, user_id, position_id, department_id, company_id ){
	set_hidden_val(company_id, department_id, position_id, user_id, class_id);
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


function edit_signatory(class_id, set_for, company_id, department_id, position_id, user_id)
{

	var data = {
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
						$('.modal-container').attr('data-width', '900');
						$('.modal-container').modal();
						$('form#edit_signatory .make-switch').not(".has-switch")['bootstrapSwitch']();
						$('form#edit_signatory .select2me').select2({
						    placeholder: "Select an option",
						    allowClear: true
						});
					}

					get_signatory();
				}
			});
		}
	});
	$.unblockUI();

}

function edit_sign( sig_id, class_id )
{
	var set_for = $('input[name="set_for"]').val();
	if( set_for != "" )
	{
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
							$('.modal-container').attr('data-width', '900');
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
		get_signatory();
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
			url: base_url + 'signatories/count_affected_forms',
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
					url: base_url  + 'signatories/delete_signatory',
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
				url: base_url + 'signatories/save_signatory',
				type:"POST",
				data: $('form#edit_signatory').serialize(),
				dataType: "json",
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					// $('.modal-container').modal('hide');
					handle_ajax_message( response.message );

                    if( typeof (response.notified) != 'undefined' )
                    {
                        for(var i in response.notified)
                        {
                            socket.emit('get_push_data', {channel: 'get_user_'+response.notified[i]+'_notification', args: { broadcaster: user_id, notify: true }});
                        }
                    }
                   	
					get_signatory();
					// window.location.reload();
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();	
}

// function refresh_signatory_display()
// {
// 	var class_id = $('input[name="class_id"]').val();
// 	var company_id = $('input[name="company_id"]').val();
// 	var department_id = $('input[name="department_id"]').val();
// 	var position_id = $('input[name="position_id"]').val();
// 	var user_id = $('input[name="user_id"]').val();
// 	var data = {
// 		class_id: class_id,
// 		company_id: company_id,
// 		department_id: department_id,
// 		position_id: position_id,
// 		user_id: user_id
// 	};
// 	$.ajax({
// 		url: base_url + 'signatories/refresh_signatory_display',
// 		type:"POST",
// 		data: data,
// 		dataType: "json",
// 		async: false,
// 		beforeSend: function(){
// 		},
// 		success: function ( response ) {
// 			$('#'+class_id+'').text('');
// 			$.each(response, function (key, data) {
// 		        $('#'+class_id+'').append(
// 			    	'<p>'+data.alias+'<br><span class="italic text-success">('+data.sequence+'-'+data.condition+')</span></p>'
// 			    );
// 			});
// 		}
// 	});
// }

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
			url: base_url + 'signatories/count_affected_forms',
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
				}else if(response.mv == 1){
					var affected_count = response.pending_mv_count;
					var affected = 'movement reports';
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

function set_hidden_val_assign_all( company_id, department_id, position_id, user_id )
{
	$('input[name="company_id"]').val( company_id );
	$('input[name="department_id"]').val( department_id );
	$('input[name="position_id"]').val( position_id );
	$('input[name="user_id"]').val( user_id );
}

function get_assign_all()
{
	var set_for = $('input[name="set_for"]').val();
	var company_id = $('input[name="company_id"]').val();
	var department_id = $('input[name="department_id"]').val();
	var position_id = $('input[name="position_id"]').val();
	var user_id = $('input[name="user_id"]').val();
	switch( set_for )
	{
		case "user":
			get_users_signatories( user_id, position_id, department_id, company_id );
			break;	
	}	
}

function get_users_signatories( user_id, position_id, department_id, company_id ){
	set_hidden_val_assign_all(company_id, department_id, position_id, user_id);

	$('#signatory-listing').html('');
	$('#signatory-listing').block({ message: loading_message(),
		onBlock: function(){
			$('input[name="set_for"]').val("user");
			$('input[name="set_for_id"]').val(user_id);
			$.ajax({
				url: base_url + module.get('route') + '/get_users_signatories',
				type:"POST",
				data: { department_id: department_id, company_id: company_id, position_id: position_id, user_id: user_id},
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

function assign_all(set_for, company_id, department_id, position_id, user_id) 
{
	var data = {
		set_for: set_for,
		company_id: company_id,
		department_id: department_id,
		position_id: position_id,
		user_id: user_id
	};

	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/assign_all',
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
						$('.modal-container').attr('data-width', '900');
						$('.modal-container').modal();
						$('form#edit_assign_all .make-switch').not(".has-switch")['bootstrapSwitch']();
						$('form#edit_assign_all .select2me').select2({
						    placeholder: "Select an option",
						    allowClear: true
						});
					}
					get_assign_all();
				}
			});
		}
	});
	$.unblockUI();
}

function save_class_users()
{
	$.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + 'signatories/save_assign_all',
				type:"POST",
				data: $('form#edit_assign_all').serialize(),
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
                   	
					get_assign_all();

					// window.location.reload();
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();	
}

function edit_assign_all( set_for, company_id, department_id, position_id, user_id )
{
	var data = {
		set_for: set_for,
		company_id: company_id,
		department_id: department_id,
		position_id: position_id,
		user_id: user_id
	};

	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/assign_all',
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
						$('.modal-container').attr('data-width', '900');
						$('.modal-container').modal();
						$('form#edit_assign_all .make-switch').not(".has-switch")['bootstrapSwitch']();
						$('form#edit_assign_all .select2me').select2({
						    placeholder: "Select an option",
						    allowClear: true
						});
					}

					get_assign_all();
				}
			});
		}
	});
	$.unblockUI();
}

function edit_assign_all( sig_id, class_id )
{
	var set_for = $('input[name="set_for"]').val();
	if( set_for != "" )
	{
		var set_for_id = $('input[name="set_for_id"]').val();
		var company_id = $('input[name="company_id"]').val();
		var department_id = $('input[name="department_id"]').val();
		var position_id = $('input[name="position_id"]').val();
		var user_id = $('input[name="user_id"]').val();
		var data = {
			sig_id: sig_id,
			set_for: set_for,
			company_id: company_id,
			department_id: department_id,
			position_id: position_id,
			user_id: user_id
		};

		$.blockUI({ message: loading_message(), 
			onBlock: function(){
				$.ajax({
					url: base_url + module.get('route') + '/assign_all',
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
							$('.modal-container').attr('data-width', '900');
							$('.modal-container').modal();
							$('form#edit_assign_all .make-switch').not(".has-switch")['bootstrapSwitch']();
							$('form#edit_assign_all .select2me').select2({
							    placeholder: "Select an option",
							    allowClear: true
							});
						}
					}
				});
			}
		});
		get_assign_all();
		$.unblockUI();
	}
	else{
		if(set_for == '')
		{
			notify('warning', 'Please select an option to set firsts.');	
		}
	}
}

function push_to_class_users(rec_id)
{
	if ($('#signatories_checking').length > 0){
		var signatories = $('#signatories_checking').val();
		if (signatories == 0){
			notify('error', 'Pleas click "save" located on lower left side of this form then click again "Assign all" button.');
			return false;
		}
	}

	if(rec_id != ''){
		$.ajax({
			url: base_url + module.get('route') + '/push_to_class_users',
			type:"POST",
			data: {user_id:rec_id},
			dataType: "json",
			async: false,
			beforeSend: function(){
			},
			success: function ( response ) {
				$('.modal-container').modal('hide');
				handle_ajax_message( response.message );
			}
		});
	} else {
		notify('warning', 'Error saving signatories.');
	}
	
}

function delete_assign_all( records )
{
	var set_for = $('input[name="set_for"]').val();
	if( set_for != "" )
	{
		$.blockUI({ message: loading_message(), 
			onBlock: function(){
				$.ajax({
					url: base_url  + 'signatories/delete_assign_all',
					type:"POST",
					data: {set_for: set_for, sig_id: records},
					dataType: "json",
					async: false,
					beforeSend: function(){
					},
					success: function ( response ) {
						handle_ajax_message( response.message );

						get_assign_all();
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

function get_project_code(project_id, id){

	if(project_id != ''){

		$.ajax({
			url: base_url + module.get('route') + '/get_project_code',
			type:"POST",
			async: false,
			data: {project_id:project_id},
			dataType: "json",
			beforeSend: function(){
				// $('body').modalmanager('loading');
			},
			success: function ( response ) {
				
				$('#partners_personal_history-cost_center-code'+id).val(response.project_code);
			}
		});	
	}
}