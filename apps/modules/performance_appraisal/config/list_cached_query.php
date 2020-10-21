<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_performance_appraisal`.`appraisal_id` as record_id, T9.filter_by as "performance_appraisal_filter_by", ww_performance_appraisal_applicable.user_id as "performance_appraisal_applicable_user_id", ww_performance_appraisal.filter_id as "performance_appraisal_filter_id", ww_performance_appraisal.notes as "performance_appraisal_notes", IF(ww_performance_appraisal.status_id = 1, "Yes", "No") as "performance_appraisal_status_id", ww_performance_appraisal.template_id as "performance_appraisal_template_id", T4.performance as "performance_appraisal_performance_type_id", DATE_FORMAT(ww_performance_appraisal.date_to, \'%M %d, %Y\') as "performance_appraisal_date_to", DATE_FORMAT(ww_performance_appraisal.date_from, \'%M %d, %Y\') as "performance_appraisal_date_from", ww_performance_appraisal.year as "performance_appraisal_year", `ww_performance_appraisal`.`created_on` as "performance_appraisal_created_on", `ww_performance_appraisal`.`created_by` as "performance_appraisal_created_by", `ww_performance_appraisal`.`modified_on` as "performance_appraisal_modified_on", `ww_performance_appraisal`.`modified_by` as "performance_appraisal_modified_by", T5.`full_name` as "performance_appraisal_immediate"
FROM (`ww_performance_appraisal`)
LEFT JOIN `ww_performance_appraisal_applicable` ON `ww_performance_appraisal_applicable`.`appraisal_id` = `ww_performance_appraisal`.`appraisal_id`
LEFT JOIN `ww_performance_planning_filter` T9 ON `T9`.`filter_id` = `ww_performance_appraisal`.`filter_by`
LEFT JOIN `ww_performance_setup_performance` T4 ON `T4`.`performance_id` = `ww_performance_appraisal`.`performance_type_id`
LEFT JOIN `ww_users` T5 ON `T5`.`user_id` = `ww_performance_appraisal`.`planning_created_by`
WHERE (
	T9.filter_by like "%{$search}%" OR 
	ww_performance_appraisal_applicable.user_id like "%{$search}%" OR 
	ww_performance_appraisal.filter_id like "%{$search}%" OR 
	ww_performance_appraisal.notes like "%{$search}%" OR 
	IF(ww_performance_appraisal.status_id = 1, "Yes", "No") like "%{$search}%" OR 
	ww_performance_appraisal.template_id like "%{$search}%" OR 
	T4.performance like "%{$search}%" OR 
	DATE_FORMAT(ww_performance_appraisal.date_to, \'%M %d, %Y\') like "%{$search}%" OR 
	DATE_FORMAT(ww_performance_appraisal.date_from, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_performance_appraisal.year like "%{$search}%"
)';