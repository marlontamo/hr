<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_time_record_summary`.`record_id` as record_id, T4.day_type as "time_record_summary_day_type", ww_time_record_summary.ot as "time_record_summary_ot", ww_time_record_summary.undertime as "time_record_summary_undertime", ww_time_record_summary.late as "time_record_summary_late", ww_time_record_summary.lwop as "time_record_summary_lwop", ww_time_record_summary.lwp as "time_record_summary_lwp", IF(ww_time_record_summary.absent = 1, "Yes", "No") as "time_record_summary_absent", ww_time_record_summary.hrs_actual as "time_record_summary_hrs_actual", DATE_FORMAT(ww_time_record_summary.payroll_date, \'%M %d, %Y\') as "time_record_summary_payroll_date", DATE_FORMAT(ww_time_record_summary.date, \'%M %d, %Y\') as "time_record_summary_date", T1.full_name as "time_record_summary_user_id", `ww_time_record_summary`.`created_on` as "time_record_summary_created_on", `ww_time_record_summary`.`created_by` as "time_record_summary_created_by", `ww_time_record_summary`.`modified_on` as "time_record_summary_modified_on", `ww_time_record_summary`.`modified_by` as "time_record_summary_modified_by"
FROM (`ww_time_record_summary`)
LEFT JOIN `ww_time_day_type` T4 ON `T4`.`day_type_code` = `ww_time_record_summary`.`day_type`
LEFT JOIN `ww_users` T1 ON `T1`.`user_id` = `ww_time_record_summary`.`user_id`
WHERE (
	T4.day_type like "%{$search}%" OR 
	ww_time_record_summary.ot like "%{$search}%" OR 
	ww_time_record_summary.undertime like "%{$search}%" OR 
	ww_time_record_summary.late like "%{$search}%" OR 
	ww_time_record_summary.lwop like "%{$search}%" OR 
	ww_time_record_summary.lwp like "%{$search}%" OR 
	IF(ww_time_record_summary.absent = 1, "Yes", "No") like "%{$search}%" OR 
	ww_time_record_summary.hrs_actual like "%{$search}%" OR 
	DATE_FORMAT(ww_time_record_summary.payroll_date, \'%M %d, %Y\') like "%{$search}%" OR 
	DATE_FORMAT(ww_time_record_summary.date, \'%M %d, %Y\') like "%{$search}%" OR 
	T1.full_name like "%{$search}%"
)';