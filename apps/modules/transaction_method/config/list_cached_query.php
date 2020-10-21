<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_transaction_method`.`payroll_transaction_method_id` as record_id, 
ww_payroll_transaction_method.description as "payroll_transaction_method_description", 
ww_payroll_transaction_method.payroll_transaction_method as "payroll_transaction_method_payroll_transaction_method", 
`ww_payroll_transaction_method`.`created_on` as "payroll_transaction_method_created_on", 
`ww_payroll_transaction_method`.`created_by` as "payroll_transaction_method_created_by", 
`ww_payroll_transaction_method`.`modified_on` as "payroll_transaction_method_modified_on", 
`ww_payroll_transaction_method`.`modified_by` as "payroll_transaction_method_modified_by",
`ww_payroll_transaction_method`.`can_delete` as "can_delete"
FROM (`ww_payroll_transaction_method`)
WHERE (
	ww_payroll_transaction_method.description like "%{$search}%" OR 
	ww_payroll_transaction_method.payroll_transaction_method like "%{$search}%"
)';