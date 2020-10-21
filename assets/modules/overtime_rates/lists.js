$(document).ready(function(e) { 

	if (jQuery().infiniteScroll){
		if($('select[name="company_id"]').val() > 0){	
			$("#select_company").hide();
			create_list();

			$('form#list-search').submit(function( event ) {
				event.preventDefault();
				create_list();
			});	
		}else{
			$('#record-table').hide();
			$("#select_company").show();
		}
	}

	$('select[name="company_id"]').change(function(){
		if($(this).val() > 0){	
			$("#select_company").hide();
			$('#record-table').show();

			if($("span.label-success").data('record-id') > 0){
				create_list('period', $("span.label-success").data('record-id'));
			}else if($("span.label-success").data('month-value')){
				create_list('month', $("span.label-success").data('month-value'));
			}else{
				create_list();
			}
		}else{
			$('#record-table').hide();
			$("#select_company").show();
		}
	});
});

function create_list(filter_by, filter_value)
{
	var search = $('input[name="list-search"]').val();
	required_filter = '?company='+$('select[name="company_id"]').val();
	
	$('#record-list').empty().die().infiniteScroll({
		dataPath: base_url + module.get('route') + '/get_list'+required_filter,
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
