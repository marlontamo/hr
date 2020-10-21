<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_users_section`.`section_id` as record_id, 
IF(ww_users_section.status_id = 1, "Active", "Inactive") as "users_section_status_id",
ww_users_section.can_delete as "can_delete", 
ww_users_section.section as "users_section_section", 
ww_users_section.section_code as "users_section_section_code", 
`ww_users_section`.`created_on` as "users_section_created_on", 
`ww_users_section`.`created_by` as "users_section_created_by", 
`ww_users_section`.`modified_on` as "users_section_modified_on", 
`ww_users_section`.`modified_by` as "users_section_modified_by"
FROM (`ww_users_section`)
WHERE (
	IF(ww_users_section.status_id = 1, "Active", "Inactive") like "%{$search}%" OR 
	ww_users_section.section like "%{$search}%" OR 
	ww_users_section.section_code like "%{$search}%"
)';