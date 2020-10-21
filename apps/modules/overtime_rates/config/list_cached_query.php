<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
	`ww_payroll_overtime_rates`.`overtime_rate_id` as record_id, 
	`ww_payroll_overtime_rates`.`overtime_rate` as "payroll_overtime_rates_overtime_rate", 
	T2.overtime_code as "payroll_overtime_rates_overtime_code", 
	T2.overtime_id as "payroll_overtime_rates_overtime_id", 
	T1.company as "payroll_overtime_rates_company_id", 
	`ww_payroll_overtime_rates`.`created_on` as "payroll_overtime_rates_created_on", 
	`ww_payroll_overtime_rates`.`created_by` as "payroll_overtime_rates_created_by", 
	`ww_payroll_overtime_rates`.`modified_on` as "payroll_overtime_rates_modified_on", 
	`ww_payroll_overtime_rates`.`modified_by` as "payroll_overtime_rates_modified_by"
FROM (`ww_payroll_overtime_rates`)
LEFT JOIN `ww_payroll_overtime` T2 ON `T2`.`overtime_id` = `ww_payroll_overtime_rates`.`overtime_id`
LEFT JOIN `ww_users_company` T1 ON `T1`.`company_id` = `ww_payroll_overtime_rates`.`company_id`
WHERE (
	ww_payroll_overtime_rates.overtime_rate like "%{$search}%" OR 
	T2.overtime_code like "%{$search}%" OR 
	T1.company like "%{$search}%"
)';