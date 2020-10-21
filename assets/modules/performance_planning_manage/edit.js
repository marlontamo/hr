$(document).ready(function(){
    $('#performance_planning-filter_by').select2({
        placeholder: "Select an option",
        allowClear: true
    }); 

    $('#performance_planning_applicable-user_id').multiselect();

    $('#performance_planning-filter_id').multiselect();

    $('#performance_planning-status_id-temp').change(function(){
    	if( $(this).is(':checked') )
    		$('#performance_planning-status_id').val('1');
    	else
    		$('#performance_planning-status_id').val('0');
    });

    // $('#performance_planning-template_id').multiselect();
    $('#performance_planning-template_id').select2({
        placeholder: "Select templates",
        allowClear: true
    });

    // $('#performance_planning-employment_status_id').multiselect();
    $('#performance_planning-employment_status_id').select2({
        placeholder: "Select employment status",
        allowClear: true
    });

    $('#select2_sample2').select2({
        placeholder: "Select a State",
        allowClear: true
    });

    $('#performance_planning-performance_type_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    if (jQuery().datepicker) {
        $('#performance_planning-date_to').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    if (jQuery().datepicker) {
        $('#performance_planning-date_from').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
});