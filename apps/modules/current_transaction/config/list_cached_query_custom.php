<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query_custom"] = 'SELECT `ww_payroll_current_transaction`.`id` as record_id, 
ww_payroll_current_transaction.remarks as "payroll_current_transaction_remarks", 
IF(ww_payroll_current_transaction.on_hold = 1, "Yes", "No") as "payroll_current_transaction_on_hold", 
IFNULL(AES_DECRYPT(ww_payroll_current_transaction.amount, encryption_key()),0) as "payroll_current_transaction_amount", 
IFNULL(AES_DECRYPT(ww_payroll_current_transaction.unit_rate, encryption_key()),0) as "payroll_current_transaction_unit_rate", 
IFNULL(AES_DECRYPT(ww_payroll_current_transaction.quantity, encryption_key()),0) as "payroll_current_transaction_quantity", 
DATE_FORMAT(ww_payroll_current_transaction.payroll_date, \'%M-%d\') as "payroll_current_transaction_payroll_date",
DATE_FORMAT(ww_payroll_current_transaction.payroll_date, \'%Y\') as "payroll_current_transaction_payroll_date_year",
DATE_FORMAT(ww_payroll_current_transaction.payroll_date, \'%w\') as "payroll_current_transaction_payroll_date_day", 
T2.full_name as "payroll_current_transaction_employee_id", 
T1.period_processing_type as "payroll_current_transaction_processing_type_id",
T3.id_number as "payroll_current_transaction_id_number", 
T4.transaction_label as "payroll_current_transaction_transaction_label", 
`ww_payroll_current_transaction`.`created_on` as "payroll_current_transaction_created_on", 
`ww_payroll_current_transaction`.`created_by` as "payroll_current_transaction_created_by", 
`ww_payroll_current_transaction`.`modified_on` as "payroll_current_transaction_modified_on", 
`ww_payroll_current_transaction`.`modified_by` as "payroll_current_transaction_modified_by"
FROM (`ww_payroll_current_transaction`)
LEFT JOIN `ww_users` T2 ON `T2`.`user_id` = `ww_payroll_current_transaction`.`employee_id`
LEFT JOIN `ww_payroll_period_processing_type` T1 ON `T1`.`period_processing_type_id` = `ww_payroll_current_transaction`.`processing_type_id`
LEFT JOIN `ww_partners` T3 ON `T3`.`user_id` = `ww_payroll_current_transaction`.`employee_id`
LEFT JOIN `ww_payroll_transaction` T4 ON `T4`.`transaction_id` = `ww_payroll_current_transaction`.`transaction_id`
LEFT JOIN `ww_payroll_partners` T5 ON `T5`.`user_id` = `ww_payroll_current_transaction`.`employee_id`
WHERE (
	ww_payroll_current_transaction.remarks like "%{$search}%" OR 
	IF(ww_payroll_current_transaction.on_hold = 1, "Yes", "No") like "%{$search}%" OR 
	ww_payroll_current_transaction.amount like "%{$search}%" OR 
	ww_payroll_current_transaction.unit_rate like "%{$search}%" OR 
	ww_payroll_current_transaction.quantity like "%{$search}%" OR 
	DATE_FORMAT(ww_payroll_current_transaction.payroll_date, \'%M %d, %Y\') like "%{$search}%" OR 
	T2.full_name like "%{$search}%" OR 
	T1.period_processing_type like "%{$search}%" OR
	T3.id_number like "%{$search}%"
)';