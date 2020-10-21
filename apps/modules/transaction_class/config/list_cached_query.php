<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_transaction_class`.`transaction_class_id` as record_id, 
ww_payroll_transaction_class.transaction_class_code as "payroll_transaction_class_transaction_class_code", 
ww_payroll_transaction_class.transaction_class as "payroll_transaction_class_transaction_class", 
ww_payroll_transaction_class.description as "payroll_transaction_class_description", 
`ww_payroll_transaction_class`.`created_on` as "payroll_transaction_class_created_on", 
`ww_payroll_transaction_class`.`created_by` as "payroll_transaction_class_created_by", 
`ww_payroll_transaction_class`.`modified_on` as "payroll_transaction_class_modified_on", 
`ww_payroll_transaction_class`.`modified_by` as "payroll_transaction_class_modified_by",
`ww_payroll_transaction_class`.`can_delete` as "can_delete"
FROM (`ww_payroll_transaction_class`)
WHERE (
	ww_payroll_transaction_class.transaction_class_code like "%{$search}%" OR 
	ww_payroll_transaction_class.transaction_class like "%{$search}%" OR 
	ww_payroll_transaction_class.description like "%{$search}%"
)';