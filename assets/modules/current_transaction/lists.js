$(document).ready(function(){
	init_red();
});

function init_red()
{
	$('.red-filter').stop().click(function(){
		$('.red-filter').removeClass('label-info');
		$('.red-filter').addClass('label-default');
		$(this).removeClass('label-default');
		$(this).addClass('label-info');
		var user_id = $(this).attr('value');
		create_list();
	});

	$('.company-filter').stop().click(function(){
		$('.company_id').addClass('label-default');		
		$('.company_id').removeClass('label-info');
		$('.company_id').removeClass('company_id');	
		$(this).removeClass('label-default');			
		$(this).addClass('label-info');
		$(this).addClass('company_id');
		create_list();
	});	
}

function create_list()
{
	var search = $('input[name="list-search"]').val();
	var filter_by = $('.list-filter.active').attr('filter_by');
	var filter_value = $('.list-filter.active').attr('filter_value');

	filter_by = {
		period_processing_type_id: $('.list-filter.active').attr('filter_value'),
		employee_id: $('.red-filter.label-info').attr('value'),
		ww_payroll_current_transaction__company_id: $('.company-filter.company_id').attr('value'),
	}

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

function recompute_all()
{
	bootbox.confirm("Are you sure you want to recompute all records?", function(confirm) {
		if( confirm )
		{
			$.ajax({
				url: base_url + module.get('route') + '/recompute_all',
				type:"POST",
				dataType: "json",
				async: false,
				beforeSend: function(){
					$('body').modalmanager('loading');
				},
				success: function ( response ) {
					$('body').modalmanager('removeLoading');
					handle_ajax_message( response.message );
					location.reload();
				}
			});
		} 
	});
}