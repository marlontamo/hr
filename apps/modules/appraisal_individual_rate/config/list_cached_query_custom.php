<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query_custom"] = 'SELECT 
`ww_performance_appraisal`.`appraisal_id` as record_id, 
`ww_performance_appraisal`.`year` as "performance_appraisal_year",
`ww_performance_appraisal`.`notes` as "performance_appraisal_notes",
`ww_performance_setup_performance`.`performance` as "performance_type",
`ww_performance_appraisal`.`date_from` as "performance_appraisal_date_from",
`ww_performance_appraisal`.`date_to` as "performance_appraisal_date_to",
`ww_performance_appraisal`.`status_id` as "status_id",
`ww_performance_appraisal_applicable`.`user_id` as "user_id",
`ww_performance_appraisal_applicable`.`fullname` as "fullname",
`ww_performance_appraisal_applicable`.`status_id` as "applicable_status_id",
`ww_performance_status`.`performance_status` as "applicable_status",
`ww_performance_appraisal`.`created_on` as "performance_appraisal_created_on", 
`ww_performance_appraisal`.`created_by` as "performance_appraisal_created_by", 
`ww_performance_appraisal`.`modified_on` as "performance_appraisal_modified_on", 
`ww_performance_appraisal`.`modified_by` as "performance_appraisal_modified_by",
`ww_users`.`full_name` as "to_user"
FROM (`ww_performance_appraisal`)
LEFT JOIN (`ww_performance_setup_performance`) on `ww_performance_setup_performance`.`performance_id` = `ww_performance_appraisal`.`performance_type_id`
LEFT JOIN (`ww_performance_appraisal_applicable`) on `ww_performance_appraisal_applicable`.`appraisal_id` = `ww_performance_appraisal`.`appraisal_id`
LEFT JOIN (`ww_performance_status`) on `ww_performance_status`.`performance_status_id` = `ww_performance_appraisal_applicable`.`status_id`
LEFT JOIN (`ww_users`) on `ww_users`.`user_id` = `ww_performance_appraisal_applicable`.`to_user_id`
WHERE (
	ww_performance_appraisal.year like "%{$search}%" OR
	ww_performance_setup_performance.performance like "%{$search}%"
)';