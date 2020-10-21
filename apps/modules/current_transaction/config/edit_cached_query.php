<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT 
`ww_payroll_current_transaction`.`id` as record_id, 
`ww_payroll_current_transaction`.`created_on` as "payroll_current_transaction.created_on", 
`ww_payroll_current_transaction`.`created_by` as "payroll_current_transaction.created_by", 
`ww_payroll_current_transaction`.`modified_on` as "payroll_current_transaction.modified_on", 
`ww_payroll_current_transaction`.`modified_by` as "payroll_current_transaction.modified_by", 
ww_payroll_current_transaction.remarks as "payroll_current_transaction.remarks", 
ww_payroll_current_transaction.on_hold as "payroll_current_transaction.on_hold", 
CAST( IFNULL(AES_DECRYPT( ww_payroll_current_transaction.amount, encryption_key()),0) AS CHAR) as "payroll_current_transaction.amount", 
CAST( IFNULL(AES_DECRYPT( ww_payroll_current_transaction.unit_rate, encryption_key()),0) AS CHAR) as "payroll_current_transaction.unit_rate", 
CAST( IFNULL(AES_DECRYPT( ww_payroll_current_transaction.quantity, encryption_key()),0) AS CHAR) as "payroll_current_transaction.quantity", 
DATE_FORMAT(ww_payroll_current_transaction.payroll_date, \'%M %d, %Y\') as "payroll_current_transaction.payroll_date",
ww_payroll_current_transaction.employee_id as "payroll_current_transaction.employee_id",
ww_payroll_current_transaction.processing_type_id as "payroll_current_transaction.processing_type_id", 
ww_payroll_current_transaction.transaction_id as "payroll_current_transaction.transaction_id"
FROM (`ww_payroll_current_transaction`)
WHERE `ww_payroll_current_transaction`.`id` = "{$record_id}"';