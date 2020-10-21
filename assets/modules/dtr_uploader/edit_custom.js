$(document).ready(function(e) { 
	if (jQuery().infiniteScroll){
		try {
	        create_list();
	    }
	    catch(error) {
	        // override?
	        console.log(error)
	    }


		$('form#list-search').submit(function( event ) {
			event.preventDefault();
			create_list();
		});	
	}

	$('.list-filter').click(function(){
		$('.list-filter').removeClass('active');
		$('.list-filter').children('i').addClass('fa-square-o');
		$(this).addClass('active');
		$(this).children('i').removeClass('fa-square-o');
		$(this).children('i').addClass('fa-check-square-o');

		create_list();
	});

	$('.form-filter').click(function(){
	    $('.form-filter').each(function(){
	        if( $(this).hasClass('label-info') ){
	            $(this).removeClass('label-info').addClass('label-default');
	        }
	    });

	    /** start - for status filter **/
	    var filter_value = $(this).data('filter_value');
	   //var filter_value = $('.list-filter.active').attr('filter_value');
	    /** end - for status filter **/
	    if( $(this).hasClass('option') == true ){

	        $('.form-filter').each(function(){
	            if( !$(this).hasClass('option') && form_id == $(this).data('form-id') ){
	                $(this).removeClass('label-default').addClass('label-info');
	            }
	        });
	    }
	    else{
	        $(this).removeClass('label-default').addClass('label-info');
	    }

	   $('#record-list').empty();
	   $('#record-list').empty().die().infiniteScroll({
			dataPath: base_url + module.get('route') + '/get_list',
			itemSelector: 'tr.record',
			onDataLoading: function(){ 
				$("#loader").show();
				$("#no_record").hide();
			},
			onDataLoaded: function(page, records){ 
				$("#loader").hide();
				if( page == 0 && records == 0)
				{
					$("#no_record").show();
				}
			},
			onDataError: function(){ 
				return;
			},
			search: $('input[name="list-search"]').val(),
	        filter_value: filter_value 
		});
	});

});

function create_list()
{
	var search = $('input[name="list-search"]').val();
	var filter_by = $('.list-filter.active').attr('filter_by');
	var filter_value = $('.list-filter.active').attr('filter_value');
	
	$('#record-list').empty().die().infiniteScroll({
		dataPath: base_url + module.get('route') + '/get_list',
		itemSelector: 'tr.record',
		onDataLoading: function(){ 
			$("#loader").show();
			$("#no_record").hide();
		},
		onDataLoaded: function(page, records){ 
			$("#loader").hide();
			if( page == 0 && records == 0)
			{
				$("#no_record").show();
			}
		},
		onDataError: function(){ 
			return;
		},
		search: search,
		filter_by: filter_by,
		filter_value: filter_value
	});
}

function delete_records()
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
		notify('warning', lang.alert.noselected);
		return;
	}

	records = records.join(',');

	bootbox.confirm(lang.confirm.delete_multi, function(confirm) {
		if( confirm )
		{
			_delete_record( records )
		}
	});
}

function delete_record( record_id, callback )
{
	bootbox.confirm(lang.confirm.delete_single, function(confirm) {
		if( confirm )
		{
			_delete_record( record_id, callback );
		} 
	});
}

function _delete_record( records, callback )
{
	$.ajax({
		url: base_url + module.get('route') + '/delete',
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

			if (typeof(callback) == typeof(Function))
				callback();
			else
				$('#record-list').infiniteScroll('search');
		}
	});
}

function view_trash()
{
	$('#record-list').infiniteScroll('trash');
}

function refresh_list()
{
	if ( $.fn.infiniteScroll )
	{
		$('#record-list').infiniteScroll('search');
		$('.modal-container').modal('hide');
	}
}

function restore_record( record_id )
{
	bootbox.confirm(lang.confirm.restore, function(confirm) {
		if( confirm )
		{
			_restore_record( record_id );
		} 
	});
}

function _restore_record( records, callback )
{
	$.ajax({
		url: base_url + module.get('route') + '/restore',
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

			if (typeof(callback) == typeof(Function))
				callback();
			else
				$('#record-list').infiniteScroll('search');
		}
	});
}

function mod_import( mod_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/get_import_form',
				type:"POST",
				async: false,
				data: 'mod_id='+mod_id,
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( typeof(response.import_form) != 'undefined' )
					{
						$('.modal-container').attr('data-width', '700');
						$('.modal-container').html(response.import_form);
						$('.modal-container').modal();

						init_import_form();
					}
				}
			});
		}
	});
	$.unblockUI();
}

function init_import_form()
{
	$('#template-fileupload').fileupload({
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
			$('#template').val(file.url);
			$('#template-container .fileupload-preview').html(file.name);
			$('#template-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
			$('#template-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
		}
	}).bind('fileuploadfail', function (e, data) {
		$.unblockUI();
		console.log(data);
		notify('error', data.errorThrown);
	});


	$('#template_id').change(function(){
		if( $(this).val() != "" )
		{
			load_template( $(this).val() )
		}
	});

	$('#template-container .fileupload-delete').click(function(){
		$('#template').val('');
		$('#template-container .fileupload-preview').html('');
		$('#template-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
		$('#template-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
	});
}


function start_import(validate)
{	
	var go = 1; 
	if( $('#template_id').val() == "" )
	{
		$('#summary-tab').hide();
		go = 0;
		notify('warning', lang.alert.choose_template )
		return;
	}
	if( $('#template').val() == "" )
	{
		$('#summary-tab').hide();
		go = 0;
		notify('warning', lang.alert.missing_file )
		return;
	}

	if(go == 1){
		$('ul li:gt(1)').show();
		$('#summary-tab').removeClass('hidden');
		$('#import-tab').removeClass('active');
		$('#import').removeClass('active in');
		$('#summary').addClass('active in');
		$('.nav-tabs a[href="#summary"]').tab('show');
	}
	$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/validate_import/'+validate,
				type:"POST",
				data: $('form[name="import-form"]').serialize(),
				dataType: "json",
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );

					$('#valid_count').html(response.valid_count);
					$('#error_count').html(response.error_count);
					$('#error_details').html(response.error_details);
					$('div .valid_log #total_rows').html(response.rows);
					$('div .error_log #total_rows').html(response.rows);
					if( response.valid_count > 0 )
						$('.valid_log').removeClass('hidden');
						
					if( response.valid_count == 0 || response.error_count > 0)
						$('.error_log').removeClass('hidden');

					if( response.error_count == 0 )
						$('.error_log').addClass('hidden');
				}
			});
		},
		baseZ: 20000,
	});
	$.unblockUI();
}


function download_template() {
    $('form[name="import-form"]').attr('target', '_blank');
    $('form[name="import-form"]').attr('action', base_url + module.get('route') + '/download_template');
    $('form[name="import-form"]').trigger('submit');
    $('form[name="import-form"]').attr('target', '_self'); 
}

function cancel_upload() {
	$('#import-tab').addClass('active');
	$('#summary-tab').addClass('hidden');
	$('#summary').removeClass('active in');
	$('#import').addClass('active in');
}