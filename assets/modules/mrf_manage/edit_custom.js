$(document).ready(function(){
	if ($('.wysihtml5').size() > 0) {
		$('.wysihtml5').wysihtml5({
			"stylesheets": ["assets/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
		});
	
		$('input[name="_wysihtml5_mode"]').addClass('dontserializeme');
	}

	if (jQuery().infiniteScroll){
		create_list();

		$('form#list-search').submit(function( event ) {
			event.preventDefault();
			create_list();
		});	
	}

	$('.filter-type').click(function(){
		$('.filter-type').removeClass('label-success');
		$('.filter-type').addClass('label-default');
		$(this).removeClass('label-default');
		$(this).addClass('label-success')
		create_list();
	});
	$('.filter-status').click(function(){
		$('.filter-status').removeClass('label-success');
		$('.filter-status').addClass('label-default');
		$(this).removeClass('label-default');
		$(this).addClass('label-success')
		create_list();
	});

	if (jQuery().datepicker) {
	    $('#recruitment_request-delivery_date').parent('.date-picker').datepicker({
	        rtl: App.isRTL(),
	        autoclose: true
	    });
	}	

	$('#recruitment_request-department_id').change(function(){
		get_dept_immediate( $(this).val() );
	});

	show_hide_contract_duration( $('#recruitment_request-employment_status_id').val() );
	$('#recruitment_request-employment_status_id').change(function(){
		show_hide_contract_duration( $(this).val() );
	});

/*	show_hide_budget_from_to( $('#recruitment_request-budgeted').val() );
	$('#recruitment_request-budgeted').change(function(){
		show_hide_budget_from_to( $(this).val() );
	});*/
});


function show_hide_contract_duration(employment_status_id){
	if( employment_status_id == 4 || employment_status_id == 5 || employment_status_id == 6
		){
		$('#contract_duration').removeClass('hidden');
	}else{
		$('#contract_duration').addClass('hidden');
	}
}

function show_hide_budget_from_to(budgeted){
	if( budgeted == 2 ){
		$('.change_plan').removeClass('hidden');
	}else{
		$('.change_plan').addClass('hidden');
	}
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function get_dept_immediate(dept_id){
	var data = {
		dept_id: dept_id
	};
	// console.log(data);
	$.ajax({
		url: base_url + module.get('route') + '/get_dept_immediate',
		type:"POST",
		async: false,
		data: data,
		dataType: "json",
		beforeSend: function(){
		},
		success: function ( response ) {

			if( typeof(response.retrieved_immediate) != 'undefined' )
			{	
				$('#recruitment_request-immediate').val(response.immediate);
			}else{
				$('#recruitment_request-immediate').val('');
			}
		}
	});	
}

function create_list()
{
	var search = $('input[name="list-search"]').val();
	
	var filter_by = {
		hiring_type: $('.filter-type.label-success').attr('filter_value'),
		status_id: $('.filter-status.label-success').attr('filter_value'),
	}

	var filter_value = $('.list-filter.active').attr('filter_value');

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

function save_record( form, status_id, status )
{
    bootbox.confirm("Are you sure you want to "+status+" this request?", function(confirm) {
        if( confirm )
        {
        	$.blockUI({ message: saving_message(),
        		onBlock: function(){
        			var data = form.find(":not('.dontserializeme')").serialize();
        			$.ajax({
        				url: base_url + module.get('route') + '/save',
        				type:"POST",
        				data: data + '&recruitment[status_id]='+status_id,
        				dataType: "json",
        				async: false,
        				success: function ( response ) {
        					handle_ajax_message( response.message );

        					if( response.saved )
        					{
        						if( response.action == 'insert' )
        							$('#record_id').val( response.record_id );

        						if(status_id != 1)
        						{
        							document.location = base_url + module.get('route');
        						}
        					}
        				}
        			});
        		},
        		baseZ: 200000000
        	});
        	setTimeout(function(){$.unblockUI()},2000);
        }
    });
}