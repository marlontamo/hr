<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query_custom"] = '
SELECT `ww_payroll_period`.`payroll_period_id` as record_id, 
CONCAT(DATE_FORMAT(ww_payroll_period.date_from, \'%b %e\'), \' - \', DATE_FORMAT(ww_payroll_period.date_to, \'%b %e\')) as "payroll_period_date", 
DATE_FORMAT(ww_payroll_period.payroll_date, \'%M-%d\') as "payroll_period_payroll_date",
DATE_FORMAT(ww_payroll_period.payroll_date, \'%Y\') as "payroll_period_payroll_date_year",
DATE_FORMAT(ww_payroll_period.payroll_date, \'%w\') as "payroll_period_payroll_date_day", 
LEFT(DAYNAME(ww_payroll_period.payroll_date),3) as "payroll_period_payroll_date_dayname", 
T3.apply_to as "payroll_period_apply_to_id", 
T4.period_processing_type as "payroll_period_period_processing_type_id", 
T5.payroll_schedule as "payroll_period_payroll_schedule_id", 
T6.week as "payroll_period_week", 
T7.period_status as "payroll_period_period_status_id",
T7.period_status_id as "payroll_period_period_status_id_id", 
ww_payroll_period.remarks as "payroll_period_remarks", 
`ww_payroll_period`.`created_on` as "payroll_period_created_on", 
`ww_payroll_period`.`created_by` as "payroll_period_created_by", 
`ww_payroll_period`.`modified_on` as "payroll_period_modified_on", 
`ww_payroll_period`.`modified_by` as "payroll_period_modified_by"
FROM (`ww_payroll_period`)
LEFT JOIN `ww_payroll_apply_to` T3 ON `T3`.`apply_to_id` = `ww_payroll_period`.`apply_to_id`
LEFT JOIN `ww_payroll_period_processing_type` T4 ON `T4`.`period_processing_type_id` = `ww_payroll_period`.`period_processing_type_id`
LEFT JOIN `ww_payroll_schedule` T5 ON `T5`.`payroll_schedule_id` = `ww_payroll_period`.`payroll_schedule_id`
LEFT JOIN `ww_payroll_week` T6 ON `T6`.`week_id` = `ww_payroll_period`.`week`
LEFT JOIN `ww_payroll_period_status` T7 ON `T7`.`period_status_id` = `ww_payroll_period`.`period_status_id`
WHERE (
	DATE_FORMAT(ww_payroll_period.date_from, \'%M %d, %Y\') like "%{$search}%" OR 
	DATE_FORMAT(ww_payroll_period.date_to, \'%M %d, %Y\') like "%{$search}%" OR 
	DATE_FORMAT(ww_payroll_period.payroll_date, \'%M %d, %Y\') like "%{$search}%" OR 
	T3.apply_to like "%{$search}%" OR 
	T4.period_processing_type like "%{$search}%" OR 
	T5.payroll_schedule like "%{$search}%" OR 
	T6.week like "%{$search}%" OR 
	T7.period_status like "%{$search}%" OR 
	ww_payroll_period.remarks like "%{$search}%"
)';
