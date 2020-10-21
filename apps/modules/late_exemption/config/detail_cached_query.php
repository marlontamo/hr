<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT `ww_payroll_late_exemption`.`payroll_late_exemption_id` as record_id, 
ww_payroll_late_exemption.lates_exemption as "payroll_late_exemption_lates_exemption", 
ww_partners_employment_type.employment_type as "payroll_late_exemption_employment_type_id", 
ww_users_company.company as "payroll_late_exemption_company_id", 
`ww_payroll_late_exemption`.`created_on` as "payroll_late_exemption_created_on", 
`ww_payroll_late_exemption`.`created_by` as "payroll_late_exemption_created_by", 
`ww_payroll_late_exemption`.`modified_on` as "payroll_late_exemption_modified_on", 
`ww_payroll_late_exemption`.`modified_by` as "payroll_late_exemption_modified_by"
FROM (`ww_payroll_late_exemption`)
LEFT JOIN `ww_partners_employment_type` ON `ww_partners_employment_type`.`employment_type_id` = `ww_payroll_late_exemption`.`employment_type_id`
LEFT JOIN `ww_users_company` ON `ww_users_company`.`company_id` = `ww_payroll_late_exemption`.`company_id`
WHERE `ww_payroll_late_exemption`.`payroll_late_exemption_id` = "{$record_id}"';