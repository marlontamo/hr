<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_users_specialization`.`specialization_id` as record_id, IF(ww_users_specialization.status_id = 1, "Yes", "No") as "users_specialization_status_id", ww_users_specialization.specialization_code as "users_specialization_specialization_code", ww_users_specialization.specialization as "users_specialization_specialization", `ww_users_specialization`.`created_on` as "users_specialization_created_on", `ww_users_specialization`.`created_by` as "users_specialization_created_by", `ww_users_specialization`.`modified_on` as "users_specialization_modified_on", `ww_users_specialization`.`modified_by` as "users_specialization_modified_by"
FROM (`ww_users_specialization`)
WHERE (
	IF(ww_users_specialization.status_id = 1, "Yes", "No") like "%{$search}%" OR 
	ww_users_specialization.specialization_code like "%{$search}%" OR 
	ww_users_specialization.specialization like "%{$search}%"
)';