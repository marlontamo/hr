<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_users_division`.`division_id` as record_id, 
ww_users_division.division as "users_division_division", 
ww_users_division.division_code as "users_division_division_code", 
ww_users.display_name as "users_division_immediate_id", 
ww_users_division.position as "users_division_position", 
IF(ww_users_division.status_id = 1, "Active", "Inactive") as "users_division_status_id", 
ww_users_division.can_delete as "can_delete",
`ww_users_division`.`created_on` as "users_division_created_on", 
`ww_users_division`.`created_by` as "users_division_created_by", 
`ww_users_division`.`modified_on` as "users_division_modified_on", 
`ww_users_division`.`modified_by` as "users_division_modified_by"
FROM (`ww_users_division`)
LEFT JOIN `ww_users` ON `ww_users`.`user_id` = `ww_users_division`.`immediate_id`
WHERE (
	ww_users_division.division like "%{$search}%" OR 
	ww_users_division.division_code like "%{$search}%" OR 
	ww_users.display_name like "%{$search}%" OR 
	ww_users_division.position like "%{$search}%" OR 
	IF(ww_users_division.status_id = 1, "Active", "Inactive") like "%{$search}%"
)';