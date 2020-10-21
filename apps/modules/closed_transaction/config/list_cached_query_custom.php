<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query_custom"] = 'SELECT `ww_payroll_closed_transaction`.`id` as record_id, 
T1.full_name as "payroll_closed_transaction_employee_id", 
DATE_FORMAT(ww_payroll_closed_transaction.payroll_date, \'%M %d, %Y\') as "payroll_closed_transaction_payroll_date",
DATE_FORMAT(ww_payroll_closed_transaction.payroll_date, \'%Y\') as "payroll_closed_transaction_payroll_date_year",
DATE_FORMAT(ww_payroll_closed_transaction.payroll_date, \'%w\') as "payroll_closed_transaction_payroll_date_day", 
CAST( AES_DECRYPT( ww_payroll_closed_transaction.quantity, encryption_key()) AS CHAR) as "payroll_closed_transaction_quantity", 
CAST( AES_DECRYPT( ww_payroll_closed_transaction.unit_rate, encryption_key()) AS CHAR) as "payroll_closed_transaction_unit_rate",
CAST( AES_DECRYPT( ww_payroll_closed_transaction.amount, encryption_key()) AS CHAR) as "payroll_closed_transaction_amount", 
ww_payroll_closed_transaction.remarks as "payroll_closed_transaction_remarks",
T2.id_number as "payroll_closed_transaction_id_number",
T3.transaction_label as "payroll_closed_transaction_transaction_label", 
`ww_payroll_closed_transaction`.`created_on` as "payroll_closed_transaction_created_on", 
`ww_payroll_closed_transaction`.`created_by` as "payroll_closed_transaction_created_by", 
`ww_payroll_closed_transaction`.`modified_on` as "payroll_closed_transaction_modified_on", 
`ww_payroll_closed_transaction`.`modified_by` as "payroll_closed_transaction_modified_by"
FROM (`ww_payroll_closed_transaction`)
LEFT JOIN `ww_users` T1 ON `T1`.`user_id` = `ww_payroll_closed_transaction`.`employee_id`
LEFT JOIN `ww_partners` T2 ON `T2`.`user_id` = `ww_payroll_closed_transaction`.`employee_id`
LEFT JOIN `ww_payroll_transaction` T3 ON `T3`.`transaction_id` = `ww_payroll_closed_transaction`.`transaction_id`
LEFT JOIN `ww_payroll_partners` T4 ON `T4`.`user_id` = `ww_payroll_closed_transaction`.`employee_id`
WHERE (
	T1.full_name like "%{$search}%" OR 
	DATE_FORMAT(ww_payroll_closed_transaction.payroll_date, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_payroll_closed_transaction.quantity like "%{$search}%" OR 
	ww_payroll_closed_transaction.unit_rate like "%{$search}%" OR 
	ww_payroll_closed_transaction.amount like "%{$search}%" OR 
	ww_payroll_closed_transaction.remarks like "%{$search}%"
)';