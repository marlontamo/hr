<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT 
		`ww_payroll_overtime_rates`.`overtime_rate_id` as record_id, 
		`ww_payroll_overtime_rates`.`created_on` as "payroll_overtime_rates.created_on", 
		`ww_payroll_overtime_rates`.`created_by` as "payroll_overtime_rates.created_by", 
		`ww_payroll_overtime_rates`.`modified_on` as "payroll_overtime_rates.modified_on", 
		`ww_payroll_overtime_rates`.`modified_by` as "payroll_overtime_rates.modified_by", 
		`ww_payroll_overtime_rates`.`overtime_rate` as "payroll_overtime_rates.overtime_rate", 
		`ww_payroll_overtime_rates`.`overtime_id` as "payroll_overtime_rates.overtime_id", 
		`ww_payroll_overtime_rates`.`company_id` as "payroll_overtime_rates.company_id"
FROM (`ww_payroll_overtime_rates`)
WHERE `ww_payroll_overtime_rates`.`overtime_rate_id` = "{$record_id}"';