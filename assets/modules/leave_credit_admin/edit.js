$(document).ready(function(){
$('#time_form_balance-form_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#time_form_balance-user_id').select2({
    placeholder: "Select an option",
    allowClear: true
});});

if (jQuery().datepicker) {
    $('#time_form_balance-period_extension').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open");
}