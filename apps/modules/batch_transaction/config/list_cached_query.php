<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_entry_batch`.`batch_entry_id` as record_id, ww_payroll_entry_batch.document_no as "payroll_entry_batch_document_no", DATE_FORMAT(ww_payroll_entry_batch.payroll_date, \'%M %d, %Y\') as "payroll_entry_batch_payroll_date", ww_payroll_entry_batch.unit_rate_main as "payroll_entry_batch_unit_rate_main", ww_payroll_entry_batch.remarks as "payroll_entry_batch_remarks", `ww_payroll_entry_batch`.`created_on` as "payroll_entry_batch_created_on", `ww_payroll_entry_batch`.`created_by` as "payroll_entry_batch_created_by", `ww_payroll_entry_batch`.`modified_on` as "payroll_entry_batch_modified_on", `ww_payroll_entry_batch`.`modified_by` as "payroll_entry_batch_modified_by"
FROM (`ww_payroll_entry_batch`)
WHERE (
	ww_payroll_entry_batch.document_no like "%{$search}%" OR 
	DATE_FORMAT(ww_payroll_entry_batch.payroll_date, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_payroll_entry_batch.unit_rate_main like "%{$search}%" OR 
	ww_payroll_entry_batch.remarks like "%{$search}%"
)';