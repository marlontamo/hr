<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_payroll_current_transaction`.`id` as record_id, 
ww_payroll_current_transaction.remarks as "payroll_current_transaction_remarks", 
IF(ww_payroll_current_transaction.on_hold = 1, "Yes", "No") as "payroll_current_transaction_on_hold", 
ww_payroll_current_transaction.amount as "payroll_current_transaction_amount", 
ww_payroll_current_transaction.unit_rate as "payroll_current_transaction_unit_rate", 
ww_payroll_current_transaction.quantity as "payroll_current_transaction_quantity", 
DATE_FORMAT(ww_payroll_current_transaction.payroll_date, \'%M %d, %Y\') as "payroll_current_transaction_payroll_date", 
T2.full_name as "payroll_current_transaction_employee_id", 
T1.period_processing_type as "payroll_current_transaction_processing_type_id", 
`ww_payroll_current_transaction`.`created_on` as "payroll_current_transaction_created_on", 
`ww_payroll_current_transaction`.`created_by` as "payroll_current_transaction_created_by", 
`ww_payroll_current_transaction`.`modified_on` as "payroll_current_transaction_modified_on", 
`ww_payroll_current_transaction`.`modified_by` as "payroll_current_transaction_modified_by"
FROM (`ww_payroll_current_transaction`)
LEFT JOIN `ww_users` T2 ON `T2`.`user_id` = `ww_payroll_current_transaction`.`employee_id`
LEFT JOIN `ww_payroll_period_processing_type` T1 ON `T1`.`period_processing_type_id` = `ww_payroll_current_transaction`.`processing_type_id`
WHERE (
	ww_payroll_current_transaction.remarks like "%{$search}%" OR 
	IF(ww_payroll_current_transaction.on_hold = 1, "Yes", "No") like "%{$search}%" OR 
	ww_payroll_current_transaction.amount like "%{$search}%" OR 
	ww_payroll_current_transaction.unit_rate like "%{$search}%" OR 
	ww_payroll_current_transaction.quantity like "%{$search}%" OR 
	DATE_FORMAT(ww_payroll_current_transaction.payroll_date, \'%M %d, %Y\') like "%{$search}%" OR 
	T2.full_name like "%{$search}%" OR 
	T1.period_processing_type like "%{$search}%"
)';