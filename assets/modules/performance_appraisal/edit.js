$(document).ready(function(){
$('.select2me').select2({
    placeholder: "Select an option",
    allowClear: true
});
// $('#performance_appraisal-filter_by').select2({
//     placeholder: "Select an option",
//     allowClear: true
// });
$('#performance_appraisal_applicable-user_id').multiselect();

$('#performance_appraisal-filter_id').multiselect();

$('#performance_appraisal-status_id-temp').change(function(){
	if( $(this).is(':checked') )
		$('#performance_appraisal-status_id').val('1');
	else
		$('#performance_appraisal-status_id').val('0');
});
// $('#performance_appraisal-template_id').multiselect();
    $('#performance_appraisal-template_id').select2({
        placeholder: "Select templates",
        allowClear: true
    });

// $('#performance_appraisal-employment_status_id').multiselect();
    $('#performance_appraisal-employment_status_id').select2({
        placeholder: "Select templates",
        allowClear: true
    });

// $('#performance_appraisal-performance_type_id').select2({
//     placeholder: "Select an option",
//     allowClear: true
// });
if (jQuery().datepicker) {
    $('#performance_appraisal-date_to').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
if (jQuery().datepicker) {
    $('#performance_appraisal-date_from').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}

$('div.select2me').children().css("width", "300px");
});