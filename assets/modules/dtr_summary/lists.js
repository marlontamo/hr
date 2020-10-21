$(document).ready(function(){
	$(".period-filter").on('click', function(){

		$(".period-filter").removeClass('label-success');
		$(".period-filter").addClass('label-default');

		$(this).removeClass('label-default');
		$(this).addClass("label-success");

		var search = $('input[name="list-search"]').val();
		var filter_by = 'ww_time_record_summary.payroll_date';
		var filter_value = $(this).attr("payroll_date");

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

	});
});
