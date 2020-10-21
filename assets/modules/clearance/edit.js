$(document).ready(function(){

    $('#partners_clearance-exit_interview_layout_id').change(function(){
    	get_exit_interview_template( $(this).val(), $('#record_id').val() );
    });

	$('#partners_clearance-clearance_layout_id').change(function(){
		get_clearance_template( $(this).val(), $('#record_id').val());
	});

	if (jQuery().datepicker) {
	    $('.date-picker').datepicker({
	        rtl: App.isRTL(),
	        autoclose: true
	    });
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}
	
/*	if ($('#partners_clearance-clearance_layout_id').val() && $('#partners_clearance-clearance_layout_id').val() > 0){
		get_clearance_template($('#partners_clearance-clearance_layout_id').val(), $('#record_id').val());
	}*/

	$('select.select2me').select2({
        placeholder: "Select",
        allowClear: true
    });

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

    $('.partners_clearance_exit_interview_layout_item-wiht_yes_no-temp').live('change',function(){
        if( $(this).is(':checked') ){
        	$(this).parent().parent().find('#partners_clearance_exit_interview_layout_item-wiht_yes_no').val('1');
        }
        else{
        	$(this).parent().parent().find('#partners_clearance_exit_interview_layout_item-wiht_yes_no').val('5');
        }
    });    
});

function get_clearance_template( layout_id, clearance_id )
{
	if (!layout_id){
		return true;
	}

	$.ajax({
	    url: base_url + module.get('route') + '/get_clearance_template',
	    type: "POST",
	    async: false,
	    data: 'clearance_layout_id='+layout_id +'&clearance_id='+clearance_id,
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

	        if (typeof (response.signatory) != 'undefined') {
	        	$('#signatories').html('');
	        	$('#signatories').append(response.signatory);

				$('select.select2me').select2({
			        placeholder: "Select",
			        allowClear: true
			    });

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
			    			    
	        	/*$('#greetings_dialog').html(response.greetings);
				$('#greetings_dialog').modal('show');	*/            
	        }
	        handle_ajax_message( response.message );
	    }
	});
}

function get_signatories( layout_id, clearance_id, change_layout )
{
	if(change_layout == 1){
		bootbox.confirm('Are you sure you want to change signatories layout?', function(confirm) {
			if( confirm )
			{
				_get_signatories( layout_id, clearance_id, change_layout );
			} 
		});
	}else{
		_get_signatories( layout_id, clearance_id, change_layout );
	}
}

function _get_signatories( layout_id, clearance_id, change_layout )
{
	$.ajax({
	    url: base_url + module.get('route') + '/get_signatories',
	    type: "POST",
	    async: false,
	    data: 'clearance_layout_id='+layout_id +'&clearance_id='+clearance_id +'&change_layout='+change_layout,
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

function delete_signatories( elem, callback )
{
	bootbox.confirm(lang.confirm.delete_single, function(confirm) {
		if( confirm )
		{
			/*_delete_signatories( record_id, callback );*/
			$(elem).closest('.panel-info').remove();
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
			get_signatories( $('select[name="partners_clearance_layout[clearance_layout_id]"]').val(), $('#record_id').val(), 0 );
			// $('.modal-container').modal('hide');
		}
	});
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
	        	$('.modal-container').html(response.sign);
				$('.modal-container').modal();

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
				data: data+'&status_id='+action,
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
							default:
								document.location = base_url + module.get('route');
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

function save_signatory( form, action, callback )
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
				url: base_url + module.get('route') + '/save_signatory',
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
   
function send_sign( form, action, callback )
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
				url: base_url + module.get('route') + '/send_sign',
				type:"POST",
				data: data+'&status_id='+action,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( response.saved )
					{
						if( response.action == 'insert' )
							$('#record_id').val( response.record_id );
						
						switch( action )
						{
							case 'new':
							case 2:
								document.location = base_url + module.get('route') ;
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

/* 
* exit interview
*/


function get_exit_interview( layout_id, clearance_id, change_layout )
{
	if(change_layout == 1){
		bootbox.confirm('Are you sure you want to change questionnaire layout?', function(confirm) {
			if( confirm )
			{
				_get_exit_interview( layout_id, clearance_id, change_layout );
			} 
		});
	}else{
		_get_exit_interview( layout_id, clearance_id, change_layout );
	}
}

function _get_exit_interview( layout_id, clearance_id, change_layout )
{
	$.ajax({
	    url: base_url + module.get('route') + '/get_exit_interview',
	    type: "POST",
	    async: false,
	    data: 'exit_interview_layout_id='+layout_id +'&clearance_id='+clearance_id +'&change_layout='+change_layout,
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

function get_exit_interview_template( layout_id, clearance_id, change_layout )
{
	$.ajax({
	    url: base_url + module.get('route') + '/get_exit_interview_base_template',
	    type: "POST",
	    async: false,
	    data: 'exit_interview_layout_id='+layout_id +'&clearance_id='+clearance_id,
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

function delete_item( elem, callback )
{
	bootbox.confirm(lang.confirm.delete_single, function(confirm) {
		if( confirm )
		{
			//_delete_items( record_id, callback );
			$(elem).closest('.panel-info').remove();
		} 
	});
}

function delete_sub_question( elem, callback )
{
	bootbox.confirm(lang.confirm.delete_single, function(confirm) {
		if( confirm )
		{
			//_delete_items( record_id, callback );
			$(elem).closest('tr').remove();
		} 
	});
}

function _delete_items( records, callback )
{
	$.ajax({
		url: base_url + module.get('route') + '/delete_item',
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
			get_exit_interview( $('select[name="partners_clearance[exit_interview_layout_id]"]').val(), $('#record_id').val(), 0 );
			// $('.modal-container').modal('hide');
		}
	});
}

function add_item( exit_interview_answers_id )
{
	var record_id = $('#record_id').val();
	$.ajax({
	    url: base_url + module.get('route') + '/add_item',
	    type: "POST",
	    async: false,
	    data: 'exit_interview_answers_id='+exit_interview_answers_id + '&record_id='+record_id,
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
	        	$('.modal-container').html(response.sign);
				$('.modal-container').modal();

	        	/*$('#greetings_dialog').html(response.greetings);
				$('#greetings_dialog').modal('show');	*/            
	        }
	        handle_ajax_message( response.message );
	    }
	});
}

function edit_item( elem,item )
{
	var record_id = $('#record_id').val();
	$.ajax({
	    url: base_url + module.get('route') + '/add_item',
	    type: "POST",
	    async: false,
	    data: 'exit_interview_answers_id='+exit_interview_answers_id + '&record_id='+record_id,
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
	        	$('.modal-container').html(response.sign);
				$('.modal-container').modal();

	        	/*$('#greetings_dialog').html(response.greetings);
				$('#greetings_dialog').modal('show');	*/            
	        }
	        handle_ajax_message( response.message );
	    }
	});
}

// new function : Tirso Garcia
function append_item( form, action, callback )
{
	var item = $('#partners_clearance_exit_interview_answers-item').val();
	var clearance_id = $('#record_id').val();
	var exit_interview_layout_id = $('#partners_clearance-exit_interview_layout_id').val();
	var exit_interview_layout_item_id = $('#partners_clearance-exit_interview_layout_item_id').val();
	var count = $('.panel-info').length;

	$.ajax({
	    url: base_url + module.get('route') + '/get_exit_interview_base_template',
	    type: "POST",
	    async: false,
	    data: 'item='+item+'&template_only=1&clearance_id='+clearance_id+'&exit_interview_layout_id='+exit_interview_layout_id+'&count='+count+'&exit_interview_layout_item_id='+exit_interview_layout_item_id,
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

	        if (typeof (response.signatory) != 'undefined') {
	        	$('#signatories').append(response.signatory);        
	        }
	        handle_ajax_message( response.message );
	        $('.modal-container').modal('hide');
	    }
	});

	$.unblockUI();
}

function save_item( form, action, callback )
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
				url: base_url + module.get('route') + '/save_item',
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
						
						get_exit_interview( $('select[name="partners_clearance[exit_interview_layout_id]"]').val(), $('#record_id').val(), 0 );
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
    
function save_exit_interview( form, action, callback )
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
				url: base_url + module.get('route') + '/save_exit_interview',
				type:"POST",
				data: data+'&status_id='+action,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( response.saved )
					{
						if( response.action == 'insert' )
							$('#record_id').val( response.record_id );
						
						switch( action )
						{
							case 'new':
							case 2:
								document.location = base_url + module.get('route') ;
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

function add_account_from_201( element,key )
{
	var div = element.parents('td').find('.accountability');
	var sel = element.parents('td').find('#accountabilities');
	var text = $(sel).children(':selected').text();

	if ($(".act"+key+"").filter(function( index ) { return $(this).val().toLowerCase() == text.toLowerCase() }).length > 0) {
  		notify('error', 'Accountabilities already exists');
  		return true;
	}

	$(sel).children(':selected').remove();	

	var html = '<div>' +
			   '<br>' +
			   '<span class="pull-right small text-muted">' +
		       '<a style="cursor:pointer" class="pull-right small text-muted" onclick="delete_account(this)">delete</a>' +
		       '</span><br>' +      
		       '<input type="text" class="form-control act'+key+'" name="partners_clearance_signatories_accountabilities['+ key +'][accountability][]" value="'+text+'">' +
		       '</div>';
	div.append(html);
}


function add_account( element, key )
{
	var div = element.parents('td').find('.accountability');
	$.ajax({
	    url: base_url + module.get('route') + '/add_account',
	    type: "POST",
	    async: false,
	    // data: 'sign_id='+sign_id + '&record_id='+record_id,
	    data: 'key='+key,
	    dataType: "json",
	    success: function (response) {
	        $.unblockUI();

	        if (typeof (response.accountability) != 'undefined') {
	        	div.append(response.accountability);
	        }
	        handle_ajax_message( response.message );
	    }
	});
}

function delete_account( record )
{
	$(record).parent().parent().remove();
}

function print_exit_interview (record_id)
{
    var data = {
        record_id:record_id
        }
    $.blockUI({ message: '<div>Loading, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/print_exit_interview',
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

function print_clearance_form (record_id)
{
    var data = {
        record_id:record_id
        }
    $.blockUI({ message: '<div>Loading, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/print_clearance_form',
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

function print_release_quitclaim (record_id)
{
    var data = {
        record_id:record_id
        }
    $.blockUI({ message: '<div>Loading, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/print_release_quitclaim',
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

function print_coe (record_id)
{
    var data = {
        record_id:record_id
        }
    $.blockUI({ message: '<div>Loading, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/print_coe',
                type:"POST",
                async: false,
                data: data,
                dataType: "json",
                success: function ( response ) {
                	console.log( response );
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