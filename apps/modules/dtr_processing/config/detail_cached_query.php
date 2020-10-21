<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT `ww_time_period`.`period_id` as record_id, 
DATE_FORMAT(ww_time_period.payroll_date, \'%M %d, %Y\') as "time_period_payroll_date", 
CONCAT(DATE_FORMAT(ww_time_period.date_from, \'%M %d, %Y\'), \' to \', 
	DATE_FORMAT(ww_time_period.date_to, \'%M %d, %Y\')) as "time_period_date", 
ww_users_project.project as "time_period_project_id", 
ww_users_company.company as "time_period_company_id", 
DATE_FORMAT(ww_time_period.cutoff, \'%M %d, %Y\') as "time_period_cutoff", 
DATE_FORMAT(ww_time_period.previous_cutoff, \'%M %d, %Y\') as "time_period_previous_cutoff", 
`ww_time_period`.`created_on` as "time_period_created_on", 
`ww_time_period`.`created_by` as "time_period_created_by", 
`ww_time_period`.`modified_on` as "time_period_modified_on", 
`ww_time_period`.`modified_by` as "time_period_modified_by", 
DATE_FORMAT(ww_time_period.payroll_date, \'%M %d, %Y\') as "time_period_payroll_date", 
CONCAT(DATE_FORMAT(ww_time_period.date_from, \'%M %d, %Y\'), \' to \', 
DATE_FORMAT(ww_time_period.date_to, \'%M %d, %Y\')) as "time_period_date", 
ww_users_project.project as "time_period_project_id", 
DATE_FORMAT(ww_time_period.cutoff, \'%M %d, %Y\') as "time_period_cutoff", 
DATE_FORMAT(ww_time_period.previous_cutoff, \'%M %d, %Y\') as "time_period_previous_cutoff"
FROM (`ww_time_period`)
LEFT JOIN `ww_users_project` ON `ww_users_project`.`project_id` = `ww_time_period`.`project_id`
LEFT JOIN `ww_users_company` ON `ww_users_company`.`company_id` = `ww_time_period`.`company_id`
WHERE `ww_time_period`.`period_id` = "{$record_id}"';