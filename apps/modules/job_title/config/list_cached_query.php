<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_users_job_title`.`job_title_id` as record_id, 
ww_users_job_title.job_title as "users_job_title_job_title", 
ww_users_job_title.job_title_code as "users_job_title_job_title_code", 
IF(ww_users_job_title.status_id = 1, "Active", "Inactive") as "users_job_title_status_id", 
ww_users_job_title.can_delete as "can_delete",
`ww_users_job_title`.`created_on` as "users_job_title_created_on", 
`ww_users_job_title`.`created_by` as "users_job_title_created_by", 
`ww_users_job_title`.`modified_on` as "users_job_title_modified_on", 
`ww_users_job_title`.`modified_by` as "users_job_title_modified_by"
FROM (`ww_users_job_title`)
WHERE (
	ww_users_job_title.job_title like "%{$search}%" OR 
	ww_users_job_title.job_title_code like "%{$search}%" OR 
	IF(ww_users_job_title.status_id = 1, "Yes", "No") like "%{$search}%"
)';