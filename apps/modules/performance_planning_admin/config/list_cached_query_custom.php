<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query_custom"] = 'SELECT 
`ww_performance_planning`.`planning_id` AS record_id, 
`ww_performance_planning`.`year` AS "performance_planning_year",
`ww_performance_setup_performance`.`performance` AS "performance_type",
`ww_performance_planning`.`date_from` AS "performance_planning_date_from",
`ww_performance_planning`.`date_to` AS "performance_planning_date_to",
`ww_performance_planning`.`status_id` AS "status_id",
`ww_performance_planning_applicable`.`user_id` AS "user_id",
`ww_users`.`full_name` AS "fullname",
`usr`.`full_name` AS "attention_fullname",
`ww_performance_planning`.`created_on` AS "performance_planning_created_on", 
`ww_performance_planning`.`created_by` AS "performance_planning_created_by", 
`ww_performance_planning`.`modified_on` AS "performance_planning_modified_on", 
`ww_performance_planning`.`modified_by` AS "performance_planning_modified_by",
`ww_performance_status`.`performance_status` AS "performance_planning_performance_status",
`ww_performance_planning_applicable`.`status_id` AS "performance_planning_performance_status_id"
FROM (`ww_performance_planning`)
LEFT JOIN (`ww_performance_setup_performance`) ON `ww_performance_setup_performance`.`performance_id` = `ww_performance_planning`.`performance_type_id`
LEFT JOIN (`ww_performance_planning_applicable`) ON `ww_performance_planning_applicable`.`planning_id` = `ww_performance_planning`.`planning_id`
LEFT JOIN (`ww_users`) ON `ww_users`.`user_id` = `ww_performance_planning_applicable`.`user_id`
LEFT JOIN (`ww_users` usr) ON `usr`.`user_id` = `ww_performance_planning_applicable`.`to_user_id`
LEFT JOIN `ww_performance_status` ON `ww_performance_status`.performance_status_id = `ww_performance_planning_applicable`.`status_id`
WHERE (
	ww_performance_planning.year like "%{$search}%" OR
	ww_performance_setup_performance.performance like "%{$search}%"OR
	ww_users.full_name like "%{$search}%"
)';