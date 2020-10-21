<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_users_branch`.`branch_id` as record_id, IF(ww_users_branch.status_id = 1, "Yes", "No") as "users_branch_status_id", ww_users_branch.branch_code as "users_branch_branch_code", ww_users_branch.branch as "users_branch_branch", `ww_users_branch`.`created_on` as "users_branch_created_on", `ww_users_branch`.`created_by` as "users_branch_created_by", `ww_users_branch`.`modified_on` as "users_branch_modified_on", `ww_users_branch`.`modified_by` as "users_branch_modified_by"
FROM (`ww_users_branch`)
WHERE (
	IF(ww_users_branch.status_id = 1, "Yes", "No") like "%{$search}%" OR 
	ww_users_branch.branch_code like "%{$search}%" OR 
	ww_users_branch.branch like "%{$search}%"
)';