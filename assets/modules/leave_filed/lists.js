

function create_list()
{
	var search = $('input[name="list-search"]').val();
	filter_by = new Array();
	filter_value = new Array();


	filter_by[0] = 'tf.form_id';
	// filter_by[1] = 'YEAR(tf.date_from)';
	filter_by[1] = 'YEAR(tfb.period_from)';

	filter_value[0] = $('input[name="form_id"]').val();
	// filter_value[1] = $('input[name="year"]').val();
	filter_value[1] = $('input[name="year"]').val();

// console.log(filter_by);
// console.log(filter_value);
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

