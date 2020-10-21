<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_payroll_entry_recurring`.`recurring_id` as record_id, 
	`ww_payroll_entry_recurring`.`created_on` as "payroll_entry_recurring.created_on", 
	`ww_payroll_entry_recurring`.`created_by` as "payroll_entry_recurring.created_by", 
	`ww_payroll_entry_recurring`.`modified_on` as "payroll_entry_recurring.modified_on", 
	`ww_payroll_entry_recurring`.`modified_by` as "payroll_entry_recurring.modified_by", 
	ww_payroll_entry_recurring.document_no as "payroll_entry_recurring.document_no", 
	ww_payroll_entry_recurring.transaction_id as "payroll_entry_recurring.transaction_id", 
	DATE_FORMAT(ww_payroll_entry_recurring.date_from, \'%M %d, %Y\') as "payroll_entry_recurring.date_from", 
	DATE_FORMAT(ww_payroll_entry_recurring.date_to,\'%M %d, %Y\') as "payroll_entry_recurring.date_to", 
	ww_payroll_entry_recurring.transaction_method_id as "payroll_entry_recurring.transaction_method_id", 
	ww_payroll_entry_recurring.account_id as "payroll_entry_recurring.account_id", 
	ww_payroll_entry_recurring.week as "payroll_entry_recurring.week", 
	AES_DECRYPT( ww_payroll_entry_recurring.amount, encryption_key()) as "payroll_entry_recurring.amount", 
	ww_payroll_entry_recurring.remarks as "payroll_entry_recurring.remarks"
FROM (`ww_payroll_entry_recurring`)
WHERE `ww_payroll_entry_recurring`.`recurring_id` = "{$record_id}"';