$(document).ready(function(){
$('#time_record_summary-day_type').select2({
    placeholder: "Select an option",
    allowClear: true
});
$(":input").inputmask();
$('#time_record_summary-absent-temp').change(function(){
	if( $(this).is(':checked') )
		$('#time_record_summary-absent').val('1');
	else
		$('#time_record_summary-absent').val('0');
});
if (jQuery().datepicker) {
    $('#time_record_summary-payroll_date').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
if (jQuery().datepicker) {
    $('#time_record_summary-date').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
$('#time_record_summary-user_id').select2({
    placeholder: "Select an option",
    allowClear: true
});});