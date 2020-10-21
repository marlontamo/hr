<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_rate_type`.`payroll_rate_type_id` as record_id, 
ww_payroll_rate_type.payroll_rate_type as "payroll_rate_type_payroll_rate_type", 
ww_payroll_rate_type.description as "payroll_rate_type_description", 
`ww_payroll_rate_type`.`created_on` as "payroll_rate_type_created_on", 
`ww_payroll_rate_type`.`created_by` as "payroll_rate_type_created_by", 
`ww_payroll_rate_type`.`modified_on` as "payroll_rate_type_modified_on", 
`ww_payroll_rate_type`.`modified_by` as "payroll_rate_type_modified_by",
`ww_payroll_rate_type`.`can_delete` as "can_delete"
FROM (`ww_payroll_rate_type`)
WHERE (
	ww_payroll_rate_type.payroll_rate_type like "%{$search}%" OR 
	ww_payroll_rate_type.description like "%{$search}%"
)';