<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_roles`.`role_id` as record_id, 
ww_roles.profile_id as "roles_profile_id",
ww_roles.description as "roles_description", 
ww_roles.role as "roles_role", 
ww_roles.can_delete as "can_delete",
`ww_roles`.`created_on` as "roles_created_on", 
`ww_roles`.`created_by` as "roles_created_by", 
`ww_roles`.`modified_on` as "roles_modified_on", 
`ww_roles`.`modified_by` as "roles_modified_by"
FROM (`ww_roles`)
WHERE (
	ww_roles.profile_id like "%{$search}%" OR 
	ww_roles.description like "%{$search}%" OR 
	ww_roles.role like "%{$search}%"
)';