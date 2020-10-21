
$(document).ready(function(){
	UIExtendedModals.init();

	$('.select2me').select2({
	    placeholder: "Select an option",
	    allowClear: true
	});

	if (jQuery().datepicker) {
		$('.date-picker').datepicker({
			rtl: App.isRTL(),
			autoclose: true
		});
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal

    if( $('#recruitment-request_id').val() != "" )
    {
    	$('#recruitment_personal-position_sought option[mrf_id='+$('#recruitment-request_id').val()+']').attr('selected', 'selected');	
    }
    $('#recruitment_personal-position_sought').change(function(){
    	var mrf_id = $('#recruitment_personal-position_sought option:selected').attr('mrf_id');
    	$('#recruitment-request_id').val( mrf_id );
    });

}

	if (jQuery().datepicker) {
		$('#recruitment-recruitment_date').parent('.date-picker').datepicker({
			rtl: App.isRTL(),
			autoclose: true
		});
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}

	$('#recruitment_personal-photo-fileupload').fileupload({ 
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
			$('#recruitment_personal-photo-container .fileupload-preview').html(file.name);

		    $('#photo-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		    $('#photo-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
		    $('#recruitment_personal-photo').val(file.url);
		}
	}).bind('fileuploadfail', function (e, data) { 
		$.unblockUI();
		notify('error', data.errorThrown);
	});

	$('#photo-container .fileupload-delete').click(function(){
		$('#recruitment_personal-photo').val('');
		$('#recruitment_personal-photo-container .fileupload-preview').html('');
	    // $("#img-preview").attr('src', base_url + 'assets/img/avatar.png');
		$('#photo-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
		$('#photo-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
	});

	if( $('#recruitment_personal-photo').val() != "" )
	{
		$('#recruitment_personal-photo-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		$('#recruitment_personal-photo-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
	}

	$('#recruitment_personal-resume-fileupload').fileupload({ 
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
			$('#recruitment_personal-resume-container .fileupload-preview').html(file.name);

		    $('#resume-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		    $('#resume-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
		    $('#recruitment_personal-resume').val(file.url);
		}
	}).bind('fileuploadfail', function (e, data) { 
		$.unblockUI();
		notify('error', data.errorThrown);
	});

	$('#resume-container .fileupload-delete').click(function(){
		$('#recruitment_personal-resume').val('');
		$('#recruitment_personal-resume-container .fileupload-preview').html('');
	    // $("#img-preview").attr('src', base_url + 'assets/img/avatar.png');
		$('#resume-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
		$('#resume-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
	});

	if( $('#recruitment_personal-resume').val() != "" )
	{
		$('#recruitment_personal-resume-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
		$('#recruitment_personal-resume-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
	}

	if($('#record_id').val() >0){
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
	}

	$('#partners-emp_status_id').change(function(){
		if($(this).find(':selected').data('active') == 0){
			$('.resigned_date').removeClass('hidden');
		}else{
			$('.resigned_date').addClass('hidden');
		}
	});

	$('#recruitment_personal-solo_parent-temp').change(function(){
	    if( $(this).is(':checked') )
	        $('#recruitment_personal-solo_parent').val('1');
	    else
	        $('#recruitment_personal-solo_parent').val('0');
	});
	$('label[for="recruitment_personal-solo_parent-temp"]').css('margin-top', '0');

	$('#recruitment_personal-currently_employed-temp').change(function(){
	    if( $(this).is(':checked') )
	        $('#recruitment_personal-currently_employed').val('1');
	    else
	        $('#recruitment_personal-currently_employed').val('0');
	});
	$('label[for="recruitment_personal-currently_employed-temp"]').css('margin-top', '0');
	
	$('#recruitment_personal-same_as_present_address-temp').change(function(){
	    if( $(this).is(':checked') ){
	        $('#recruitment_personal-same_as_present_address').val('1');
	        copy_present_to_permanent(1);
	    }
	    else{
	        $('#recruitment_personal-same_as_present_address').val('0');
	        copy_present_to_permanent(0);
	    }
	});
	$('label[for="recruitment_personal-same_as_present_address-temp"]').css('margin-top', '0');

	$('#recruitment_personal-cert_member_to_trade-temp').change(function(){
	    if( $(this).is(':checked') ){
	        $('#recruitment_personal-cert_member_to_trade').val('1');
	        copy_present_to_permanent(1);
	    }
	    else{
	        $('#recruitment_personal-cert_member_to_trade').val('0');
	        copy_present_to_permanent(0);
	    }
	});
	$('label[for="recruitment_personal-cert_member_to_trade-temp"]').css('margin-top', '0');

	$('#recruitment_personal-previously_employed_at_hdi-temp').change(function(){
	    if( $(this).is(':checked') ){
	        $('#recruitment_personal-previously_employed_at_hdi').val('1');
	        copy_present_to_permanent(1);
	    }
	    else{
	        $('#recruitment_personal-previously_employed_at_hdi').val('0');
	        copy_present_to_permanent(0);
	    }
	});
	$('label[for="recruitment_personal-previously_employed_at_hdi-temp"]').css('margin-top', '0');
	
	$('#recruitment_personal-physical_disabilities-temp').change(function(){
	    if( $(this).is(':checked') ){
	        $('#recruitment_personal-physical_disabilities').val('1');
	        copy_present_to_permanent(1);
	    }
	    else{
	        $('#recruitment_personal-physical_disabilities').val('0');
	        copy_present_to_permanent(0);
	    }
	});
	$('label[for="recruitment_personal-physical_disabilities-temp"]').css('margin-top', '0');
	
	$('#recruitment_personal-illness_injuries-temp').change(function(){
	    if( $(this).is(':checked') ){
	        $('#recruitment_personal-illness_injuries').val('1');
	        copy_present_to_permanent(1);
	    }
	    else{
	        $('#recruitment_personal-illness_injuries').val('0');
	        copy_present_to_permanent(0);
	    }
	});
	$('label[for="recruitment_personal-illness_injuries-temp"]').css('margin-top', '0');
	
	$('#recruitment_personal-illness_compensated-temp').change(function(){
	    if( $(this).is(':checked') ){
	        $('#recruitment_personal-illness_compensated').val('1');
	        copy_present_to_permanent(1);
	    }
	    else{
	        $('#recruitment_personal-illness_compensated').val('0');
	        copy_present_to_permanent(0);
	    }
	});
	$('label[for="recruitment_personal-illness_compensated-temp"]').css('margin-top', '0');
	
	$('#recruitment_personal-willing_to_relocate-temp').change(function(){
	    if( $(this).is(':checked') ){
	        $('#recruitment_personal-willing_to_relocate').val('1');
	        copy_present_to_permanent(1);
	    }
	    else{
	        $('#recruitment_personal-willing_to_relocate').val('0');
	        copy_present_to_permanent(0);
	    }
	});
	$('label[for="recruitment_personal-willing_to_relocate-temp"]').css('margin-top', '0');
	$('#recruitment_personal-driver_license-temp').change(function(){
	    if( $(this).is(':checked') )
	        $('#recruitment_personal-driver_license').val('1');
	    else
	        $('#recruitment_personal-driver_license').val('0');
	});
	$('label[for="recruitment_personal-driver_license-temp"]').css('margin-top', '0');

	$('#recruitment_personal-prc_license-temp').change(function(){
	    if( $(this).is(':checked') )
	        $('#recruitment_personal-prc_license').val('1');
	    else
	        $('#recruitment_personal-prc_license').val('0');
	});
	$('label[for="recruitment_personal-prc_license-temp"]').css('margin-top', '0');

	$('#recruitment_personal-illness_question-temp').change(function(){
	    if( $(this).is(':checked') )
	        $('#recruitment_personal-illness_question').val('1');
	    else
	        $('#recruitment_personal-illness_question').val('0');
	});
	$('label[for="recruitment_personal-illness_question-temp"]').css('margin-top', '0');	

});

function copy_present_to_permanent(same_as_present) {
	if(same_as_present){
		$('#recruitment_personal-permanent_add_no').val($('#recruitment_personal-presentadd_no').val());
		$('#recruitment_personal-permanent_address_1').val($('#recruitment_personal-address_1').val());
		$('#recruitment_personal-permanent_add_village').val($('#recruitment_personal-presentadd_village').val());
		$('#recruitment_personal-permanent_address_2').val($('#recruitment_personal-address_2').val());
		$('#recruitment_personal-permanent_town').val($('#recruitment_personal-town').val());
		$('#recruitment_personal-permanent_city_town').val($('#recruitment_personal-city_town').val());
		$('#recruitment_personal-permanent_province').val($('#recruitment_personal-province').val());
		$('#recruitment_personal-permanent_country').val($('#recruitment_personal-country').val());
		$('#recruitment_personal-permanent_zipcode').val($('#recruitment_personal-zip_code').val());	
	}else{
		$('#recruitment_personal-permanent_add_no').val("");
		$('#recruitment_personal-permanent_address_1').val("");
		$('#recruitment_personal-permanent_add_village').val("");
		$('#recruitment_personal-permanent_address_2').val("");
		$('#recruitment_personal-permanent_town').val("");
		$('#recruitment_personal-permanent_city_town').val("");
		$('#recruitment_personal-permanent_province').val("");
		$('#recruitment_personal-permanent_country').val("");
		$('#recruitment_personal-permanent_zipcode').val("");
	}
}

function _calculateAge(birthday, count) { // birthday is a date
	dateString = birthday.value;

	var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
	$( "#recruitment_personal_history-family-age"+count ).val(age);
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
		console.log(count);
		console.log(counting);
		console.log(mode);
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
		var span_delete_add = '<a class="btn btn-default action_'+mode+'" id="delete_'+mode+'-'+counting+'" onclick="remove_form(this.id, \''+mode+'\')" ><i class="fa fa-trash-o"></i></a>';
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
/*				$('.select2me').select2({
				    placeholder: "Select an option",
				    allowClear: true
				});*/				
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
	$('#recruitment_personal_history-education-status-undergraduate-'+count_educ).attr('checked', false);
	$('#recruitment_personal_history-education-status-undergraduate-'+count_educ).parent().removeClass();
	$('#recruitment_personal_history-education-lastsem-attended-'+count_educ).parent().parent().addClass('hidden');
}else{
	$('#recruitment_personal_history-education-status-graduate-'+count_educ).attr('checked', false);
	$('#recruitment_personal_history-education-status-graduate-'+count_educ).parent().removeClass();
	$('#recruitment_personal_history-education-lastsem-attended-'+count_educ).parent().parent().removeClass('hidden');
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
					var add_app = 0;
					
					handle_ajax_message( response.message );

					if(response.saved )
					{
						$('.modal-container-partners').modal('hide');

						if(response.action == 'insert' || $('#is_add').val() == 1){
							$(".personalTab").removeClass("active");
							$(".personalPane").removeClass("active");

			                bootbox.dialog({
			                	closeButton: false,
			                    message: "The Applicant has been added to the list. <br>Click Next button to complete the applicants profile.",
			                    title: "Applicant Save",
			                    buttons: {
			                      success: {
			                        label: "Next",
			                        className: "green",
			                        callback: function() {
										if(response.fgs_number == 4){
											$(".historicalFam").attr("data-toggle","tab");
											$(".historicalFam").attr("href","#overview_tab14");
											$(".historical").attr("data-toggle","tab");
											$(".historical").attr("href","#profile_tab_2");
											$(".famTab").addClass("active");
											$("#overview_tab14").addClass("active");
										}else{
											var next_fgs = parseInt(response.fgs_number) + 1;
											var next_tab = parseInt(response.fgs_number) + 2;
											$(".recruitTab"+next_fgs).addClass("active");
											$("#overview_tab"+next_tab).addClass("active");
											$("#recruitTab"+next_fgs).attr("data-toggle","tab");
											$("#recruitTab"+next_fgs).attr("href","#overview_tab"+next_tab);
										}
										$('#is_add').val(1);
										add_app = 1;
			                        }
			                      },
			                      danger: {
			                        label: "Edit Later",
			                        className: "default",
			                        callback: function() {
			                          document.location = base_url + module.get('route')
			                        }
			                      }
			                    }
			                });
						}

						if(partner_id == 12 || partner_id == 13){
							var div_list = partner_id == 12 ? 'accountabilities-list' : 'attachment-list';
							$.ajax({
								url: base_url + module.get('route') + '/account_attach_list',
								type:"POST",
								async: false,
								data: 'record_id='+response.record_id + '&partner_id=' + partner_id,
								dataType: "json",
								success: function ( response ) {
									$('#'+div_list).html();
						  			$('#'+div_list).hide().html(response.lists).fadeIn('fast');
								}
							});
						}
						else if(partner_id >= 1 && partner_id <= 4){
							$.ajax({
								url: base_url + module.get('route') + '/get_overview_details',
								type:"POST",
								async: false,
								data: 'record_id='+response.record_id + '&partner_id=' + partner_id,
								dataType: "json",
								success: function ( response ) {
									$('#profile_header_overview').html();
						  			$('#profile_header_overview').hide().html(response.lists).fadeIn('fast');
								}
							});

							if(add_app == 1 || $('#is_add').val() == 1){
								$('#is_add').val(1);
							}
						}
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
