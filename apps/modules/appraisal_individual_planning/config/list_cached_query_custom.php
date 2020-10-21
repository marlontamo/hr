<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query_custom"] = 'SELECT 
`ww_performance_planning`.`planning_id` as record_id, 
`ww_performance_planning`.`year` as "performance_planning_year",
ww_performance_planning.notes as "performance_planning_notes", 
`ww_performance_setup_performance`.`performance` as "performance_type",
`ww_performance_planning`.`date_from` as "performance_planning_date_from",
`ww_performance_planning`.`date_to` as "performance_planning_date_to",
`ww_performance_planning`.`status_id` as "status_id",
`ww_performance_status`.`performance_status` as "performance_status",
`ww_performance_planning_applicable`.`user_id` as "user_id",
`ww_performance_planning_applicable`.`to_user_id` as "to_user_id",
`ww_performance_planning_applicable`.`status_id` as "applicable_status_id",
`ww_performance_planning`.`created_on` as "performance_planning_created_on", 
`ww_performance_planning`.`created_by` as "performance_planning_created_by", 
`ww_performance_planning`.`modified_on` as "performance_planning_modified_on", 
`ww_performance_planning`.`modified_by` as "performance_planning_modified_by",
`ww_users`.`full_name` as "to_user",
`ww_performance_planning_applicable`.`status_id` as "performance_planning_applicable_status_id"
FROM (`ww_performance_planning`)
LEFT JOIN (`ww_performance_setup_performance`) on `ww_performance_setup_performance`.`performance_id` = `ww_performance_planning`.`performance_type_id`
LEFT JOIN (`ww_performance_planning_applicable`) on `ww_performance_planning_applicable`.`planning_id` = `ww_performance_planning`.`planning_id`
LEFT JOIN (`ww_performance_status`) on `ww_performance_status`.`performance_status_id` = `ww_performance_planning_applicable`.`status_id`
LEFT JOIN (`ww_users`) on `ww_users`.`user_id` = `ww_performance_planning_applicable`.`to_user_id`
WHERE (
	ww_performance_planning.year like "%{$search}%" OR
	ww_performance_setup_performance.performance like "%{$search}%"
)';