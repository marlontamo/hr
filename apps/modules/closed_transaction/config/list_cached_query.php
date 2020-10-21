<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_closed_transaction`.`id` as record_id, T1.full_name as "payroll_closed_transaction_employee_id", DATE_FORMAT(ww_payroll_closed_transaction.payroll_date, \'%M %d, %Y\') as "payroll_closed_transaction_payroll_date", ww_payroll_closed_transaction.quantity as "payroll_closed_transaction_quantity", ww_payroll_closed_transaction.unit_rate as "payroll_closed_transaction_unit_rate", ww_payroll_closed_transaction.amount as "payroll_closed_transaction_amount", ww_payroll_closed_transaction.remarks as "payroll_closed_transaction_remarks", `ww_payroll_closed_transaction`.`created_on` as "payroll_closed_transaction_created_on", `ww_payroll_closed_transaction`.`created_by` as "payroll_closed_transaction_created_by", `ww_payroll_closed_transaction`.`modified_on` as "payroll_closed_transaction_modified_on", `ww_payroll_closed_transaction`.`modified_by` as "payroll_closed_transaction_modified_by"
FROM (`ww_payroll_closed_transaction`)
LEFT JOIN `ww_users` T1 ON `T1`.`user_id` = `ww_payroll_closed_transaction`.`employee_id`
WHERE (
	T1.full_name like "%{$search}%" OR 
	DATE_FORMAT(ww_payroll_closed_transaction.payroll_date, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_payroll_closed_transaction.quantity like "%{$search}%" OR 
	ww_payroll_closed_transaction.unit_rate like "%{$search}%" OR 
	ww_payroll_closed_transaction.amount like "%{$search}%" OR 
	ww_payroll_closed_transaction.remarks like "%{$search}%"
)';