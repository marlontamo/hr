<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_users_coordinator`.`coordinator_id` as record_id, T1.company as "users_coordinator_company_id", T1.alias as "time_coordinator_user_id", `ww_users_coordinator`.`created_on` as "users_coordinator_created_on", `ww_users_coordinator`.`created_by` as "users_coordinator_created_by", `ww_users_coordinator`.`modified_on` as "users_coordinator_modified_on", `ww_users_coordinator`.`modified_by` as "users_coordinator_modified_by"
FROM (`ww_users_coordinator`)
LEFT JOIN `ww_time_coordinator` ON `ww_time_coordinator`.`coordinator_id` = `ww_users_coordinator`.`coordinator_id`
LEFT JOIN `ww_users_company` T1 ON `T1`.`company_id` = `ww_users_coordinator`.`company_id`
LEFT JOIN `ww_partners` T1 ON `T1`.`user_id` = `ww_time_coordinator`.`user_id`
WHERE (
	T1.company like "%{$search}%" OR 
	T1.alias like "%{$search}%"
)';