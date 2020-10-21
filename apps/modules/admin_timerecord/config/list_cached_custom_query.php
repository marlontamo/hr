<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*$config["list_cached_query"] = 'SELECT `ww_time_record`.`record_id` as record_id, DATE_FORMAT(ww_time_record.date, \'%M %d, %y\') as "time_record_date", ww_time_record.user_id as "time_record_user_id", ww_time_record.shift as "time_record_shift", DATE_FORMAT(ww_time_record.time_in, \'%M %d, %y %h:%i %p\') as "time_record_time_in", DATE_FORMAT(ww_time_record.time_out, \'%M %d, %y %h:%i %p\') as "time_record_time_out", ww_time_record_summary.late as "time_record_summary_hrs_late",ww_time_record_summary.hrs_actual as "time_record_summary_hrs_actual", ww_time_record_summary.undertime as "time_record_summary_hrs_undertime", ww_time_record_summary.awol as "time_record_summary_awol", `ww_time_record`.`created_on` as "time_record_created_on", `ww_time_record`.`created_by` as "time_record_created_by", `ww_time_record`.`modified_on` as "time_record_modified_on", `ww_time_record`.`modified_by` as "time_record_modified_by"
FROM (`ww_time_record`)
LEFT JOIN `ww_time_record_summary` ON `ww_time_record_summary`.`record_id` = `ww_time_record`.`record_id`
WHERE (
ww_time_record.date like "%{$search}%" OR 
ww_time_record.user_id like "%{$search}%" OR 
ww_time_record.shift like "%{$search}%" OR 
ww_time_record.time_in like "%{$search}%" OR 
ww_time_record.time_out like "%{$search}%" OR 
ww_time_record_summary.hrs_actual like "%{$search}%" OR
ww_time_record_summary.late like "%{$search}%" OR 
ww_time_record_summary.undertime like "%{$search}%" OR 
ww_time_record_summary.awol like "%{$search}%"
)';*/

$config["list_cached_query"] = 'SELECT * FROM (`time_record_list`)
WHERE (
date like "%{$search}%")';