<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_users_assignment`.`assignment_id` as record_id, 
IF(ww_users_assignment.status_id = 1, "Active", "Inactive") as "users_assignment_status_id", 
ww_users_assignment.can_delete as "can_delete",
ww_users_assignment.assignment_code as "users_assignment_assignment_code", 
ww_users_assignment.assignment as "users_assignment_assignment", 
`ww_users_assignment`.`created_on` as "users_assignment_created_on", 
`ww_users_assignment`.`created_by` as "users_assignment_created_by", 
`ww_users_assignment`.`modified_on` as "users_assignment_modified_on", 
`ww_users_assignment`.`modified_by` as "users_assignment_modified_by"
FROM (`ww_users_assignment`)
WHERE (
	IF(ww_users_assignment.status_id = 1, "Active", "Inactive") like "%{$search}%" OR 
	ww_users_assignment.assignment_code like "%{$search}%" OR 
	ww_users_assignment.assignment like "%{$search}%"
)';