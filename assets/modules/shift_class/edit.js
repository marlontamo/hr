$(document).ready(function(){

	$('select[name="time_shift_class_company[company_id]"]').change(function(){
		if($('select[name="time_shift_class_company[shift_id]"]').val() != ""){
			update_class_code();
		}
	});

	$('select[name="time_shift_class_company[shift_id]"]').change(function(){
		update_class_code();
	});

	$('#filter_employees').click(function () {
	    if($('#employee_filtered').val() == 0){
	        update_employees();
	    }
	    $('#filter_emp_container').hide();
	    // $('.form-actions').hide();
	    $('#change_employees').show();
	});
	
    $('#time_shift_class_company-employment_status_id').multiselect({
        noneSelectedText: 'All Selected'
    });

    $('#time_shift_class_company-employment_type_id').multiselect({
        noneSelectedText: 'All Selected'
    });

});

function back_to_mainform_emp(cancel){   
    var employees_count = $("#time_shift_class_company-partners_id :selected").length;
    if(employees_count == 0){
    	$('#employees_count').html('All');
    }else{
    	$('#employees_count').html(employees_count);
    }
	    $('#filter_emp_container').show();
	    // $('.form-actions').hide();
	    $('#change_employees').hide();
}

function update_employees()
{
    $.blockUI({ message: '<div>Loading employees, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
     onBlock: function(){
        $.ajax({
            url: base_url + module.get('route') + '/update_employees',
            type: "POST",
            async: false,
            dataType: "json",
            data: { record_id: $('#record_id').val()},
            beforeSend: function () {
                // need to do something 
                // on before send?
            },
            success: function (response) {  
                $('#change_employees').prepend(response.filtered_employees);
			    $('#time_shift_class_company-partners_id').multiselect({
			        noneSelectedText: 'All Selected'
			    }); 
    			$('#partners_id').val('all');
    			$('#employee_filtered').val(1);
            }
        }); 
     }
    });
    $.unblockUI();
}

function update_class_code()
{
	var company_id = $('select[name="time_shift_class_company[company_id]"]').val();
	var shift_id = $('select[name="time_shift_class_company[shift_id]"]').val();

	if( company_id > 0 && shift_id > 0 )
	{
		$.ajax({
		    url: base_url + module.get('route') + '/update_class_codes',
		    type: "POST",
		    async: false,
		    data: {company_id: company_id, shift_id: shift_id},
		    dataType: "json",
		    beforeSend: function () {
		    	// need to do something 
		    	// on before send?
		    },
		    success: function (response) {
		    	$('select[name="time_shift_class_company[class_id]"]').html(response.class_codes);
		    	$('select[name="time_shift_class_company[class_id]"]').select2("val", '');
		    }
		});	
	}
	else{
		$('select[name="time_shift_class_company[class_id]"]').html('');
	}		
}

function save_record( form, action, callback )
{
	$.blockUI({ message: saving_message(),
		onBlock: function(){

			var hasCKItem = form.find("textarea.ckeditor");

			if(hasCKItem && (typeof editor != 'undefined')){
				
				for ( instance in CKEDITOR.instances )
        			CKEDITOR.instances[instance].updateElement();
        		
				// console.log('form has CK Editor Instance');
				// console.log(hasCKItem);
				// console.log(editor);
				//console.log(CKEDITOR);
			}


			var data = form.find(":not('.dontserializeme')").serialize();
			$.ajax({
				url: base_url + module.get('route') + '/save',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( response.saved )
					{
						if( response.action == 'insert' )
							$('#record_id').val( response.record_id );

						if (typeof(after_save) == typeof(Function)) after_save( response );
						if (typeof(callback) == typeof(Function)) callback( response );

						switch( action )
						{
							case 'new':
								document.location = base_url + module.get('route') + '/add';
								break;
						}
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}