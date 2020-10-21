$(document).ready(function(){
    if (jQuery().datepicker) {
        $('#payroll_leave_conversion_period-payroll_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }

    $('#payroll_leave_conversion_period-applied_to').select2();
    $('#payroll_leave_conversion_period-apply_to_id').select2({
	    placeholder: "Select an option",
	    allowClear: true
	});
	if (jQuery().datepicker) {
	    $('#payroll_leave_conversion_period-date_from').parent('.date-picker').datepicker({
	        rtl: App.isRTL(),
	        autoclose: true
	    });
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}
	if (jQuery().datepicker) {
	    $('#payroll_leave_conversion_period-payroll_date').parent('.date-picker').datepicker({
	        rtl: App.isRTL(),
	        autoclose: true
	    });
	    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
	}
});

