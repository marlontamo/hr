$(document).ready(function(){

	$(".month-nav").on('click', function(){

		//get_list('month', $(this).data('month'));

		if($("#partner-filter").val()){
			get_list('month', $(this).data('month'), $("#partner-filter").val());
		}
		else{
			$("#please_choose").hide().fadeIn();
			return;
		}
	});

	$(".month-list").live('click', function(){

		if($("#partner-filter").val()){
			get_list('month', $(this).data('month-value'), $("#partner-filter").val());
		}
		else{
			$("#please_choose").hide().fadeIn();
			return;
		}
	});

	$(".year-filter").live('click', function(){
		
		if($("#partner-filter").val()){
			get_list('year', $(this).data('year-value'), $("#partner-filter").val());
		}
		else{
			$("#please_choose").hide().fadeIn();
			return;
		}
	});	

	$(".period-filter").live('click', function(){

		if($("#partner-filter").val()){

			$(".period-filter").removeClass('label-success');
			$(".period-filter").addClass('label-default');

			$(this).removeClass('label-default');
			$(this).addClass("label-success");

			var from = $(this).data("ppf-value-from");
			var to = $(this).data("ppf-value-to");
			get_period_list(from, to, $("#partner-filter").val());
		}
		else{

			$("table.table tbody tr").remove();
			$("#please_choose").hide().fadeIn();
			return;
		}		
	});


	/*!*****************************************************************
		1. check if there's a selected date.
		2. if no value on month-list, you may want to check if the user 
		has chosen to view by pay-period
	*******************************************************************/

	$("#partner-filter").on("change", function(){

		if(!$(this).val()) return;

		var selected_date = '';
		var date_type = 'month';

		if($(".event-block.label.label-success.external-event.month-list").length){

			var mv = $(".event-block.label.label-success.external-event.month-list").data('month-value');
			selected_date = mv;
		}
		else if($("event-block.label.external-event.period-filter.label-success").length){

			var pf = $("event-block.label.external-event.period-filter.label-success").val();
			selected_date = pf;
		}
		else{

			date_type = 'current';
		}

		get_list('current', selected_date, $(this).val());
	});


	$('select[name="sub-filter"]').change(function(){
		update_subordinates(this.value);
	});

	$('#selected_date').change(function(){
		get_list_by_date('by_date', $(this).val(), -1);
	});

	$("#tab_by_date").live('click', function(){
		$(".by_employee_filter").hide();
		$(".by_employee_filter").addClass('hidden');
		$(".by_date_filter").show();
		$(".by_date_filter").removeClass('hidden');
		get_list_by_date('by_date', $("#selected_date").val(), -1);
	});

	$("#tab_by_employee").live('click', function(){
		$(".by_employee_filter").show("fast");
		$(".by_employee_filter").removeClass('hidden');
		$(".by_date_filter").hide();
		$(".by_date_filter").addClass('hidden');
		get_list_by_date('by_date', $("#selected_date").val(), -1);
	});
	

});

$(document).on({
    mouseenter: function (e) { 
        e.preventDefault();
        $(this).popover('show'); 
       
    },
    mouseleave: function (e) { 
        e.preventDefault();
        $(this).popover('hide');
    }
  }, ".reminders");

function get_period_list(from, to, partner_id){

	var request_data = {from: from, to: to, id: partner_id};

	$.ajax({
	    url: base_url + module.get('route') + '/get_period_list',
	    type: "POST",
	    async: false,
	    data: request_data,
	    dataType: "json",
	    beforeSend: function () {
	    	// need to do something 
	    	// on before send?
	    	$("#something_wrong").hide();
	    },
	    success: function (response) {

	    	$("table.table tbody tr").remove();
	    	$("table.table tbody").append(response.list);
	    	initPopup();
	    },
	    error: function(request, status, error){

	    	$("#loader").hide();
	    	$("#something_wrong").show();
	    	console.log("something went wrong. Sorry for that!");    	
	    }
	});
}

function get_list(date_type, date_value, partner_id){

	var request_data = {type: date_type, value: date_value, id: partner_id};

	$.ajax({
	    url: base_url + module.get('route') + '/get_list',
	    type: "POST",
	    async: false,
	    data: request_data,
	    dataType: "json",
	    beforeSend: function () {

	    	// need to do something 
	    	// on before send?
	    	$("#something_wrong").hide();
	    	$("#please_choose").hide();
	    	$("#no_record").hide();
	    	$("#list-table").hide();
	    	$("#loader").show();
	    },
	    success: function (response) { //return;

	    	$("#date-title").html(response.current_title);

			setTimeout(function(){
				
				$("#loader").hide();

			    if(response.list.length){
		    		$("table.table tbody tr").remove();
		    		$("table.table tbody").append(response.list);
					initPopup();
		    		$("#list-table").show();
		    	}
		    	else{
		    		//console.log('show no record...');
		    		$("#no_record").show();
		    	}
    	
		    	// update nav values
		    	$("#previous_month").data('month', response.pn['prev']);
		    	$("#next_month").data('month', response.pn['nxt']);

		    	// side filter
		    	if(response.sf.length)
		    		$("#sf-container").html(response.sf);

		    	if(response.ppf.length)
		    		$("#period-filter-container").html(response.ppf);  
			}, 500);
	    },
	    error: function(request, status, error){

	    	$("#loader").hide();
	    	$("#something_wrong").show();
	    	console.log("something went wrong. Sorry for that!");   
	    }
	});
}

function get_list_by_date(date_type, date_value, partner_id){

	var request_data = {type: date_type, value: date_value, id: partner_id};

	$.ajax({
	    url: base_url + module.get('route') + '/get_list',
	    type: "POST",
	    async: false,
	    data: request_data,
	    dataType: "json",
	    beforeSend: function () {

	    	// need to do something 
	    	// on before send?
	    	$("#something_wrong_by_date").hide();
	    	$("#please_choose_by_date").hide();
	    	$("#no_record_by_date").hide();
	    	$("#list-table_by_date").hide();
	    	$("#loader_by_date").show();
	    },
	    success: function (response) { //return;

	    	$("#date-title_by_date").html(response.current_title);

			setTimeout(function(){
				
				$("#loader_by_date").hide();

			    if(response.list.length){
		    		$("table._by_date tbody tr").remove();
		    		$("table._by_date tbody").append(response.list);
					initPopup();
		    		$("#list-table_by_date").show();
		    	}
		    	else{
		    		//console.log('show no record...');
		    		$("#no_record_by_date").show();
		    	}
    	
		    	// update nav values
		    	$("#previous_month_by_date").data('month', response.pn['prev']);
		    	$("#next_month_by_date").data('month', response.pn['nxt']);

		    	// side filter
		    	if(response.sf.length)
		    		$("#sf-container").html(response.sf);

		    	if(response.ppf.length)
		    		$("#period-filter-container").html(response.ppf);  
			}, 500);
	    },
	    error: function(request, status, error){

	    	$("#loader").hide();
	    	$("#something_wrong").show();
	    	console.log("something went wrong. Sorry for that!");   
	    }
	});
}


function get_form_details(form_id, forms_id, date){
    $.ajax({
        url: base_url + module.get('route') + '/get_form_details',
        type:"POST",
        async: false,
        data: 'form_id='+form_id+'&forms_id='+forms_id+'&date='+date,
        dataType: "json",
	    beforeSend: function () {
	    	$("#time_forms_info").hide();
	    	$("#loader_form").show();
	    },
        success: function ( response ) {
            $('#manage_dialog-'+forms_id+'-'+date).attr('data-content', response.form_details);
			setTimeout(function(){
	    		$("#loader_form").hide();
	    		$('#time_forms_info').removeClass('hidden');
			}, 500);
        }
    });
}


function initPopup(){

    var showTodoQuickView = function (e) {
        e.preventDefault();
        $('.custom_popover').not(this).popover('hide')
        $(this).popover('show');
    }
    , hideTodoQuickView = function (e) {
        e.preventDefault();
        $(this).popover('hide');
    };

    $('.custom_popover').on('click', function(e){
        e.preventDefault();
    });

    $('.custom_popover')
        .popover({ 
            trigger: 'manual', 
            title: '', 
            content: '', 
            html:true })
        .on('click', showTodoQuickView)
        .parent()
        .delegate('a.close-pop', 'click', function(e) {
            e.preventDefault();
            $('.custom_popover').popover('hide');
        });
}


function update_subordinates(subFilter)
{
		$("#list-table").hide();
		$('select[name="partner-filter"]').select2("val","");

		$.ajax({
		    url: base_url + module.get('route') + '/update_subordinates',
		    type: "POST",
		    async: false,
		    data: {subFilter: subFilter},
		    dataType: "json",
		    beforeSend: function () {
		    	// need to do something 
		    	// on before send?
	    		$("#loader").show();
		    	$("#no_record").hide();
		    	$("#list-table").hide();
		    },
		    success: function (response) {
		    	$('select[name="partner-filter"]').html(response.subordinates);
	    		$("#loader").hide();
		    	$("#please_choose").show();
		    }
		});			
}

