<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
	`ww_payroll_leave_conversion_period`.`leave_conversion_period_id` as record_id, 
	`ww_payroll_leave_conversion_period`.`apply_to_id` as "payroll_leave_conversion_period_apply_to_id", 
	ww_payroll_apply_to.apply_to as `payroll_leave_conversion_period_apply`,
	`ww_payroll_leave_conversion_period`.`remarks` as "payroll_leave_conversion_period_remarks", 
	`ww_payroll_leave_conversion_period`.`year` as "payroll_leave_conversion_period_year", 
	`ww_payroll_leave_conversion_period`.`leave_conversion_period_id` as "payroll_leave_conversion_period_leave_conversion_period_id", 
	`ww_payroll_leave_conversion_period`.`status` as "payroll_leave_conversion_period_status_id", 
	ww_payroll_period_status.period_status AS "payroll_leave_conversion_period_status", 
	DATE_FORMAT(`ww_payroll_leave_conversion_period`.`payroll_date`, \'%M %d, %Y\') as "payroll_leave_conversion_period_payroll_date", 
	ww_time_form.`form_id` AS "payroll_leave_conversion_period_form_id", 
	ww_time_form.`form` AS "payroll_leave_conversion_period_form", 
	nt.transaction_id AS "payroll_leave_conversion_period_nontax_leave_id", 
	nt.`transaction_label` AS "payroll_leave_conversion_period_nontax_leave", 
	t.transaction_id AS "payroll_leave_conversion_period_taxable_leave_id", 
	t.`transaction_label` AS "payroll_leave_conversion_period_taxable_leave", 
	
	`ww_payroll_leave_conversion_period`.`created_on` as "payroll_leave_conversion_period_created_on", 
	`ww_payroll_leave_conversion_period`.`created_by` as "payroll_leave_conversion_period_created_by", 
	`ww_payroll_leave_conversion_period`.`modified_on` as "payroll_leave_conversion_period_modified_on",
	`ww_payroll_leave_conversion_period`.`modified_by` as "payroll_leave_conversion_period_modified_by"
FROM (`ww_payroll_leave_conversion_period`)
LEFT JOIN ww_payroll_period_status ON
	`ww_payroll_leave_conversion_period`.`status` = ww_payroll_period_status.period_status_id 
LEFT JOIN ww_payroll_apply_to ON
	`ww_payroll_leave_conversion_period`.apply_to_id = ww_payroll_apply_to.apply_to_id
LEFT JOIN ww_time_form ON
	`ww_payroll_leave_conversion_period`.`form_id` = ww_time_form.`form_id`
LEFT JOIN ww_payroll_transaction nt ON
	`ww_payroll_leave_conversion_period`.`nontax_leave_id` = nt.transaction_id
LEFT JOIN ww_payroll_transaction t ON
	`ww_payroll_leave_conversion_period`.`taxable_leave_id` = t.transaction_id
WHERE (
	ww_payroll_leave_conversion_period.remarks like "%{$search}%" OR 
	ww_payroll_leave_conversion_period.year like "%{$search}%" OR 
	DATE_FORMAT(ww_payroll_leave_conversion_period.payroll_date, \'%M %d, %Y\') like "%{$search}%"
)';

