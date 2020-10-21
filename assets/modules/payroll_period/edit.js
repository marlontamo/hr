$(document).ready(function(){

if ($('#payroll_period-period_processing_type_id').val() == 3){
    $('#include_basic').show();
    $('#include_13th_month_pay').show();
}   
else{
    $('#include_basic').hide();
    $('#include_13th_month_pay').hide();
}

$('#payroll_period-period_processing_type_id').change(function(){
    if ($(this).val() == 3){
        $('#include_basic').show();
        $('#include_13th_month_pay').show();
    }
    else{
        $('#include_basic').hide();
        $('#include_13th_month_pay').hide();
    }
});

$('#payroll_period-include_basic_and_allowances-temp').change(function(){
    if( $(this).is(':checked') )
        $('#payroll_period-include_basic_and_allowances').val('1');
    else
        $('#payroll_period-include_basic_and_allowances').val('0');
}); 

$('#payroll_period-include_13th_month_pay-temp').change(function(){
    if( $(this).is(':checked') )
        $('#payroll_period-include_13th_month_pay').val('1');
    else
        $('#payroll_period-include_13th_month_pay').val('0');
}); 

if (jQuery().datepicker) {
    $('#payroll_period-posting_date').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
$('#payroll_period-applied_to').select2();
$('#payroll_period-week').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_period-payroll_schedule_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_period-period_processing_type_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_period-apply_to_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_period-period_status_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
if (jQuery().datepicker) {
    $('#payroll_period-date_from').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
if (jQuery().datepicker) {
    $('#payroll_period-payroll_date').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}});