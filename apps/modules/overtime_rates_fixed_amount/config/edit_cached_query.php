<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_payroll_overtime_rates_amount`.`overtime_rate_amount_id` as record_id, 
`ww_payroll_overtime_rates_amount`.`created_on` as "payroll_overtime_rates_amount.created_on", 
`ww_payroll_overtime_rates_amount`.`created_by` as "payroll_overtime_rates_amount.created_by", 
`ww_payroll_overtime_rates_amount`.`modified_on` as "payroll_overtime_rates_amount.modified_on", 
`ww_payroll_overtime_rates_amount`.`modified_by` as "payroll_overtime_rates_amount.modified_by", 
ww_payroll_overtime_rates_amount.overtime_amount as "payroll_overtime_rates_amount.overtime_amount", 
ww_payroll_overtime_rates_amount.overtime_id as "payroll_overtime_rates_amount.overtime_id", 
ww_payroll_overtime_rates_amount.overtime_location_id as "payroll_overtime_rates_amount.overtime_location_id", 
ww_payroll_overtime_rates_amount.company_id as "payroll_overtime_rates_amount.company_id", 
ww_payroll_overtime_rates_amount.employment_type_id as "payroll_overtime_rates_amount.employment_type_id"
FROM (`ww_payroll_overtime_rates_amount`)
LEFT JOIN `ww_payroll_overtime` T4 ON `T4`.`overtime_id` = `ww_payroll_overtime_rates_amount`.`overtime_id`
LEFT JOIN `ww_users_location` T3 ON `T3`.`location_id` = `ww_payroll_overtime_rates_amount`.`overtime_location_id`
LEFT JOIN `ww_users_company` T1 ON `T1`.`company_id` = `ww_payroll_overtime_rates_amount`.`company_id`
LEFT JOIN `ww_partners_employment_type` T2 ON `T2`.`employment_type_id` = `ww_payroll_overtime_rates_amount`.`employment_type_id`
WHERE `ww_payroll_overtime_rates_amount`.`overtime_rate_amount_id` = "{$record_id}"';