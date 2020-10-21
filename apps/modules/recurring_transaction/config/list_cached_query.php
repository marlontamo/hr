<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_entry_recurring`.`recurring_id` as record_id, 
	ww_payroll_entry_recurring.document_no as "payroll_entry_recurring_document_no", 
	CONCAT(DATE_FORMAT(ww_payroll_entry_recurring.date_from, \'%M %d, %Y\'), \' to \',
	 DATE_FORMAT(ww_payroll_entry_recurring.date_to, \'%M %d, %Y\')) as "payroll_entry_recurring_date", 
	 T4.payroll_transaction_method as "payroll_entry_recurring_transaction_method_id",
	 ww_payroll_entry_recurring.week as "payroll_entry_recurring_week", 
	 AES_DECRYPT(ww_payroll_entry_recurring.amount, encryption_key()) as "payroll_entry_recurring_amount",
	 ww_payroll_entry_recurring.remarks as "payroll_entry_recurring_remarks", 
	 get_recurring_total( `ww_payroll_entry_recurring`.`recurring_id` ) as "payroll_entry_recurring_total",
	 `ww_payroll_entry_recurring`.`created_on` as "payroll_entry_recurring_created_on", 
	 `ww_payroll_entry_recurring`.`created_by` as "payroll_entry_recurring_created_by", 
	 `ww_payroll_entry_recurring`.`modified_on` as "payroll_entry_recurring_modified_on", 
	 `ww_payroll_entry_recurring`.`modified_by` as "payroll_entry_recurring_modified_by"
FROM (`ww_payroll_entry_recurring`)
LEFT JOIN `ww_payroll_transaction_method` T4 ON `T4`.`payroll_transaction_method_id` = `ww_payroll_entry_recurring`.`transaction_method_id`
WHERE (
	ww_payroll_entry_recurring.document_no like "%{$search}%" OR 
	DATE_FORMAT(ww_payroll_entry_recurring.date_from, \'%M %d, %Y\') like "%{$search}%" OR 
	DATE_FORMAT(ww_payroll_entry_recurring.date_to, \'%M %d, %Y\') like "%{$search}%" OR 
	T4.payroll_transaction_method like "%{$search}%" OR 
	ww_payroll_entry_recurring.week like "%{$search}%" OR 
	ww_payroll_entry_recurring.amount like "%{$search}%" OR 
	ww_payroll_entry_recurring.remarks like "%{$search}%"
)';