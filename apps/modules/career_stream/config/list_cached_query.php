<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_users_job_class`.`job_class_id` as record_id, 
IF(ww_users_job_class.status_id = 1, "Active", "Inactive") as "users_job_class_status_id", 
ww_users_job_class.can_delete as "can_delete",
ww_users_job_class.job_class_code as "users_job_class_job_class_code", 
ww_users_job_class.job_class as "users_job_class_job_class", 
`ww_users_job_class`.`created_on` as "users_job_class_created_on", 
`ww_users_job_class`.`created_by` as "users_job_class_created_by", 
`ww_users_job_class`.`modified_on` as "users_job_class_modified_on", 
`ww_users_job_class`.`modified_by` as "users_job_class_modified_by"
FROM (`ww_users_job_class`)
WHERE (
	IF(ww_users_job_class.status_id = 1, "Active", "Inactive") like "%{$search}%" OR 
	ww_users_job_class.job_class_code like "%{$search}%" OR 
	ww_users_job_class.job_class like "%{$search}%"
)';