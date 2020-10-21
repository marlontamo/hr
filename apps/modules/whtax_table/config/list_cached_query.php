<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_whtax_table`.`whtax_id` as record_id, 
T1.payroll_schedule as "payroll_whtax_table_payroll_schedule_id", 
T2.taxcode as "payroll_whtax_table_taxcode_id", 
ww_payroll_whtax_table.salary_from as "payroll_whtax_table_salary_from", 
ww_payroll_whtax_table.salary_to as "payroll_whtax_table_salary_to", 
ww_payroll_whtax_table.fixed_amount as "payroll_whtax_table_fixed_amount", 
ww_payroll_whtax_table.excess_percentage as "payroll_whtax_table_excess_percentage", 
`ww_payroll_whtax_table`.`created_on` as "payroll_whtax_table_created_on", 
`ww_payroll_whtax_table`.`created_by` as "payroll_whtax_table_created_by", 
`ww_payroll_whtax_table`.`modified_on` as "payroll_whtax_table_modified_on", 
`ww_payroll_whtax_table`.`modified_by` as "payroll_whtax_table_modified_by"
FROM (`ww_payroll_whtax_table`)
LEFT JOIN `ww_payroll_schedule` T1 ON `T1`.`payroll_schedule_id` = `ww_payroll_whtax_table`.`payroll_schedule_id`
LEFT JOIN `ww_taxcode` T2 ON `T2`.`taxcode_id` = `ww_payroll_whtax_table`.`taxcode_id`
WHERE (
	T1.payroll_schedule like "%{$search}%" OR 
	T2.taxcode like "%{$search}%" OR 
	ww_payroll_whtax_table.salary_from like "%{$search}%" OR 
	ww_payroll_whtax_table.salary_to like "%{$search}%" OR 
	ww_payroll_whtax_table.fixed_amount like "%{$search}%" OR 
	ww_payroll_whtax_table.excess_percentage like "%{$search}%"
)';