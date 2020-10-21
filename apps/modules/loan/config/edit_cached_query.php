<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_payroll_loan`.`loan_id` as record_id, `ww_payroll_loan`.`created_on` as "payroll_loan.created_on", `ww_payroll_loan`.`created_by` as "payroll_loan.created_by", `ww_payroll_loan`.`modified_on` as "payroll_loan.modified_on", `ww_payroll_loan`.`modified_by` as "payroll_loan.modified_by", ww_payroll_loan.loan as "payroll_loan.loan", ww_payroll_loan.loan_code as "payroll_loan.loan_code", ww_payroll_loan.loan_type_id as "payroll_loan.loan_type_id", ww_payroll_loan.loan_mode_id as "payroll_loan.loan_mode_id", ww_payroll_loan.principal_transid as "payroll_loan.principal_transid", ww_payroll_loan.amortization_transid as "payroll_loan.amortization_transid", ww_payroll_loan.amount_limit as "payroll_loan.amount_limit", ww_payroll_loan.interest_transid as "payroll_loan.interest_transid", ww_payroll_loan.interest_type_id as "payroll_loan.interest_type_id", ww_payroll_loan.debit as "payroll_loan.debit", ww_payroll_loan.credit as "payroll_loan.credit", ww_payroll_loan.interest as "payroll_loan.interest"
FROM (`ww_payroll_loan`)
WHERE `ww_payroll_loan`.`loan_id` = "{$record_id}"';