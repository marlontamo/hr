<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_users_job_rank_code`.`job_rank_code_id` as record_id, ww_users_job_rank_code.job_rank_code_code as "users_job_rank_code_job_rank_code_code", IF(ww_users_job_rank_code.status_id = 1, "Yes", "No") as "users_job_rank_code_status_id", ww_users_job_rank_code.job_rank_code as "users_job_rank_code_job_rank_code", `ww_users_job_rank_code`.`created_on` as "users_job_rank_code_created_on", `ww_users_job_rank_code`.`created_by` as "users_job_rank_code_created_by", `ww_users_job_rank_code`.`modified_on` as "users_job_rank_code_modified_on", `ww_users_job_rank_code`.`modified_by` as "users_job_rank_code_modified_by"
FROM (`ww_users_job_rank_code`)
WHERE (
	ww_users_job_rank_code.job_rank_code_code like "%{$search}%" OR 
	IF(ww_users_job_rank_code.status_id = 1, "Yes", "No") like "%{$search}%" OR 
	ww_users_job_rank_code.job_rank_code like "%{$search}%"
)';