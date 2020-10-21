<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_users_coordinator`.`coordinator_id` AS record_id, 
`ww_users_company`.`company` AS "users_coordinator_company", 
`ww_users_branch`.`branch` AS "users_coordinator_branch",
GROUP_CONCAT(DISTINCT T1.full_name SEPARATOR "<br> ") AS "users_coordinator_coordinator",
GROUP_CONCAT(DISTINCT T2.full_name SEPARATOR "<br> ") AS "users_coordinator_user",
`ww_users_coordinator`.`created_on` AS "users_coordinator_created_on", 
`ww_users_coordinator`.`created_by` AS "users_coordinator_created_by", 
`ww_users_coordinator`.`modified_on` AS "users_coordinator_modified_on", 
`ww_users_coordinator`.`modified_by` AS "users_coordinator_modified_by",
GROUP_CONCAT(CONCAT(pol.offense_level," - ",T1.sanction) SEPARATOR ",") AS "partners_offense.sanction"
FROM (`ww_users_coordinator`)
LEFT JOIN `ww_users_company` ON `ww_users_coordinator`.`company_id` = `ww_users_company`.`company_id`
LEFT JOIN `ww_users_branch` ON `ww_users_coordinator`.`branch_id` = `ww_users_branch`.`branch_id`
LEFT JOIN `ww_users` T1 ON FIND_IN_SET(t1.user_id,ww_users_coordinator.coordinator_user_id)
LEFT JOIN `ww_users` T2 ON FIND_IN_SET(t2.user_id,ww_users_coordinator.user_id)
WHERE (
	ww_users_company.company like "%{$search}%" OR 
	ww_users_branch.branch like "%{$search}%" OR 
	t1.full_name like "%{$search}%" OR 
	t2.full_name like "%{$search}%")';