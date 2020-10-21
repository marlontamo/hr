$(document).ready(function(){
$('#payroll_entry_recurring-transaction_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
if (jQuery().datepicker) {
    $('#payroll_entry_recurring-date_from').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
$('#payroll_entry_recurring-transaction_method_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_entry_recurring-account_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_entry_recurring-week').multiselect();

$(":input").inputmask();});