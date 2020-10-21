<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_account`.`account_id` as record_id, 
ww_payroll_account.arrangement as "payroll_account_arrangement", 
ww_payroll_account.account_code as "payroll_account_account_code", 
ww_payroll_account.account_name as "payroll_account_account_name", 
T3.account_type as "payroll_account_account_type_id", 
ww_payroll_account.description as "payroll_account_description", 
`ww_payroll_account`.`created_on` as "payroll_account_created_on", 
`ww_payroll_account`.`created_by` as "payroll_account_created_by", 
`ww_payroll_account`.`modified_on` as "payroll_account_modified_on", 
`ww_payroll_account`.`modified_by` as "payroll_account_modified_by",
`ww_payroll_account`.`can_delete` as "can_delete"
FROM (`ww_payroll_account`)
LEFT JOIN `ww_payroll_account_type` T3 ON `T3`.`account_type_id` = `ww_payroll_account`.`account_type_id`
WHERE (
	ww_payroll_account.arrangement like "%{$search}%" OR 
	ww_payroll_account.account_code like "%{$search}%" OR 
	ww_payroll_account.account_name like "%{$search}%" OR 
	T3.account_type like "%{$search}%" OR 
	ww_payroll_account.description like "%{$search}%"
)';