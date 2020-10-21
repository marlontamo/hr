<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_users_job_rank`.`job_rank_id` as record_id, IF(ww_users_job_rank.status_id = 1, "Yes", "No") as "users_job_rank_status_id", ww_users_job_rank.job_rank_code as "users_job_rank_job_rank_code", ww_users_job_rank.job_rank as "users_job_rank_job_rank", `ww_users_job_rank`.`created_on` as "users_job_rank_created_on", `ww_users_job_rank`.`created_by` as "users_job_rank_created_by", `ww_users_job_rank`.`modified_on` as "users_job_rank_modified_on", `ww_users_job_rank`.`modified_by` as "users_job_rank_modified_by"
FROM (`ww_users_job_rank`)
WHERE (
	IF(ww_users_job_rank.status_id = 1, "Yes", "No") like "%{$search}%" OR 
	ww_users_job_rank.job_rank_code like "%{$search}%" OR 
	ww_users_job_rank.job_rank like "%{$search}%"
)';