<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_bonus`.`bonus_id` as record_id, 
DATE_FORMAT(ww_payroll_bonus.payroll_date, \'%M %d, %Y\') as "payroll_bonus_payroll_date", 
CONCAT(DATE_FORMAT(ww_payroll_bonus.date_from, \'%M %d, %Y\'), \' to \', 
DATE_FORMAT(ww_payroll_bonus.date_to, \'%M %d, %Y\')) as "payroll_bonus_date", 
ww_payroll_bonus.period as "payroll_bonus_period", 
ww_payroll_bonus.week as "payroll_bonus_week", 
T6.payroll_transaction_method_bonus as "payroll_bonus_transaction_method_id", 
ww_payroll_bonus.description as "payroll_bonus_description", 
`ww_payroll_bonus`.`created_on` as "payroll_bonus_created_on", 
`ww_payroll_bonus`.`created_by` as "payroll_bonus_created_by", 
`ww_payroll_bonus`.`modified_on` as "payroll_bonus_modified_on", 
`ww_payroll_bonus`.`modified_by` as "payroll_bonus_modified_by",
`T7`.`transaction_label` as "payroll_bonus_transaction_label"
FROM (`ww_payroll_bonus`)
LEFT JOIN `ww_payroll_transaction_method_bonus` T6 ON `T6`.`payroll_transaction_method_bonus_id` = `ww_payroll_bonus`.`transaction_method_id`
LEFT JOIN `ww_payroll_transaction` T7 ON `T7`.`transaction_id` = `ww_payroll_bonus`.`bonus_transaction_id`
WHERE (
	DATE_FORMAT(ww_payroll_bonus.payroll_date, \'%M %d, %Y\') like "%{$search}%" OR 
	DATE_FORMAT(ww_payroll_bonus.date_from, \'%M %d, %Y\') like "%{$search}%" OR 
	DATE_FORMAT(ww_payroll_bonus.date_to, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_payroll_bonus.period like "%{$search}%" OR 
	ww_payroll_bonus.week like "%{$search}%" OR 
	T6.payroll_transaction_method_bonus like "%{$search}%" OR 
	ww_payroll_bonus.description like "%{$search}%"
)';