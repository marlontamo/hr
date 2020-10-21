<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_time_period`.`period_id` as record_id, 
`ww_time_period`.`created_on` as "time_period.created_on", 
`ww_time_period`.`created_by` as "time_period.created_by", 
`ww_time_period`.`modified_on` as "time_period.modified_on", 
`ww_time_period`.`modified_by` as "time_period.modified_by", 
DATE_FORMAT(ww_time_period.payroll_date, \'%M %d, %Y\') as "time_period.payroll_date", 
DATE_FORMAT(ww_time_period.date_from, \'%M %d, %Y\') as "time_period.date_from", 
DATE_FORMAT(ww_time_period.date_to,\'%M %d, %Y\') as "time_period.date_to", 
ww_time_period.project_id as "time_period.project_id", 
ww_time_period.company_id as "time_period.company_id", 
ww_time_period.apply_to_id as "time_period.apply_to_id", 
DATE_FORMAT(ww_time_period.cutoff, \'%M %d, %Y\') as "time_period.cutoff", 
DATE_FORMAT(ww_time_period.previous_cutoff, \'%M %d, %Y\') as "time_period.previous_cutoff"
FROM (`ww_time_period`)
WHERE `ww_time_period`.`period_id` = "{$record_id}"';