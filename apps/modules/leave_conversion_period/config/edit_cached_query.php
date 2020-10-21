<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_payroll_leave_conversion_period`.`leave_conversion_period_id` as record_id, 
`ww_payroll_leave_conversion_period`.`created_on` as "payroll_leave_conversion_period.created_on", 
`ww_payroll_leave_conversion_period`.`created_by` as "payroll_leave_conversion_period.created_by", 
`ww_payroll_leave_conversion_period`.`modified_on` as "payroll_leave_conversion_period.modified_on", 
`ww_payroll_leave_conversion_period`.`modified_by` as "payroll_leave_conversion_period.modified_by", 
`ww_payroll_leave_conversion_period`.`leave_conversion_period_id` as "payroll_leave_conversion_period.leave_conversion_period_id", 
`ww_payroll_leave_conversion_period`.`status` as "payroll_leave_conversion_period.status_id", 
ww_payroll_period_status.period_status AS "payroll_leave_conversion_period.status", 
`ww_payroll_leave_conversion_period_apply_to`.`apply_to` as "payroll_leave_conversion_period.apply_to", 
`ww_payroll_leave_conversion_period`.`apply_to_id` as "payroll_leave_conversion_period.apply_to_id", 
ww_payroll_leave_conversion_period.year as "payroll_leave_conversion_period.year", 
ww_payroll_leave_conversion_period.remarks as "payroll_leave_conversion_period.remarks", 
DATE_FORMAT(ww_payroll_leave_conversion_period.payroll_date, \'%M %d, %Y\') as "payroll_leave_conversion_period.payroll_date",
ww_time_form.`form_id` AS "payroll_leave_conversion_period.form_id", 
ww_time_form.`form` AS "payroll_leave_conversion_period.form", 
nt.transaction_id AS "payroll_leave_conversion_period.nontax_leave_id", 
nt.`transaction_label` AS "payroll_leave_conversion_period.nontax_leave", 
t.transaction_id AS "payroll_leave_conversion_period.taxable_leave_id", 
t.`transaction_label` AS "payroll_leave_conversion_period.taxable_leave"

FROM (`ww_payroll_leave_conversion_period`)
LEFT JOIN `ww_payroll_leave_conversion_period_apply_to`
	ON `ww_payroll_leave_conversion_period_apply_to`.`leave_conversion_id` = `ww_payroll_leave_conversion_period`.`leave_conversion_period_id`
LEFT JOIN ww_payroll_period_status ON
	`ww_payroll_leave_conversion_period`.`status` = ww_payroll_period_status.period_status_id 
LEFT JOIN ww_time_form ON
	`ww_payroll_leave_conversion_period`.`form_id` = ww_time_form.`form_id`
LEFT JOIN ww_payroll_transaction nt ON
	`ww_payroll_leave_conversion_period`.`nontax_leave_id` = nt.transaction_id
LEFT JOIN ww_payroll_transaction t ON
	`ww_payroll_leave_conversion_period`.`taxable_leave_id` = t.transaction_id

WHERE `ww_payroll_leave_conversion_period`.`leave_conversion_period_id` = "{$record_id}"';