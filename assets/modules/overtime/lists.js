$(document).ready(function(e) { 
	// on click month filter
	$(".month-list").live('click', function(){
		$(".month-list").removeClass('label-success');
		$(".month-list").addClass('label-default');
		$(".period-filter").removeClass('label-success');
		$(".period-filter").addClass('label-default');
		$(this).removeClass('label-default');
		$(this).addClass('label-success');
		create_list('month', $(this).data('month-value'));
		$("#selected_filterMonth").val($(this).text());
		$("#selected_filterMonth").attr('data-date', $(this).data('month-value'));
	});

	// on click next year filter
	$(".year-filter").live('click', function(){
		var selected_year = $(this).data('year-value');
		move_year_filter(selected_year);
		create_list('month', $("#selected_filterMonth").data('date'));
	});	

	// on click period filter
	$(".period-filter").live('click', function(){
		$(".period-filter").removeClass('label-success');
		$(".period-filter").addClass('label-default');
		$(".month-list").removeClass('label-success');
		$(".month-list").addClass('label-default');
		$(this).removeClass('label-default');
		$(this).addClass('label-success');
		create_list('period', $(this).data('record-id'));
		// $("#selected_filterMonth").val('');
		// $("#selected_filterMonth").attr('data-date', '');
	});

});

function create_list(filter_by, filter_value)
{
	var search = $('input[name="list-search"]').val();
	// var filter_by = $('.list-filter.active').attr('filter_by');
	// var filter_value = $('.list-filter.active').attr('filter_value');

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

function move_year_filter(selected_year){
	var selected_filterMonth = $("#selected_filterMonth").val();
	var selected_filterDate = $("#selected_filterMonth").data('date');
	var request_data = {selected_year: selected_year, 
						selected_filterMonth: selected_filterMonth,
						selected_filterDate: selected_filterDate
					};

	$.ajax({
	    url: base_url + module.get('route') + '/move_year_filter',
	    type: "POST",
	    async: false,
	    data: request_data,
	    dataType: "json",
	    beforeSend: function () {
	    	// need to do something 
	    	// on before send?
	    },
	    success: function (response) {
		    	if(response.sf.length)
		    		$("#sf-container").html(response.sf);
	    },
	    error: function(request, status, error){

	    	console.log("something went wrong. Sorry for that!");    	
	    }
	});
}