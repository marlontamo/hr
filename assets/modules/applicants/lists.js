$(document).ready(function(e) { 
	if (jQuery().infiniteScroll){
		create_list();

		$('form#list-search').submit(function( event ) {
			event.preventDefault();
			create_list();
		});	
	}

	
	$('.filter-source').click(function(){
		$('.filter-source').removeClass('label-success');
		$('.filter-source').addClass('label-default');
		$(this).removeClass('label-default');
		$(this).addClass('label-success')
		create_list();
	});
	$('.filter-status').click(function(){
		$('.filter-status').removeClass('label-success');
		$('.filter-status').addClass('label-default');
		$(this).removeClass('label-default');
		$(this).addClass('label-success')
		create_list();
	});
	$('.filter-post').click(function(){
		$('.filter-post').removeClass('label-success');
		$('.filter-post').addClass('label-default');
		$(this).removeClass('label-default');
		$(this).addClass('label-success')
		create_list();
	});

});

function print_jo (process_id)
{
	var data = {
		process_id:process_id
		}
	$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/print_jo',
				type:"POST",
				async: false,
				data: $('form[name="jo-form"]').serialize(),
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

function print_bi (process_id)
{
	var data = {
		process_id:process_id
		}
	$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/print_bi',
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

function print_interview (process_id)
{
	var data = {
		process_id:process_id
		}
	$.blockUI({ message: '<div>Loading, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/print_interview',
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

function history( process_id, user_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/get_history',
				type:"POST",
				dataType: "json",
				data: {process_id:process_id, user_id:user_id},
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( typeof response.history != 'undefined' )
					{
						$('.modal-container').attr('data-width', '900');
						$('.modal-container').html(response.history);
						$('.modal-container').modal();
						if ($('.wysihtml5').size() > 0) {
							$('.wysihtml5').wysihtml5({
								"stylesheets": ["assets/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
							});
						
							$('input[name="_wysihtml5_mode"]').addClass('dontserializeme');
						}							
						// init_datepicker();
						// init_searchabledd();
					}
				}
			});
		}
	});
	$.unblockUI();
}

function view_interview_result( schedule_id, route )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + route + '/view_interview_result',
				type:"POST",
				dataType: "json",
				data: {schedule_id:schedule_id},
				async: false,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( typeof response.interview_form != 'undefined' )
					{
						$('.modal-extra').attr('data-width', '900');
						$('.modal-extra').html(response.interview_form);
						$('.modal-extra').modal();
					}
				}
			});
		},
		baseZ: 999999999
	});
	$.unblockUI();	
}

function create_list()
{
	var search = $('input[name="list-search"]').val();
	var filter_by = {
		source_id: $('.filter-source.label-success').attr('filter_value'),
		status_id: $('.filter-status.label-success').attr('filter_value'),
		mrf_status: $('.filter-post.label-success').attr('filter_value'),
	}
	var filter_value = $('.list-filter.active').attr('filter_value');
	
	// console.log(filter_by);
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

function ajax_export( record_id, lastname )
{
	$.blockUI({ message: '<div>'+lang.common.processing_message+'</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				// {{ get_mod_route('report_generator') }}
				url: base_url + module.get('route') +'/export_pdf_application_info_sheet',
				type:"POST",
				dataType: "json",
				data:'record_id='+record_id+'&lastname='+lastname,
				async: false,
				success: function ( response ) {
					if( response.filename != undefined )
					{
						window.open( root_url + response.filename );
					}
					handle_ajax_message( response.message );
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();	
}