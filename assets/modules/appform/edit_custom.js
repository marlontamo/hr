$(document).ready(function(){
	// UIExtendedModals.init();

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

    if( $('#recruitment-request_id').val() != "" )
    {
    	$('#recruitment_personal-position_sought option[mrf_id='+$('#recruitment-request_id').val()+']').attr('selected', 'selected');	
    }
    $('#recruitment_personal-position_sought').change(function(){
    	var mrf_id = $('#recruitment_personal-position_sought option:selected').attr('mrf_id');
    	$('#recruitment-request_id').val( mrf_id );
    });
});

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

function save_partner( partner )
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
				url: base_url + module.get('route') + '/save',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					$('#record_id').val( response.record_id );
					
					handle_ajax_message( response.message );
					
					if(response.saved)
					{
						msg = "You have been successfully added to our applicant list.";
						$(".general_div").hide(); $(".contacts_div").hide(); $(".btn_div").hide();
						$(".message_app_div").show();
						$( "p:last" ).html( msg );
						$(".btn_close").show();
						$(".btn_close").click(function(){
							$('#form-1').trigger("reset");
							self.location.reload();
						});	
					}
					else if(response.duplicate)
					{
						msg = "We have already seen your information on our list.";
						$(".general_div").hide();
						$(".contacts_div").hide();
						$(".btn_div").hide();
						$(".message_app_div").show();
						$( "p:last" ).html( msg );
						$(".btn_close").removeClass('btn-success'); $(".btn_close").addClass('btn-danger');
						$(".btn_close").show();
						$(".btn_close").click(function(){
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
