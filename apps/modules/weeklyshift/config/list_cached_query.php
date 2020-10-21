<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_time_shift_weekly`.`calendar_id` as record_id, ww_time_shift_weekly.calendar as "time_shift_weekly_calendar", ww_time_shift_weekly.workingdays as "time_shift_weekly_workingdays", ww_time_shift_weekly.restdays as "time_shift_weekly_restdays", `ww_time_shift_weekly`.`created_on` as "time_shift_weekly_created_on", `ww_time_shift_weekly`.`created_by` as "time_shift_weekly_created_by", `ww_time_shift_weekly`.`modified_on` as "time_shift_weekly_modified_on", `ww_time_shift_weekly`.`modified_by` as "time_shift_weekly_modified_by"
FROM (`ww_time_shift_weekly`)
WHERE (
	ww_time_shift_weekly.calendar like "%{$search}%"
)';