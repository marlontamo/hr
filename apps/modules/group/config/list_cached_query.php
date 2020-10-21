<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_users_group`.`group_id` as record_id, 
ww_users_group.group as "users_group_group", 
ww_users_group.group_code as "users_group_group_code", 
ww_users.display_name as "users_group_immediate_id", 
ww_users_group.position as "users_group_position", 
IF(ww_users_group.status_id = 1, "Active", "Inactive") as "users_group_status_id", 
ww_users_group.can_delete as "can_delete",
`ww_users_group`.`created_on` as "users_group_created_on", 
`ww_users_group`.`created_by` as "users_group_created_by", 
`ww_users_group`.`modified_on` as "users_group_modified_on", 
`ww_users_group`.`modified_by` as "users_group_modified_by"
FROM (`ww_users_group`)
LEFT JOIN `ww_users` ON `ww_users`.`user_id` = `ww_users_group`.`immediate_id`
WHERE (
	ww_users_group.group like "%{$search}%" OR 
	ww_users_group.group_code like "%{$search}%" OR 
	ww_users.display_name like "%{$search}%" OR 
	ww_users_group.position like "%{$search}%" OR 
	IF(ww_users_group.status_id = 1, "Active", "Inactive") like "%{$search}%"
)';