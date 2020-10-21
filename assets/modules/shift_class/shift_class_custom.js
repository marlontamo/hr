$(document).ready(function(){

	if (jQuery().infiniteScroll){
        $("#loader").show();
		validate_shifts_classes();
        $("#loader").hide();
    	$("#list-table").hide();
    	$('.well').show();
	}

	// $('select[name="company_id"]').change(function(){
	// 	if($('select[name="shift_id"]').val() != ""){
	// 		create_list_class();
	// 	}
	// });
	
	$('.shift_classes').change(function(){
		validate_shifts_classes();
	});
	
	$('.shifts').change(function(){
		validate_shifts_classes();
	});



});

function validate_shifts_classes(){
	var shiftsClassesArray = [];
	$('input.shift_classes:checkbox:checked').each(function () {
	    shiftsClassesArray.push($(this).val());
	});
	var shiftsArray = [];
	$('input.shifts:checkbox:checked').each(function () {
	    shiftsArray.push($(this).val());
	});
	if(shiftsArray.length > 0 && shiftsClassesArray.length > 0){
		create_list_class(shiftsClassesArray, shiftsArray)
	}
}

function create_list_class(shiftClasses, shifts){

	// var company_id = $('select[name="company_id"]').val();
	// var shift_id = $('select[name="shift_id"]').val();
	var request_data = {shiftClasses: shiftClasses, shifts: shifts};

        $('#list-time-class').infiniteScroll({
            dataPath: base_url + module.get('route') + '/get_list',
            itemSelector: 'tr.record',
            onDataLoading: function(){ 
                $("#loader").show();
                $('.well').hide();
            },
            onDataLoaded: function(x, y, z){ 
                $("#loader").hide();
		    	$("#list-table").show();

                if( x <= 0 ){
                    $('.well').show();
		    		$("#list-table").hide();
                }
                else{
                    $('.well').hide();
                }

            },
            onDataError: function(){ 
                return;
            },
			filter: shiftClasses, 
			filter_by: shifts
        });
}

function edit_value(record_id){
    $('.text_class_value').addClass('hidden');
    $('.span_class_value').removeClass('hidden');
    $('.save_class_value').addClass('hidden');
    $('.edit_class_value').removeClass('hidden');

    $('#text_class_value-'+record_id).removeClass('hidden');
    $('#span_class_value-'+record_id).addClass('hidden');
    $('#save_class_value-'+record_id).removeClass('hidden');
    $('#edit_class_value-'+record_id).addClass('hidden');
    var temp;
    temp=$('#text_class_value-'+record_id).val();
    $('#text_class_value-'+record_id).val('');
    $('#text_class_value-'+record_id).focus();
    $('#text_class_value-'+record_id).val(temp);
}

function save_value(record_id){
	$.blockUI({ message: saving_message(),
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_value',
				type:"POST",
				data: "record_id="+record_id+"&time_shift_class_company[class_value]="+ $('#text_class_value-'+record_id).val(),
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

				    $('#span_class_value-'+record_id).html($('#text_class_value-'+record_id).val());

				    $('#text_class_value-'+record_id).addClass('hidden');
				    $('#span_class_value-'+record_id).removeClass('hidden');
				    $('#save_class_value-'+record_id).addClass('hidden');
				    $('#edit_class_value-'+record_id).removeClass('hidden');
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}

$(document).on('keypress', '.text_class_value', function (e) {
	alert('tets');
    if (e.which == 13) {
        save_value($(this).attr('data-id'));
    } else return;
});

