<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query_custom"] = 'SELECT 
`ww_performance_appraisal`.`appraisal_id` AS record_id, 
`ww_performance_appraisal`.`year` AS "performance_appraisal_year",
`ww_performance_setup_performance`.`performance` AS "performance_type",
`ww_performance_appraisal`.`date_from` AS "performance_appraisal_date_from",
`ww_performance_appraisal`.`date_to` AS "performance_appraisal_date_to",
`ww_performance_appraisal`.`status_id` AS "status_id",
`ww_performance_appraisal_contributor`.`user_id` AS "user_id",
`ww_performance_appraisal_contributor`.`contributor_id` AS "contributor_id",
`users_profile`.`display_name` AS "fullname",
`ww_performance_appraisal`.`created_on` AS "performance_appraisal_created_on", 
`ww_performance_appraisal`.`created_by` AS "performance_appraisal_created_by", 
`ww_performance_appraisal`.`modified_on` AS "performance_appraisal_modified_on", 
`ww_performance_appraisal`.`modified_by` AS "performance_appraisal_modified_by",
`ww_performance_status`.`performance_status` AS "performance_appraisal_performance_status",
`ww_performance_appraisal_contributor`.`status_id` AS "performance_appraisal_performance_status_id",
`ww_performance_status`.`class` AS "contributor_status_class",
`users_profile`.`photo` AS "photo"
FROM (`ww_performance_appraisal`)
LEFT JOIN (`ww_performance_setup_performance`) ON `ww_performance_setup_performance`.`performance_id` = `ww_performance_appraisal`.`performance_type_id`
LEFT JOIN (`ww_performance_appraisal_contributor`) ON `ww_performance_appraisal_contributor`.`appraisal_id` = `ww_performance_appraisal`.`appraisal_id`
LEFT JOIN (`users_profile`) ON `users_profile`.`user_id` = `ww_performance_appraisal_contributor`.`user_id`
LEFT JOIN `ww_performance_status` ON `ww_performance_status`.performance_status_id = `ww_performance_appraisal_contributor`.`status_id`
WHERE (
	ww_performance_appraisal.year like "%{$search}%" OR
	ww_performance_setup_performance.performance like "%{$search}%"OR
	`users_profile`.`display_name` like "%{$search}%"
)';