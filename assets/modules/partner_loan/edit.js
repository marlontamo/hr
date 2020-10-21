$(document).ready(function(){

$('.select2me').select2({
    placeholder: "Select an option",
    allowClear: true
});

$('#payroll_partners_loan-loan_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_partners_loan-loan_status_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
if (jQuery().datepicker) {
    $('#payroll_partners_loan-entry_date').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
$(":input").inputmask();
$('#payroll_partners_loan-releasing_debit_account_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_partners_loan-releasing_credit_account_id').select2({
    placeholder: "Select an option",
    allowClear: true
});

$('#payroll_partners_loan-week').select2({
    placeholder: "Select an option",
    allowClear: true
});

if (jQuery().datepicker) {
    $('#payroll_partners_loan-start_date').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}
$('#payroll_partners_loan-payment_mode_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_partners_loan-amortization_credit_account_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_partners_loan-interest_credit_account_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
if (jQuery().datepicker) {
    $('#payroll_partners_loan-last_payment_date').parent('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}});