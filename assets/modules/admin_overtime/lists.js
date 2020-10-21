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
		update_department( $(this).val() );
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

	$('select[name="department_id"]').change(function(){
		update_employee();

		if($("span.label-success").data('record-id') > 0){
			create_list('period', $("span.label-success").data('record-id'));
		}else if($("span.label-success").data('month-value')){
			create_list('month', $("span.label-success").data('month-value'));
		}else{
			create_list();
		}
	});

	$('select[name="user_id"]').change(function(){
		if($("span.label-success").data('record-id') > 0){
			create_list('period', $("span.label-success").data('record-id'));
		}else if($("span.label-success").data('month-value')){
			create_list('month', $("span.label-success").data('month-value'));
		}else{
			create_list();
		}
	});

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
	required_filter = '?company='+$('select[name="company_id"]').val();
	required_filter += '&department='+$('select[name="department_id"]').val();
	required_filter += '&user='+$('select[name="user_id"]').val();

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

function update_department( company_id )
{
	if( company_id != "" )
	{
		$("#list-table").hide();
		$('select[name="department_id"]').select2("val","");
		$('select[name="user_id"]').select2("val","");
		$.ajax({
		    url: base_url + module.get('route') + '/update_department',
		    type: "POST",
		    async: false,
		    data: {company_id: company_id},
		    dataType: "json",
		    beforeSend: function () {
	    		$("#dept_loader").show();
	    		$("#department_div").hide();
		    },
		    success: function (response) {
		    	$('select[name="department_id"]').html(response.departments);
	    		$("#department_div").show();
	    		$("#dept_loader").hide();
		    	$('select[name="user_id"]').html('');
		    }
		});	
	}
	else{
		$('select[name="department_id"]').html('');
	}		
}

function update_employee()
{
	var company_id = $('select[name="company_id"]').val();
	var department_id = $('select[name="department_id"]').val();
	// var status_id = $('span.status-filter.label-success').attr('status_id');
	if( department_id != "" )
	{
		$("#list-table").hide();
		$('select[name="user_id"]').select2("val","");
		$.ajax({
		    url: base_url + module.get('route') + '/update_employees',
		    type: "POST",
		    async: false,
		    data: {company_id: company_id, department_id: department_id},
		    dataType: "json",
		    beforeSend: function () {
	    		$("#partners_loader").show();
	    		$("#partners_div").hide();
		    },
		    success: function (response) {
		    	$('select[name="user_id"]').html(response.employees);
	    		$("#partners_div").show();
	    		$("#partners_loader").hide();
		    }
		});	
	}
	else{
		$('select[name="user_id"]').html('');
	}		
}