$(document).ready(function(){
	if( $('#record_id').val() != '' )
	{
		get_fg_list( $('#record_id').val() );
		get_f_list( $('#record_id').val() );
	}

	$('#active-temp').change(function(){
		if( $(this).is(':checked') )
			$('#active').val('1');
		else
			$('#active').val('0');
	});
});

function get_fg_list( mod_id )
{
	$.ajax({
		url: base_url + module.get('route') + '/get_fg_list',
		type:"POST",
		async: false,
		data: 'mod_id='+mod_id,
		dataType: "json",
		success: function ( response ) {
			if( typeof response.fgs != 'undefined' ){
				$('#field-group-list').html(response.fgs);
				App.initUniform('.fg-checker');
			}
		}
	});
}

function get_f_list( mod_id )
{
	$.ajax({
		url: base_url + module.get('route') + '/get_f_list',
		type:"POST",
		async: false,
		data: 'mod_id='+mod_id,
		dataType: "json",
		success: function ( response ) {
			if( typeof response.fields != 'undefined' ){
				$('#field-list').html(response.fields);
				App.initUniform('.fg-checker');
			}
		}
	});
}

function edit_fg( fg_id )
{
	var mod_id = $('#record_id').val();

	if( mod_id == '' )
	{
		notify('warning', 'Cannot add field groups yet.');
		return false;
	}

	$.ajax({
		url: base_url + module.get('route') + '/edit_fg',
		type:"POST",
		async: false,
		data: 'mod_id='+mod_id+'&fg_id='+fg_id,
		dataType: "json",
		beforeSend: function(){
			$('body').modalmanager('loading');
		},
		success: function ( response ) {
			if( typeof(response.edit_fg_form) != 'undefined' )
			{
				$('.modal-container').html(response.edit_fg_form);
				$('.modal-container').modal();
				$('.make-switch').not(".has-switch")['bootstrapSwitch']();
			}

			handle_ajax_message( response.message );

		}
	});	
}

function edit_field( f_id )
{
	var mod_id = $('#record_id').val();

	if( mod_id == '' )
	{
		notify('warning', 'Cannot add fields yet.');
		return false;
	}

	$.ajax({
		url: base_url + module.get('route') + '/edit_field',
		type:"POST",
		async: false,
		data: 'mod_id='+mod_id+'&f_id='+f_id,
		dataType: "json",
		beforeSend: function(){
			$('body').modalmanager('loading');
		},
		success: function ( response ) {
			$('body').modalmanager('removeLoading');
			if( typeof(response.edit_field_form) != 'undefined' )
			{
				$('.modal-container').html(response.edit_field_form);
				$('.modal-container').modal();
				$('.make-switch').not(".has-switch")['bootstrapSwitch']();
			}

			handle_ajax_message( response.message );

		}
	});	
}

function save_mod_fg( fg )
{
	fg.submit( function(e){ e.preventDefault(); } );
	var save_url = fg.attr('action');
	var data = fg.find(":not('.dontserializeme')").serialize()
	$.ajax({
		url: save_url,
		type:"POST",
		async: false,
		data: data,
		dataType: "json",
		beforeSend: function(){
			$('form#edit-fg-form').block({ message: '<div>Saving Field Group, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />' });
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

function save_mod_field( form )
{
	form.submit( function(e){ e.preventDefault(); } );
	var save_url = form.attr('action');
	var data = form.find(":not('.dontserializeme')").serialize()
	$.ajax({
		url: save_url,
		type:"POST",
		async: false,
		data: data,
		dataType: "json",
		beforeSend: function(){
			$('form#edit-field-form').block({ message: '<div>Saving Field, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />' });
		},
		success: function ( response ) {
			$('form#edit-field-form').unblock();
			
			if( typeof response.fg_id != 'undefiend' )
			{
				$('form#edit-field-form input[name="f_id"]').val( response.f_id );
			}

			handle_ajax_message( response.message );

			if(response.saved )
			{
				$('.modal-container').modal('hide');
				get_f_list( $('#record_id').val() );
			}
		}
	});
}

function delete_fgs()
{
	var fgs = new Array();
	var fg_ctr = 0;
	$('.fg-checker').each(function(){
		if( $(this).is(':checked') )
		{
			fgs[fg_ctr] = $(this).val();
			fg_ctr++;
		}
	});

	if( fg_ctr == 0 )
	{
		notify('warning', 'Nothing selected');
		return;
	}

	fgs = fgs.join(',');

	bootbox.confirm("Are you sure you want to delete selected field group(s)?", function(confirm) {
		if( confirm )
		{
			_delete_fg( fgs )
		}
	});
}

function delete_fg( fg_id )
{
	bootbox.confirm("Are you sure you want to delete this field group?", function(confirm) {
		if( confirm )
		{
			_delete_fg( fg_id );
		}
	});
}

function _delete_fg( fgs )
{
	var mod_id = $('#record_id').val();

	$.ajax({
		url: base_url + 'admin/field_groups/delete',
		type:"POST",
		async: false,
		data: 'mod_id='+mod_id+'&fgs='+fgs,
		dataType: "json",
		beforeSend: function(){
			$('body').modalmanager('loading');
		},
		success: function ( response ) {
			get_fg_list( $('#record_id').val() );
			$('body').modalmanager('removeLoading');

			handle_ajax_message( response.message );
		}
	});	
}

function delete_fields()
{
	var fields = new Array();
	var field_ctr = 0;
	$('.field-checker').each(function(){
		if( $(this).is(':checked') )
		{
			fields[field_ctr] = $(this).val();
			field_ctr++;
		}
	});

	if( field_ctr == 0 )
	{
		notify('warning', 'Nothing selected');
		return;
	}

	fields = fields.join(',');

	bootbox.confirm("Are you sure you want to delete selected field(s)?", function(confirm) {
		if( confirm )
		{
			_delete_field( fields )
		}
	});
}

function _delete_field( fields )
{
	var mod_id = $('#record_id').val();

	$.ajax({
		url: base_url + 'admin/fields/delete',
		type:"POST",
		async: false,
		data: 'mod_id='+mod_id+'&fields='+fields,
		dataType: "json",
		beforeSend: function(){
			$('body').modalmanager('loading');
		},
		success: function ( response ) {
			get_f_list( $('#record_id').val() );
			$('body').modalmanager('removeLoading');

			handle_ajax_message( response.message );
		}
	});	
}