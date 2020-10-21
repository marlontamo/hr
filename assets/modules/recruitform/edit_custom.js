$(document).ready(function(){
	UIExtendedModals.init();
	
	if (jQuery().inputmask){
		$(".mask_number").inputmask('decimal', {
	        groupSeparator: ",", 
	        digits: 2,
	        autoGroup: true,
	        numericInput: true,
	        rightAlignNumerics: false
        
        });

        $(".mask_number_year").inputmask('decimal', {
	        numericInput: true,
	        rightAlignNumerics: false
        
        });

        $(".mask_number_contact").inputmask('decimal',{rightAlignNumerics: false});
	}

    $('#recruitment_personal-position_sought').change(function(){
    	var mrf_id = $('#recruitment_personal-position_sought option:selected').attr('mrf_id');
    	$('#recruitment-request_id').val( mrf_id );
    });
    
	if (jQuery().datepicker) {
		$('.date-picker').datepicker({
			rtl: App.isRTL(),
			autoclose: true
		});
    	$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}

$('.number_spinner').spinner({value:'', min: 1});
	if (jQuery().datepicker) {
		$('#recruitment-recruitment_date').parent('.date-picker').datepicker({
			rtl: App.isRTL(),
			autoclose: true
		});
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}

	// if (jQuery().datepicker) {
	// 	$('#recruitment-birth_date').parent('.date-picker').datepicker({
	// 		maxDate: '-18Y',
	// 		yearRange: "-20:+0",
	// 		rtl: App.isRTL(),
	// 		autoclose: true
	// 	});
	//     $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	// }

	$('#recruitment_personal-photo-fileupload').fileupload({ 
		url: base_url + module.get('route') + '/single_upload',
		autoUpload: true,
		contentType: false,
	}).bind('fileuploadadd', function (e, data) {
		$.blockUI({ message: '<div>Attaching file, please wait...</div><img src="'+base_url+'assets/img/ajax-loading.gif" />' });
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
		$.blockUI({ message: '<div>Attaching file, please wait...</div><img src="'+base_url+'assets/img/ajax-loading.gif" />' });
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
	
	showNextbuttons($('#current_page').val());

	$('select.form-select').select2();

	$(".pagination").text(parseInt($('#current_page').val()) + " of 13 pages");

    $('#recruitment-lastname').on('keyup', function() {
    	var lastname = $(this).val();
    	var firstname = $('#recruitment-firstname').val();
    	var bday = $('#recruitment-birth_date').val();
    	if(lastname != '' && firstname != ''  && bday != '' ){
        	check_duplicate(lastname, firstname, bday);
    	}
    });

    $('#recruitment-firstname').on('keyup', function() {
    	var firstname = $(this).val();
    	var lastname = $('#recruitment-lastname').val();
    	var bday = $('#recruitment-birth_date').val();
    	if(lastname != '' && firstname != ''  && bday != '' ){
        	check_duplicate(lastname, firstname, bday);
    	}
    });

    $('#recruitment-birth_date').change(function(){
    // $('#recruitment-birth_date').on('keyup', function() {
    	var bday = $(this).val();
    	var firstname = $('#recruitment-firstname').val();
    	var lastname = $('#recruitment-lastname').val();
    	if(lastname != '' && firstname != ''  && bday != '' ){
        	check_duplicate(lastname, firstname, bday);
    	}
    });

});


function check_duplicate( lastname, firstname, bday )
{
	// partner.submit( function(e){ e.preventDefault(); } );
	// var partner_id = $('#current_page').val()
	// var data = partner.find(":not('.dontserializeme')").serialize();
	var data = {
		lastname: lastname, 
		firstname: firstname, 
		bday: bday
	}
	if( $('#duplicate_checker').val() == 0 ){
		$.ajax({
			url: base_url + module.get('route') + '/check_duplicate',
			type:"POST",
			data: data,
			dataType: "json",
			async: false,
			success: function ( response ) {
				if (response){
					if (response.duplicate_count > 0){
						$('#duplicate_checker').val(1);
		                bootbox.dialog({
		                	width: 450,
	    					size: 'small',
		                    message: "We got same record using your first name, last name and birth date. " +
								"<br>Kindly contact HR to proceed on your application.",
		                    title: "Duplicate Entry",
		                    buttons: {
		                      main: {
		                        label: "OK",
		                        className: "blue",
		                        callback: function() {
									$('#duplicate_checker').val(0);
	      							location.href = base_url + module.get('route');
		                        }
		                      }
		                    }
		                });
					}
				}
			}
		});
	}
}

function showNextbuttons(current_page){
	if(current_page > 1){
		$(".backbutton").removeClass("hidden");
	}else{
		$(".backbutton").addClass("hidden");
	}

	if(current_page > 12){
		$(".nextbutton").addClass("hidden");
		$(".submit_button").removeClass("hidden");
	}else{
		$(".nextbutton").removeClass("hidden");
		$(".submit_button").addClass("hidden");
	}
}

function next_back(mode, form){
	var paginate = "";
	if(mode != 'back'){
		var currentPage = parseInt($('#current_page').val()) + 1;
	    validate_data(function(d) {
	        //processing the data
			if(d == 0){
				
				$("#recform-"+$('#current_page').val()).addClass("hidden");
				$("#recform-"+currentPage).removeClass("hidden");
				$('#current_page').val(currentPage);
				showNextbuttons($('#current_page').val());
				$('html, body').animate({ scrollTop: 0 }, 'fast');
			}
	    }, form);
	    var paginate = currentPage + " of 13 pages";
	}else{
        //processing the data
		var previousPage = parseInt($('#current_page').val()) - 1;
		$("#recform-"+$('#current_page').val()).addClass("hidden");
		$("#recform-"+previousPage).removeClass("hidden");
		$('#current_page').val(previousPage);
		showNextbuttons($('#current_page').val());
		$('html, body').animate({ scrollTop: 0 }, 'fast');	
		var paginate = previousPage + " of 11 pages";			
	}
	$(".pagination").text(paginate);
}


function handle_ajax_message( message )
{
	for( var i in message ){
		if(message[i].message != "") notify(message[i].type, message[i].message);
	}
}

function notify(type, msg, title, callback){
	toastr.options = {
		closeButton: true,
		debug: false,
		showDuration: 1000,
		hideDuration: 1000,
		timeOut:  3000,
		extendedTimeOut: 500,
		showEasing: 'swing',
		hideEasing: 'swing',
		showMethod: 'fadeIn',
		hideMethod: 'fadeOut',
		positionClass: 'toast-bottom-right',
	};

	if( typeof( callback ) == 'function' ){
		toastr.options.onclick = callback;
	}

	var $toast = toastr[type](msg, title);
}


function validate_data( callback, partner )
{
	partner.submit( function(e){ e.preventDefault(); } );
	var partner_id = $('#current_page').val()
	var data = partner.find(":not('.dontserializeme')").serialize();
	data = data + '&record_id=' + $('#record_id').val()+ '&fgs_number=' + partner_id;
	$.ajax({
		url: base_url + module.get('route') + '/validate_data',
		type:"POST",
		data: data,
		dataType: "json",
		async: false,
		success: function ( response ) {			
			if (!response){
         		if(typeof callback === "function") callback(0);
			}else{
				$('#record_id').val( response.record_id );

				handle_ajax_message( response.message );
				
         		if(typeof callback === "function") callback(response.message.length);
			}
		}
	});
}

function save_partner( partner )
{
	partner.submit( function(e){ e.preventDefault(); } );
	$.blockUI({ message: "Trying to save, please wait...", 
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
						msg = "You have been successfully added to our applicant list.";
						$(".recform").hide(); $(".recform_button").hide();
						$(".message_app_div").show();
						$( "p:last" ).html( msg );
						$(".btn_close").show();
						$(".btn_close").click(function(){
							$('.modal-container-partners').modal('hide');

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

							$('#form-1').trigger("reset");
							self.location.reload();
						});

						
					}
				}
			});
		}
	});
	$.unblockUI();	
    // location.reload();
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
				if (jQuery().inputmask){
					$(".mask_number").inputmask('decimal', {
				        groupSeparator: ",", 
				        digits: 2,
				        autoGroup: true,
				        numericInput: true,
				        rightAlignNumerics: false
			        
			        });

			        $(".mask_number_year").inputmask('decimal', {
				        numericInput: true,
				        rightAlignNumerics: false
			        
			        });

			        $(".mask_number_contact").inputmask('decimal',{rightAlignNumerics: false});
				}

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
		}else{
			$('#recruitment_personal_history-education-status-graduate-'+count_educ).attr('checked', false);
			$('#recruitment_personal_history-education-status-graduate-'+count_educ).parent().removeClass();
		}
	}
}
