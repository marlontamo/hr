<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_users_position`.`position_id` as record_id, 
ww_users_position.position as "users_position_position", 
ww_users_position.position_code as "users_position_position_code", 
ww_partners_employment_type.employment_type as "users_position_employee_type_id", 
ww_users.display_name as "users_position_immediate_id", 
ww_users_position.immediate_position as "users_position_immediate_position", 
IF(ww_users_position.status_id = 1, "Active", "Inactive") as "users_position_status_id", 
ww_users_position.can_delete as "can_delete",
`ww_users_position`.`created_on` as "users_position_created_on", 
`ww_users_position`.`created_by` as "users_position_created_by", 
`ww_users_position`.`modified_on` as "users_position_modified_on", 
`ww_users_position`.`modified_by` as "users_position_modified_by"
FROM (`ww_users_position`)
LEFT JOIN `ww_partners_employment_type` ON `ww_partners_employment_type`.`employment_type_id` = `ww_users_position`.`employee_type_id`
LEFT JOIN `ww_users` ON `ww_users`.`user_id` = `ww_users_position`.`immediate_id`
WHERE (
	ww_users_position.position like "%{$search}%" OR 
	ww_users_position.position_code like "%{$search}%" OR 
	ww_partners_employment_type.employment_type like "%{$search}%" OR 
	ww_users.display_name like "%{$search}%" OR 
	ww_users_position.immediate_position like "%{$search}%" OR 
	IF(ww_users_position.status_id = 1, "Active", "Inactive") like "%{$search}%"
)';