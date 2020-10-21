<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_users_department`.`department_id` as record_id, 
ww_users_department.department as "users_department_department", 
ww_users_department.department_code as "users_department_department_code", 
ww_users_division.division as "users_department_division_id", 
ww_users.display_name as "users_department_immediate_id", 
ww_users_department.immediate_position as "users_department_immediate_position", 
IF(ww_users_department.status_id = 1, "Active", "Inactive") as "users_department_status_id",
ww_users_department.can_delete as "can_delete",
`ww_users_department`.`created_on` as "users_department_created_on", 
`ww_users_department`.`created_by` as "users_department_created_by", 
`ww_users_department`.`modified_on` as "users_department_modified_on", 
`ww_users_department`.`modified_by` as "users_department_modified_by"
FROM (`ww_users_department`)
LEFT JOIN `ww_users_division` ON `ww_users_division`.`division_id` = `ww_users_department`.`division_id`
LEFT JOIN `ww_users` ON `ww_users`.`user_id` = `ww_users_department`.`immediate_id`
WHERE (
	ww_users_department.department like "%{$search}%" OR 
	ww_users_department.department_code like "%{$search}%" OR 
	ww_users_division.division like "%{$search}%" OR 
	ww_users.display_name like "%{$search}%" OR 
	ww_users_department.immediate_position like "%{$search}%" OR 
	IF(ww_users_department.status_id = 1, "Active", "Inactive") like "%{$search}%"
)';