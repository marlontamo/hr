<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_annual_tax`.`annual_tax_id` as record_id, ww_payroll_annual_tax.salary_from as "payroll_annual_tax_salary_from", ww_payroll_annual_tax.salary_to as "payroll_annual_tax_salary_to", ww_payroll_annual_tax.amount as "payroll_annual_tax_amount", ww_payroll_annual_tax.rate as "payroll_annual_tax_rate", `ww_payroll_annual_tax`.`created_on` as "payroll_annual_tax_created_on", `ww_payroll_annual_tax`.`created_by` as "payroll_annual_tax_created_by", `ww_payroll_annual_tax`.`modified_on` as "payroll_annual_tax_modified_on", `ww_payroll_annual_tax`.`modified_by` as "payroll_annual_tax_modified_by"
FROM (`ww_payroll_annual_tax`)
WHERE (
	ww_payroll_annual_tax.salary_from like "%{$search}%" OR 
	ww_payroll_annual_tax.salary_to like "%{$search}%" OR 
	ww_payroll_annual_tax.amount like "%{$search}%" OR 
	ww_payroll_annual_tax.rate like "%{$search}%"
)';