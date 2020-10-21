<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_late_exemption`.`payroll_late_exemption_id` as record_id, 
ww_payroll_late_exemption.lates_exemption as "payroll_late_exemption_lates_exemption", 
T2.employment_type as "payroll_late_exemption_employment_type_id", 
T1.company as "payroll_late_exemption_company_id", 
`ww_payroll_late_exemption`.`created_on` as "payroll_late_exemption_created_on", 
`ww_payroll_late_exemption`.`created_by` as "payroll_late_exemption_created_by", 
`ww_payroll_late_exemption`.`modified_on` as "payroll_late_exemption_modified_on", 
`ww_payroll_late_exemption`.`modified_by` as "payroll_late_exemption_modified_by"
FROM (`ww_payroll_late_exemption`)
LEFT JOIN `ww_partners_employment_type` T2 ON `T2`.`employment_type_id` = `ww_payroll_late_exemption`.`employment_type_id`
LEFT JOIN `ww_users_company` T1 ON `T1`.`company_id` = `ww_payroll_late_exemption`.`company_id`
WHERE (
	ww_payroll_late_exemption.lates_exemption like "%{$search}%" OR 
	T2.employment_type_id like "%{$search}%" OR 
	T1.company like "%{$search}%"
)';