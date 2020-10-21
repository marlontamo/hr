<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_payroll_transaction`.`transaction_id` as record_id, 
	`ww_payroll_transaction`.`created_on` as "payroll_transaction.created_on", 
	`ww_payroll_transaction`.`created_by` as "payroll_transaction.created_by", 
	`ww_payroll_transaction`.`modified_on` as "payroll_transaction.modified_on", 
	`ww_payroll_transaction`.`modified_by` as "payroll_transaction.modified_by", 
	ww_payroll_transaction.transaction_code as "payroll_transaction.transaction_code", 
	ww_payroll_transaction.transaction_label as "payroll_transaction.transaction_label", 
	ww_payroll_transaction.transaction_class_id as "payroll_transaction.transaction_class_id", 
	ww_payroll_transaction.transaction_type_id as "payroll_transaction.transaction_type_id", 
	ww_payroll_transaction.debit_account_id as "payroll_transaction.debit_account_id", 
	ww_payroll_transaction.credit_account_id as "payroll_transaction.credit_account_id", 
	ww_payroll_transaction.priority_id as "payroll_transaction.priority_id",
	ww_payroll_transaction.is_bonus as "payroll_transaction.is_bonus"
FROM (`ww_payroll_transaction`)
WHERE `ww_payroll_transaction`.`transaction_id` = "{$record_id}"';