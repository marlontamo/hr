
$(document).ready(function(){
	UIExtendedModals.init();


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
	    $("#img-preview").attr('src', base_url + file.url);
	    $('#photo-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
	    $('#photo-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
	    $('#users_profile-photo').val(file.url);
	}
}).bind('fileuploadfail', function (e, data) { 
	// console.log('fail');
	$.unblockUI();
	notify('error', data.errorThrown);
});


$('#photo-container .fileupload-delete').click(function(){
	$('#users_profile-photo').val('');
	// $('#users_profile-photo-container .photo-display').html('');
	// $(this).attr("src", src);
    $("#img-preview").attr('src', base_url + 'assets/img/avatar.png');
	$('#photo-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
	$('#photo-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
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

			if (typeof(callback) == typeof(Function))
				callback();
			else
				$('#record-list').infiniteScroll('search');
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

		}
	});	
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
			data = data + '&record_id=' + $('#record_id').val()+ '&fgs_number=' + partner_id;
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
		async: false,
		data: data,
		dataType: "json",
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
