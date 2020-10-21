$(document).ready(function(){
$('#payroll_closed_transaction-employee_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
if (jQuery().datepicker) {
    $('#payroll_closed_transaction-payroll_date').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
$('#payroll_closed_transaction-transaction_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$(":input").inputmask();});