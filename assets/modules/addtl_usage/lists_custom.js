function create_list()
{
	var search = $('input[name="list-search"]').val();
	filter_by = new Array();
	filter_value = new Array();

	filter_by[0] = 'form_id';
	filter_by[1] = 'year';

	filter_value[filter_by[0]] = $('input[name="'+filter_by[0]+'"]').val();
	filter_value[filter_by[1]] = $('input[name="'+filter_by[1]+'"]').val();


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
		filter: filter_value
	});
}