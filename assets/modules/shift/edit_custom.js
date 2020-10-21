$(document).ready(function(){

    $('#time_shift-company_id').select2({
		placeholder: "Select Company",
		allowClear: true
	});
    $('#time_shift-department_id').select2({
		placeholder: "Select Department",
		allowClear: true
	});
    if (jQuery().colorpicker) {
        $('.colorpicker-default').colorpicker({
	        format: 'hex'
	    });
	    $('.colorpicker-rgba').colorpicker();
    }
});