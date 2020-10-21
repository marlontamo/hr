<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_users_competency_level`.`competency_level_id` as record_id, 
IF(ww_users_competency_level.status_id = 1, "Active", "Inactive") as "users_competency_level_status_id", 
ww_users_competency_level.can_delete as "can_delete",
ww_users_competency_level.competency_level_code as "users_competency_level_competency_level_code", 
ww_users_competency_level.competency_level as "users_competency_level_competency_level", 
`ww_users_competency_level`.`created_on` as "users_competency_level_created_on", 
`ww_users_competency_level`.`created_by` as "users_competency_level_created_by", 
`ww_users_competency_level`.`modified_on` as "users_competency_level_modified_on", 
`ww_users_competency_level`.`modified_by` as "users_competency_level_modified_by"
FROM (`ww_users_competency_level`)
WHERE (
	IF(ww_users_competency_level.status_id = 1, "Active", "Inactive") like "%{$search}%" OR 
	ww_users_competency_level.competency_level_code like "%{$search}%" OR 
	ww_users_competency_level.competency_level like "%{$search}%"
)';