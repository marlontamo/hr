<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_performance_planning`.`planning_id` as record_id, 
T9.filter_by as "performance_planning_filter_by", 
ww_performance_planning_applicable.user_id as "performance_planning_applicable_user_id", 
ww_performance_planning.filter_id as "performance_planning_filter_id", 
ww_performance_planning.notes as "performance_planning_notes", 
IF(ww_performance_planning.status_id = 1, "Yes", "No") as "performance_planning_status_id", 
ww_performance_planning.template_id as "performance_planning_template_id", 
T4.performance as "performance_planning_performance_type_id", 
DATE_FORMAT(ww_performance_planning.date_to, \'%M %d, %Y\') as "performance_planning_date_to", 
DATE_FORMAT(ww_performance_planning.date_from, \'%M %d, %Y\') as "performance_planning_date_from", 
ww_performance_planning.year as "performance_planning_year", 
`ww_performance_planning`.`created_on` as "performance_planning_created_on", 
`ww_performance_planning`.`created_by` as "performance_planning_created_by", 
`ww_performance_planning`.`modified_on` as "performance_planning_modified_on", 
`ww_performance_planning`.`modified_by` as "performance_planning_modified_by",
T5.`full_name` as "to_user",
T7.`full_name` as "performance_planning_immediate",
`ww_performance_planning_applicable`.`status_id` as "performance_planning_applicable_status_id"
FROM (`ww_performance_planning`)
LEFT JOIN `ww_performance_planning_applicable` ON `ww_performance_planning_applicable`.`planning_id` = `ww_performance_planning`.`planning_id`
LEFT JOIN `ww_performance_planning_filter` T9 ON `T9`.`filter_id` = `ww_performance_planning`.`filter_by`
LEFT JOIN `ww_performance_setup_performance` T4 ON `T4`.`performance_id` = `ww_performance_planning`.`performance_type_id`
LEFT JOIN `ww_users` T5 ON `T5`.`user_id` = `ww_performance_planning_applicable`.`to_user_id`
LEFT JOIN `ww_performance_planning_approver` T6 ON `T6`.`planning_id` = `ww_performance_planning`.`planning_id`
LEFT JOIN `ww_users` T7 ON `T7`.`user_id` = `ww_performance_planning`.`created_by`
WHERE (
	T9.filter_by like "%{$search}%" OR 
	ww_performance_planning_applicable.user_id like "%{$search}%" OR 
	ww_performance_planning.filter_id like "%{$search}%" OR 
	ww_performance_planning.notes like "%{$search}%" OR 
	IF(ww_performance_planning.status_id = 1, "Yes", "No") like "%{$search}%" OR 
	ww_performance_planning.template_id like "%{$search}%" OR 
	T4.performance like "%{$search}%" OR 
	DATE_FORMAT(ww_performance_planning.date_to, \'%M %d, %Y\') like "%{$search}%" OR 
	DATE_FORMAT(ww_performance_planning.date_from, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_performance_planning.year like "%{$search}%"
)';