<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT `ww_payroll_overtime_rates_amount`.`overtime_rate_amount_id` as record_id, 
ww_payroll_overtime_rates_amount.overtime_amount as "payroll_overtime_rates_amount_overtime_amount", 
ww_payroll_overtime.overtime as "payroll_overtime_rates_amount_overtime_id", 
ww_users_location.location as "payroll_overtime_rates_amount_overtime_location_id", 
ww_users_company.company as "payroll_overtime_rates_amount_company_id", 
ww_partners_employment_type.employment_type as "payroll_overtime_rates_amount_employment_type_id", 
`ww_payroll_overtime_rates_amount`.`created_on` as "payroll_overtime_rates_amount_created_on", 
`ww_payroll_overtime_rates_amount`.`created_by` as "payroll_overtime_rates_amount_created_by", 
`ww_payroll_overtime_rates_amount`.`modified_on` as "payroll_overtime_rates_amount_modified_on", 
`ww_payroll_overtime_rates_amount`.`modified_by` as "payroll_overtime_rates_amount_modified_by"
FROM (`ww_payroll_overtime_rates_amount`)
LEFT JOIN `ww_payroll_overtime` ON `ww_payroll_overtime`.`overtime_id` = `ww_payroll_overtime_rates_amount`.`overtime_id`
LEFT JOIN `ww_users_location` ON `ww_users_location`.`location_id` = `ww_payroll_overtime_rates_amount`.`overtime_location_id`
LEFT JOIN `ww_users_company` ON `ww_users_company`.`company_id` = `ww_payroll_overtime_rates_amount`.`company_id`
LEFT JOIN `ww_partners_employment_type` ON `ww_partners_employment_type`.`employment_type_id` = `ww_payroll_overtime_rates_amount`.`employment_type_id`
WHERE `ww_payroll_overtime_rates_amount`.`overtime_rate_amount_id` = "{$record_id}"';