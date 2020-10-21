<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_transaction`.`transaction_id` as record_id, 
	ww_payroll_transaction.transaction_code as "payroll_transaction_transaction_code", 
	ww_payroll_transaction.transaction_label as "payroll_transaction_transaction_label", 
	T3.transaction_class as "payroll_transaction_transaction_class_id", 
	T4.transaction_type as "payroll_transaction_transaction_type_id", 
	T5.account_name as "payroll_transaction_debit_account_id", 
	T6.account_name as "payroll_transaction_credit_account_id", 
	T7.priority as "payroll_transaction_priority_id", 
	ww_payroll_transaction.is_bonus as "payroll_transaction_is_bonus", 
	`ww_payroll_transaction`.`created_on` as "payroll_transaction_created_on", 
	`ww_payroll_transaction`.`created_by` as "payroll_transaction_created_by", 
	`ww_payroll_transaction`.`modified_on` as "payroll_transaction_modified_on", 
	`ww_payroll_transaction`.`modified_by` as "payroll_transaction_modified_by",
	`ww_payroll_transaction`.`can_delete` as "can_delete"
FROM (`ww_payroll_transaction`)
LEFT JOIN `ww_payroll_transaction_class` T3 ON `T3`.`transaction_class_id` = `ww_payroll_transaction`.`transaction_class_id`
LEFT JOIN `ww_payroll_transaction_type` T4 ON `T4`.`transaction_type_id` = `ww_payroll_transaction`.`transaction_type_id`
LEFT JOIN `ww_payroll_account` T5 ON `T5`.`account_id` = `ww_payroll_transaction`.`debit_account_id`
LEFT JOIN `ww_payroll_account` T6 ON `T6`.`account_id` = `ww_payroll_transaction`.`credit_account_id`
LEFT JOIN `ww_payroll_transaction_priority` T7 ON `T7`.`priority_id` = `ww_payroll_transaction`.`priority_id`
WHERE (
	ww_payroll_transaction.transaction_code like "%{$search}%" OR 
	ww_payroll_transaction.transaction_label like "%{$search}%" OR 
	T3.transaction_class like "%{$search}%" OR 
	T4.transaction_type like "%{$search}%" OR 
	T5.account_name like "%{$search}%" OR 
	T6.account_name like "%{$search}%" OR 
	T7.priority like "%{$search}%"
)';