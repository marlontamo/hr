<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_account_sub`.`account_sub_id` as record_id, 
ww_payroll_account_sub.account_sub as "payroll_account_sub_account_sub", 
ww_payroll_account_sub.account_sub_code as "payroll_account_sub_account_sub_code", 
T4.category as "payroll_account_sub_category_id", 
ww_payroll_account_sub.category_value as "payroll_account_sub_category_value", 
T3.account_name as "payroll_account_sub_account_id", 
`ww_payroll_account_sub`.`created_on` as "payroll_account_sub_created_on", 
`ww_payroll_account_sub`.`created_by` as "payroll_account_sub_created_by", 
`ww_payroll_account_sub`.`modified_on` as "payroll_account_sub_modified_on", 
`ww_payroll_account_sub`.`modified_by` as "payroll_account_sub_modified_by",
`ww_payroll_account_sub`.`can_delete` as "can_delete"
FROM (`ww_payroll_account_sub`)
LEFT JOIN `ww_payroll_account_category` T4 ON `T4`.`category_id` = `ww_payroll_account_sub`.`category_id`
LEFT JOIN `ww_payroll_account` T3 ON `T3`.`account_id` = `ww_payroll_account_sub`.`account_id`
WHERE (
	ww_payroll_account_sub.account_sub like "%{$search}%" OR 
	ww_payroll_account_sub.account_sub_code like "%{$search}%" OR 
	T4.category like "%{$search}%" OR 
	T3.account_name like "%{$search}%"
)';