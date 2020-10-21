$(document).ready(function(){
$('#payroll_bonus-bonus_transaction_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
if (jQuery().datepicker) {
    $('#payroll_bonus-payroll_date').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
if (jQuery().datepicker) {
    $('#payroll_bonus-date_from').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
$(":input").inputmask();
$('#payroll_bonus-week').multiselect();

$('#payroll_bonus-transaction_method_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_bonus-account_id').select2({
    placeholder: "Select an option",
    allowClear: true
});});