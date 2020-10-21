<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_overtime_rates_amount`.`overtime_rate_amount_id` as record_id, 
ww_payroll_overtime_rates_amount.overtime_amount as "ww_payroll_overtime_rates_amount_overtime_amount", 
T4.overtime as "ww_payroll_overtime_rates_amount_overtime_id", 
T4.overtime_code as "ww_payroll_overtime_rates_amount_overtime_code", 
T3.location as "ww_payroll_overtime_rates_amount_overtime_location_id", 
T1.company as "ww_payroll_overtime_rates_amount_company_id", 
T2.employment_type as "ww_payroll_overtime_rates_amount_employment_type_id", 
`ww_payroll_overtime_rates_amount`.`created_on` as "ww_payroll_overtime_rates_amount_created_on", 
`ww_payroll_overtime_rates_amount`.`created_by` as "ww_payroll_overtime_rates_amount_created_by",
`ww_payroll_overtime_rates_amount`.`modified_on` as "ww_payroll_overtime_rates_amount_modified_on", 
`ww_payroll_overtime_rates_amount`.`modified_by` as "ww_payroll_overtime_rates_amount_modified_by"
FROM (`ww_payroll_overtime_rates_amount`)
LEFT JOIN `ww_payroll_overtime` T4 ON `T4`.`overtime_id` = `ww_payroll_overtime_rates_amount`.`overtime_id`
LEFT JOIN `ww_users_location` T3 ON `T3`.`location_id` = `ww_payroll_overtime_rates_amount`.`overtime_location_id`
LEFT JOIN `ww_users_company` T1 ON `T1`.`company_id` = `ww_payroll_overtime_rates_amount`.`company_id`
LEFT JOIN `ww_partners_employment_type` T2 ON `T2`.`employment_type_id` = `ww_payroll_overtime_rates_amount`.`employment_type_id`
WHERE (
	ww_payroll_overtime_rates_amount.overtime_amount like "%{$search}%" OR 
	T4.overtime like "%{$search}%" OR 
	T3.location like "%{$search}%" OR 
	T1.company like "%{$search}%" OR 
	T2.employment_type like "%{$search}%"
)';