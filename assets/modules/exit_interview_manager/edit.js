
$(document).ready(function(){

	// $("#resources_request-notify_others").select2("destroy");
    $('#partners_clearance_exit_interview_layout-department_id').select2({
        placeholder: "Select users",
        allowClear: true
    });

	$('#partners_clearance_exit_interview_layout-default-temp').change(function(){
	    if( $(this).is(':checked') )
	        $('#partners_clearance_exit_interview_layout-default').val('1');
	    else
	        $('#partners_clearance_exit_interview_layout-default').val('0');
	});

	if($('#record_id').val() > 0){
		get_signatories( $('#record_id').val()  )
	}

    $('#partners_clearance_exit_interview_layout_item-wiht_yes_no-temp').live('change',function(){
        if( $(this).is(':checked') )
            $('#partners_clearance_exit_interview_layout_item-wiht_yes_no').val('1');
        else
            $('#partners_clearance_exit_interview_layout_item-wiht_yes_no').val('0');
    });

});	
    
function save_record( form, action, callback )
{
	$.blockUI({ message: saving_message(),
		onBlock: function(){

			var hasCKItem = form.find("textarea.ckeditor");

			if(hasCKItem && (typeof editor != 'undefined')){
				
				for ( instance in CKEDITOR.instances )
        			CKEDITOR.instances[instance].updateElement();
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
							$('.sign_remarks').removeClass( 'hidden');

						if (typeof(after_save) == typeof(Function)) after_save( response );
						if (typeof(callback) == typeof(Function)) callback( response );

						switch( action )
						{
							case 'new':
								document.location = base_url + module.get('route') + '/add';
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

function add_sign( sign_id )
{
	var record_id = $('#record_id').val();
	$.ajax({
	    url: base_url + module.get('route') + '/add_sign',
	    type: "POST",
	    async: false,
	    data: 'sign_id='+sign_id + '&record_id='+record_id,
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
	        	$('.modal-signatories').html(response.sign);
				$('.modal-signatories').modal();

	        	/*$('#greetings_dialog').html(response.greetings);
				$('#greetings_dialog').modal('show');	*/            
	        }
	        handle_ajax_message( response.message );
	    }
	});
}

function add_sign_sub( exit_interview_layout_item_id,exit_interview_layout_item_sub_id )
{
	var record_id = $('#record_id').val();
	$.ajax({
	    url: base_url + module.get('route') + '/add_sign_sub',
	    type: "POST",
	    async: false,
	    data: 'exit_interview_layout_item_id='+exit_interview_layout_item_id + '&exit_interview_layout_item_sub_id='+exit_interview_layout_item_sub_id,
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
	        	$('.modal-signatories').html(response.sign);
				$('.modal-signatories').modal();

	        	/*$('#greetings_dialog').html(response.greetings);
				$('#greetings_dialog').modal('show');	*/            
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
						
						get_signatories( $('#record_id').val() );
						if (typeof(after_save) == typeof(Function)) after_save( response );
						if (typeof(callback) == typeof(Function)) callback( response );

						switch( action )
						{
							case 'new':
								document.location = base_url + module.get('route') + '/add';
								break;
						}

						$('.modal-signatories').modal('hide');
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}

function save_sub_sign( form, action, callback )
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
				url: base_url + module.get('route') + '/save_sub_sign',
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
						
						get_signatories( $('#record_id').val() );
						if (typeof(after_save) == typeof(Function)) after_save( response );
						if (typeof(callback) == typeof(Function)) callback( response );

						switch( action )
						{
							case 'new':
								document.location = base_url + module.get('route') + '/add';
								break;
						}

						$('.modal-signatories').modal('hide');
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}

function get_signatories( layout_id )
{
	$.ajax({
	    url: base_url + module.get('route') + '/get_signatories',
	    type: "POST",
	    async: false,
	    data: 'exit_interview_layout_id='+layout_id,
	    dataType: "json",
	    success: function (response) {
	        $.unblockUI();

	        if (typeof (response.signatory) != 'undefined') {
	        	$('#signatories').html('');
	        	$('#signatories').append(response.signatory);

	        	/*$('#greetings_dialog').html(response.greetings);
				$('#greetings_dialog').modal('show');	*/            
	        }
	        handle_ajax_message( response.message );
	    }
	});
}

function delete_signatories( record_id, callback )
{
	bootbox.confirm(lang.confirm.delete_single, function(confirm) {
		if( confirm )
		{
			_delete_signatories( record_id, callback );
		} 
	});
}

function _delete_signatories( records, callback )
{
	$.ajax({
		url: base_url + module.get('route') + '/delete_signatories',
		type:"POST",
		data: 'records='+records,
		dataType: "json",
		async: false,
		beforeSend: function(){
			$('body').modalmanager('loading');
		},
		success: function ( response ) {
			$('body').modalmanager('removeLoading');
			handle_ajax_message( response.message );
			get_signatories( $('#record_id').val() );
			// $('.modal-signatories').modal('hide');
		}
	});
}

function delete_sub_question( record_id, callback )
{
	bootbox.confirm(lang.confirm.delete_single, function(confirm) {
		if( confirm )
		{
			_delete_sub_question( record_id, callback );
		} 
	});
}

function _delete_sub_question( records, callback )
{
	$.ajax({
		url: base_url + module.get('route') + '/delete_sub_question',
		type:"POST",
		data: 'records='+records,
		dataType: "json",
		async: false,
		beforeSend: function(){
			$('body').modalmanager('loading');
		},
		success: function ( response ) {
			$('body').modalmanager('removeLoading');
			handle_ajax_message( response.message );
			get_signatories( $('#record_id').val() );
			// $('.modal-signatories').modal('hide');
		}
	});
}