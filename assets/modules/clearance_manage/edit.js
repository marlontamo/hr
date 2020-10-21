$(document).ready(function(){

	if (jQuery().datepicker) {
	    $('.date-picker').datepicker({
	        rtl: App.isRTL(),
	        autoclose: true
	    });
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}
	
	$('select.select2me').select2();

	$('.clearace_signatories-attachments-fileupload').fileupload({
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
	    	$(this).closest('.fileupload').find('#clearace_signatories-attachments').val(file.url);
	    	$(this).closest('.fileupload').find('.fileupload-preview').html(file.name);
	    	$(this).closest('.fileupload').find('.fileupload-new').each(function(){ $(this).css('display', 'none') });
	    	$(this).closest('.fileupload').find('.fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
	    }
	}).bind('fileuploadfail', function (e, data) {
		$.unblockUI();
		notify('error', data.errorThrown);
	});

	$('.fileupload-delete').click(function(){
		$(this).closest('.fileupload').find('#clearace_signatories-attachments').val('');
		$(this).closest('.fileupload').find('.fileupload-preview').html('');
		$(this).closest('.fileupload').find('.fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
		$(this).closest('.fileupload').find('.fileupload-exists').each(function(){ $(this).css('display', 'none') });
	});

    $('.clearace_signatories-attachments-fileupload').each(function () {
        if( $(this).closest('.fileupload').find('#clearace_signatories-attachments').val() != "" ){
			$(this).closest('.fileupload').find('.fileupload-new').each(function(){ $(this).css('display', 'none') });
			$(this).closest('.fileupload').find('.fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
        }
    });
});


function delete_account( record )
{
	$(record).parent().parent().remove();
}


function add_account( sign_id )
{
	$.ajax({
	    url: base_url + module.get('route') + '/add_account',
	    type: "POST",
	    async: false,
	    // data: 'sign_id='+sign_id + '&record_id='+record_id,
	    dataType: "json",
	    success: function (response) {
	        $.unblockUI();

	        if (typeof (response.accountability) != 'undefined') {
	        	$('.accountability').append(response.accountability);
	        }
	        handle_ajax_message( response.message );
	    }
	});
}

    
function save_sign( form, action, callback )
{
	$.blockUI({ message: saving_message(),
		onBlock: function(){

			var hasCKItem = form.find("textarea.ckeditor");

			if(hasCKItem && (typeof editor != 'undefined')){
				
				for ( instance in CKEDITOR.instances )
        			CKEDITOR.instances[instance].updateElement();
			}

			var data = form.find(":not('.dontserializeme')").serialize();
			// console.log(data);
			$.ajax({
				url: base_url + module.get('route') + '/save_sign',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( response.saved )
					{
						if( response.action == 'insert' )
							// $('#record_id').val( response.record_id );
							$('.sign_remarks').removeClass( 'hidden');
						
						get_signatories( $('select[name="partners_clearance_layout[clearance_layout_id]"]').val(), $('#record_id').val(), 0 );
						if (typeof(after_save) == typeof(Function)) after_save( response );
						if (typeof(callback) == typeof(Function)) callback( response );

						switch( action )
						{
							case 'new':
								document.location = base_url + module.get('route') + '/add';
								break;
						}

						$('.modal-container').modal('hide');
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}