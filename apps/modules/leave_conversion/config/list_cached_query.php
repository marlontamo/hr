<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
	`ww_payroll_leave_conversion`.`leave_conversion_id` as record_id, 
	`ww_users_company`.`company_code` as "payroll_leave_conversion_company_id", 
	GROUP_CONCAT(CONCAT(`ww_partners_employment_type`.`employment_type`) SEPARATOR "<br> ") AS "payroll_leave_conversion_employment_type_id",
	`ww_time_form`.`form` as "payroll_leave_conversion_form_id", 
	`ww_payroll_leave_conversion`.`convertible` as "payroll_leave_conversion_convertible", 
	`ww_payroll_leave_conversion`.`nontax` as "payroll_leave_conversion_nontax", 
	`ww_payroll_leave_conversion`.`taxable` as "payroll_leave_conversion_taxable", 
	`ww_payroll_leave_conversion`.`carry_over` as "payroll_leave_conversion_carry_over", 
	`ww_payroll_leave_conversion`.`forfeited` as "payroll_leave_conversion_forfeited", 
	`ww_payroll_leave_conversion`.`description` as "payroll_leave_conversion_description", 
	`ww_payroll_leave_conversion`.`created_on` as "payroll_leave_conversion_created_on", 
	`ww_payroll_leave_conversion`.`created_by` as "payroll_leave_conversion_created_by", 
	`ww_payroll_leave_conversion`.`modified_on` as "payroll_leave_conversion_modified_on", 
	`ww_payroll_leave_conversion`.`modified_by` as "payroll_leave_conversion_modified_by",
	`ww_payroll_leave_conversion`.`can_delete` as "can_delete"
FROM (`ww_payroll_leave_conversion`)
LEFT JOIN `ww_time_form` ON `ww_time_form`.`form_id` = `ww_payroll_leave_conversion`.`form_id`
LEFT JOIN `ww_users_company` ON `ww_users_company`.`company_id` = `ww_payroll_leave_conversion`.`company_id`
LEFT JOIN `ww_partners_employment_type` ON FIND_IN_SET(`ww_partners_employment_type`.`employment_type_id`,`ww_payroll_leave_conversion`.`employment_type_id`)
WHERE (
	`ww_payroll_leave_conversion`.`description` like "%{$search}%" OR 
	`ww_payroll_leave_conversion`.`forfeited` like "%{$search}%" OR 
	`ww_payroll_leave_conversion`.`convertible` like "%{$search}%" OR 
	`ww_payroll_leave_conversion`.`nontax` like "%{$search}%" OR 
	`ww_payroll_leave_conversion`.`taxable` like "%{$search}%" OR 
	`ww_payroll_leave_conversion`.`carry_over` like "%{$search}%" OR
	`ww_time_form`.`form` like "%{$search}%" OR 
	`ww_users_company`.`company_code` like "%{$search}%" OR 
	`ww_partners_employment_type`.`employment_type` like "%{$search}%"
)';