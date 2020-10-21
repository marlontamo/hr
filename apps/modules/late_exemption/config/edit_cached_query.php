<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_payroll_late_exemption`.`payroll_late_exemption_id` as record_id, 
`ww_payroll_late_exemption`.`created_on` as "payroll_late_exemption.created_on", 
`ww_payroll_late_exemption`.`created_by` as "payroll_late_exemption.created_by", 
`ww_payroll_late_exemption`.`modified_on` as "payroll_late_exemption.modified_on", 
`ww_payroll_late_exemption`.`modified_by` as "payroll_late_exemption.modified_by", 
ww_payroll_late_exemption.lates_exemption as "payroll_late_exemption.lates_exemption", 
ww_payroll_late_exemption.employment_type_id as "payroll_late_exemption.employment_type_id", 
ww_payroll_late_exemption.company_id as "payroll_late_exemption.company_id"
FROM (`ww_payroll_late_exemption`)
WHERE `ww_payroll_late_exemption`.`payroll_late_exemption_id` = "{$record_id}"';