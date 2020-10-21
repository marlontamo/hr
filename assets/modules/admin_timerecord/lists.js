$(document).ready(function(){

        $('select.select2me').select2();
        $("input.datetime").datetimepicker({
            isRTL: App.isRTL(),
            format: "mm/dd/yyyy - hh:ii",
            autoclose: true,
            todayBtn: false,
            pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
            minuteStep: 1
        });

	$('select[name="company_id"]').change(function(){
		update_department( $(this).val() );
	});

	$('select[name="department_id"]').change(function(){
		update_employee();
	});

	$('select[name="user_id"]').change(function(){
		get_list();
	});

	$(".month-nav").on('click', function(){
		date_type = "month";
		date_value = $(this).data('month');
		get_list();
	});

	$(".month-list").live('click', function(){
		date_type = "month";
		date_value = $(this).data('month-value');
		get_list();
	});

	$(".year-filter").live('click', function(){
		date_type = "year";
		date_value = $(this).data('year-value');
		get_list();
	});	

	$(".status-filter").live('click', function(){
		$(".status-filter").removeClass('label-success');
		$(".status-filter").addClass('label-default');

		$(this).removeClass('label-default');
		$(this).addClass("label-success");

		update_employee();
	});	

	$(".period-filter").live('click', function(){

		$(".period-filter").removeClass('label-success');
		$(".period-filter").addClass('label-default');

		$(this).removeClass('label-default');
		$(this).addClass("label-success");

		var from = $(this).data("ppf-value-from");
		var to = $(this).data("ppf-value-to");
		get_period_list(from,to);
	});	

	if (jQuery().datepicker) {
	    $('#selected_date').parent('.date-picker').datepicker({
	        rtl: App.isRTL(),
	        autoclose: true
	    });
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}	

	$('#selected_date').change(function(){
		if( $('select[name="department_id_by_date"]').val() > 0){
			get_list_by_date('by_date', $(this).val(), -1, $('select[name="department_id_by_date"]').val());
		}
	});

	$('select[name="department_id_by_date"]').change(function(){
		if( $(this).val() > 0){
			get_list_by_date( 'by_date', $("#selected_date").val(), -1, $(this).val() );
		}
	});

	$("#tab_for_override").live('click', function(){
		$("#override_expand").removeClass('col-md-9');
		$("#override_expand").addClass('col-md-12');
		$(".by_employee_filter").hide();
		$(".by_employee_filter").addClass('hidden');
		// $(".by_date_filter").show();
		// $(".by_date_filter").removeClass('hidden');
		if( $('select[name="department_id_by_date"]').val() > 0){
			get_list_by_date('by_date', $("#selected_date").val(), -1, $('select[name="department_id_by_date"]').val());
		}
	});
	$('#user-hide').addClass('hide');
	$('select[name="period_user_id"]').change(function(){
		$('#user-hide').removeClass('hide');
		if( $(this).val() > 0 && $('select[name="pay_dates"]').val() > 0){
			get_list_by_date('by_period', $('select[name="pay_dates"]').val(), $('select[name="period_user_id"]').val(), 0);
		}

		if( $(this).val() != '' ) {
            $.ajax({
                url: base_url + module.get('route') + '/get_user_to_options',
                type:"POST",
                data: { user_id: $('select[name="period_user_id"]').val()},
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );

                    $('#pay_dates').html( response.options );
                    $('#pay_dates').select2();
                }
            });
        } else {
            $('#pay_dates').empty();
        }
	});

	$('select[name="pay_dates"]').change(function(){
		if( $(this).val() > 0 && $('select[name="period_user_id"]').val()){
			get_list_by_date('by_period', $('select[name="pay_dates"]').val(), $('select[name="period_user_id"]').val(), 0);
		}
	});

	$('select[name="period_user_id"]').change(function(){
		$("#pay_dates").removeClass('hide');
	});

	$("#tab_for_period_override").live('click', function(){
		$("#override_expand").removeClass('col-md-9');
		$("#override_expand").addClass('col-md-12');
		$(".by_employee_filter").hide();
		$(".by_employee_filter").addClass('hidden');
		// $(".by_date_filter").show();
		// $(".by_date_filter").removeClass('hidden');
		// console.log($('select[name="period_user_id"]').val()); 
		// console.log($('select[name="pay_dates"]').val());
		// if( $('select[name="period_user_id"]').val() > 0 || $('select[name="pay_dates"]').val() > 0){
		// 	get_list_by_date('by_period', $("#pay_dates").val(), -1, $('select[name="period_user_id"]').val());
		// }
	});

	$("#tab_for_review").live('click', function(){
		$("#override_expand").removeClass('col-md-12');
		$("#override_expand").addClass('col-md-9');
		$(".by_employee_filter").show("fast");
		$(".by_employee_filter").removeClass('hidden');
		// $(".by_date_filter").hide();
		// $(".by_date_filter").addClass('hidden');
		// get_list_by_date('by_date', $("#selected_date").val(), -1, -1);
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

function save_timerecord(record_id, type){
	if(type == 'by_date') {
		var data = {
			record_id : record_id,
			time_shift_id : $('#time_shift_id-'+record_id).val(),
			timein : $('#timein-'+record_id).val(),
			timeout : $('#timeout-'+record_id).val()
		}
	} else if(type == 'by_period') {
		var data = {
			record_id : record_id,
			time_shift_id : $('#time_shift_id-'+record_id).val(),
			timein : $('#timein-'+record_id).val(),
			timeout : $('#timeout-'+record_id).val()
		}
	} else {
		var data = {
			record_id : record_id,
			time_shift_id : $('#time_shift_id-'+record_id).val(),
			timein : $('#timein-'+record_id).val(),
			timeout : $('#timeout-'+record_id).val()
		}
	}
	
	$.blockUI({ message: saving_message(),
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_timerecord',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

				    $('#time_shift_id-'+record_id).html($('#time_shift_id-'+record_id).val());
				    $('#timein-'+record_id).html($('#timein-'+record_id).val());
				    $('#timeout-'+record_id).html($('#timeout-'+record_id).val());

				    // $('#text_class_value-'+record_id).addClass('hidden');
				    // $('#span_class_value-'+record_id).removeClass('hidden');
				    // $('#save_class_value-'+record_id).addClass('hidden');
				    // $('#edit_class_value-'+record_id).removeClass('hidden');
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
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
	    		$("#dept_loader").hide();
	    		$("#department_div").show();
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
	var status_id = $('span.status-filter.label-success').attr('status_id');
	if( department_id != "" )
	{
		$("#list-table").hide();
		$('select[name="user_id"]').select2("val","");
		$.ajax({
		    url: base_url + module.get('route') + '/update_employees',
		    type: "POST",
		    async: false,
		    data: {company_id: company_id, department_id: department_id, status_id:status_id},
		    dataType: "json",
		    beforeSend: function () {
	    		$("#partners_loader").show();
	    		$("#partners_div").hide();
		    },
		    success: function (response) {
		    	$('select[name="user_id"]').html(response.employees);
	    		$("#partners_loader").hide();
	    		$("#partners_div").show();
		    }
		});	
	}
	else{
		$('select[name="user_id"]').html('');
	}		
}

function get_period_list(from, to){

	var user_id = $('select[name="user_id"]').val();
	var request_data = {from: from, to: to, user_id: user_id};

	$.ajax({
	    url: base_url + module.get('route') + '/get_period_list',
	    type: "POST",
	    async: false,
	    data: request_data,
	    dataType: "json",
	    beforeSend: function () {
	    	// need to do something 
	    	// on before send?
	    },
	    success: function (response) {

	    	$("table.table tbody tr").remove();
	    	$("table.table tbody").append(response.list);
	    	initPopup();
	    },
	    error: function(request, status, error){

	    	console.log("something went wrong. Sorry for that!");    	
	    }
	});
}

var date_type = "current";
var date_value = "";

function get_list(){

	var user_id = $('select[name="user_id"]').val();
	var request_data = {type: date_type, value: date_value, user_id: user_id};

	$.ajax({
	    url: base_url + module.get('route') + '/get_list',
	    type: "POST",
	    async: false,
	    data: request_data,
	    dataType: "json",
	    beforeSend: function () {

	    	// need to do something 
	    	// on before send?
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

	    	console.log("something went wrong. Contact your System Administrator.");   	
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

function get_list_by_date(date_type, date_value, partner_id, dept_id){

	var request_data = {type: date_type, value: date_value, user_id: partner_id, dept_id: dept_id};

	$.ajax({
	    url: base_url + module.get('route') + '/get_list',
	    type: "POST",
	    async: false,
	    data: request_data,
	    dataType: "json",
	    beforeSend: function () {

	    	// need to do something 
	    	// on before send?
	    	if(date_type == 'by_date'){
	    		$("#no_record_bydate").hide();
		    	$("#list-table_bydate").hide();
		    	$("#loader_bydate").show();
	    	} else if (date_type == 'by_period') {
	    		$("#no_record_byperiod").hide();
		    	$("#ist-table_byperiod").hide();
		    	$("#loader_byperiod").show();
	    	}
	    },
	    success: function (response) { //return;
			setTimeout(function(){	
				if(date_type == 'by_date'){
					$("#loader_bydate").hide();
				} else if (date_type == 'by_period') {
					$("#loader_byperiod").hide();
				}
				
			    if(response.list.length){
			    	if(date_type == 'by_date') {
						$("table._bydate tbody tr").remove();
		    			$("table._bydate tbody").append(response.list);
		    			initPopup();
		    			$("#list-table_bydate").show();
					} else if (date_type == 'by_period') {
						$("table.by_period tbody tr").remove();
		    			$("table.by_period tbody").append(response.list);
	    				initPopup();
		    			$("#list-table_byperiod").show();
					}
		    	} else { 
		    		if(date_type == 'by_date') {
						$("#no_record_bydate").show();
						$("#no_record_bydate").hide();
					} else if(date_type == 'by_period') {
						$("#no_record_byperiod").show();
						$("#list-table_byperiod").hide();
					}
		    		//console.log('show no record...');
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

	    	console.log("something went wrong. Contact your System Administrator.");   	
	    }
	});
}

function get_ot_info(date, user_id) {
    $.ajax({
        url: base_url + module.get('route') + '/get_ot_info',
        type: "POST",
        async: false,
        data: { user_id: user_id, date: date },
        dataType: "json",
        beforeSend: function () {
	    	$("#time_forms_info").hide();
	    	$("#loader_form").show();
	    },
        success: function ( response ) {
            $('#ot_dialog-'+date).attr('data-content', response.ot_details);
        
			setTimeout(function(){
	    		$("#loader_form").hide();
	    		$('#time_forms_info').removeClass('hidden');
			}, 10);
        }
    });
}