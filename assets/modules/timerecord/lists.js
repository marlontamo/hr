$(document).ready(function(){

	// request for current date/month
	if($('#type').val() == "manage"){

	}else{
		get_list('current','');
	}

	$(".month-nav").on('click', function(){
		get_list('month', $(this).data('month'));
	});

	$(".month-list").live('click', function(){
		get_list('month', $(this).data('month-value'));
	});

	$(".year-filter").live('click', function(){
		get_list('year', $(this).data('year-value'));
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

function get_period_list(from, to){

	var request_data = {from: from, to: to};

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

function get_list(date_type, date_value){

	var request_data = {type: date_type, value: date_value};

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
			}, 10);
        }
    });

}


function initPopup(){

    var showTodoQuickView = function (e) {
        e.preventDefault();
        $('.custom_popover').not(this).popover('hide');
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


function edit_timerecord( record_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/edit_timerecord',
				type:"POST",
				async: false,
				data: 'record_id='+record_id,
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( typeof(response.quick_edit_form) != 'undefined' )
					{
						$('.modal-container').html(response.quick_edit_form);
						$('.modal-container').modal();
					}

				}
			});
		}
	});
	$.unblockUI();	
}

function save_timerecord( form, action, callback )
{
	$.blockUI({ message: saving_message(),
		onBlock: function(){

			var hasCKItem = form.find("textarea.ckeditor");

			if(hasCKItem && (typeof editor != 'undefined')){
				
				for ( instance in CKEDITOR.instances )
        			CKEDITOR.instances[instance].updateElement();
			}

			var data = form.find(":not('.dontserializeme')").serialize();
			$.ajax({
				url: base_url + module.get('route') + '/save_timerecord',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( response.saved )
					{
						document.location = base_url + module.get('route')
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
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