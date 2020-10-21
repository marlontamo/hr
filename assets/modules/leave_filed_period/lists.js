

function create_list()
{
	var search = $('input[name="list-search"]').val();
	filter_by = new Array();
	filter_value = new Array();

	filter_by[0] = 'tf.form_id';
	filter_by[1] = 'period_from';
	filter_by[2] = 'period_to';
	filter_by[3] = 'YEAR(tf.date_from)';
	filter_by[4] = 'tf.type';

	filter_value[0] = $('input[name="form_id"]').val();
	filter_value[1] = $('input[name="period_from"]').val();
	filter_value[2] = $('input[name="period_to"]').val();
	filter_value[3] = $('input[name="year"]').val();
	filter_value[4] = $('input[name="addl_type"]').val();

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

