$(document).ready(function(){
$('#payroll_loan-loan_type_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_loan-loan_mode_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_loan-principal_transid').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_loan-amortization_transid').select2({
    placeholder: "Select an option",
    allowClear: true
});
$(":input").inputmask();
$('#payroll_loan-interest_transid').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_loan-interest_type_id').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_loan-debit').select2({
    placeholder: "Select an option",
    allowClear: true
});
$('#payroll_loan-credit').select2({
    placeholder: "Select an option",
    allowClear: true
});});