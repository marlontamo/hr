<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_loan`.`loan_id` as record_id, 
ww_payroll_loan.loan as "payroll_loan_loan", 
ww_payroll_loan.loan_code as "payroll_loan_loan_code", 
T2.loan_type as "payroll_loan_loan_type_id", 
T3.loan_mode as "payroll_loan_loan_mode_id", 
ww_payroll_loan.principal_transid as "payroll_loan_principal_transid", 
ww_payroll_loan.amortization_transid as "payroll_loan_amortization_transid", 
ww_payroll_loan.amount_limit as "payroll_loan_amount_limit", 
ww_payroll_loan.interest_transid as "payroll_loan_interest_transid", 
T8.interest_type as "payroll_loan_interest_type_id", 
ww_payroll_loan.debit as "payroll_loan_debit", 
ww_payroll_loan.credit as "payroll_loan_credit", 
ww_payroll_loan.interest as "payroll_loan_interest", 
`ww_payroll_loan`.`created_on` as "payroll_loan_created_on", 
`ww_payroll_loan`.`created_by` as "payroll_loan_created_by", 
`ww_payroll_loan`.`modified_on` as "payroll_loan_modified_on", 
`ww_payroll_loan`.`modified_by` as "payroll_loan_modified_by",
`ww_payroll_loan`.`can_delete` as "can_delete"
FROM (`ww_payroll_loan`)
LEFT JOIN `ww_payroll_loan_type` T2 ON `T2`.`loan_type_id` = `ww_payroll_loan`.`loan_type_id`
LEFT JOIN `ww_payroll_loan_mode` T3 ON `T3`.`loan_mode_id` = `ww_payroll_loan`.`loan_mode_id`
LEFT JOIN `ww_payroll_loan_interest_type` T8 ON `T8`.`interest_type_id` = `ww_payroll_loan`.`interest_type_id`
WHERE (
	ww_payroll_loan.loan_code like "%{$search}%" OR 
	ww_payroll_loan.loan like "%{$search}%" OR 
	T2.loan_type like "%{$search}%" OR 
	T3.loan_mode like "%{$search}%" OR 
	ww_payroll_loan.principal_transid like "%{$search}%" OR 
	ww_payroll_loan.amortization_transid like "%{$search}%" OR 
	ww_payroll_loan.amount_limit like "%{$search}%" OR 
	ww_payroll_loan.interest_transid like "%{$search}%" OR 
	T8.interest_type like "%{$search}%" OR 
	ww_payroll_loan.debit like "%{$search}%" OR 
	ww_payroll_loan.credit like "%{$search}%" OR 
	ww_payroll_loan.interest like "%{$search}%"
)';