<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_time_holiday`.`holiday_id` as record_id, ww_time_holiday.holiday as "time_holiday_holiday", DATE_FORMAT(ww_time_holiday.holiday_date, \'%M %d, %Y\') as "time_holiday_holiday_date", IF(ww_time_holiday.legal = 1, "Yes", "No") as "time_holiday_legal", `ww_time_holiday`.`created_on` as "time_holiday_created_on", `ww_time_holiday`.`created_by` as "time_holiday_created_by", `ww_time_holiday`.`modified_on` as "time_holiday_modified_on", `ww_time_holiday`.`modified_by` as "time_holiday_modified_by"
FROM (`ww_time_holiday`)
WHERE (
	ww_time_holiday.holiday like "%{$search}%" OR 
	DATE_FORMAT(ww_time_holiday.holiday_date, \'%M %d, %Y\') like "%{$search}%" OR 
	IF(ww_time_holiday.legal = 1, "Yes", "No") like "%{$search}%"
)';