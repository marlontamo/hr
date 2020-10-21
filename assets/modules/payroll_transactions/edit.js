$(document).ready(function(){
    $('#payroll_transaction-transaction_class_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#payroll_transaction-transaction_type_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#payroll_transaction-debit_account_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#payroll_transaction-credit_account_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#payroll_transaction-priority_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#payroll_transaction-is_bonus-temp').change(function(){
    if( $(this).is(':checked') )
        $('#payroll_transaction-is_bonus').val('1');
    else
        $('#payroll_transaction-is_bonus').val('0');
    });
});