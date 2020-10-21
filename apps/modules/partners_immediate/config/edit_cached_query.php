<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_users`.`user_id` as record_id, `ww_users`.`created_on` as "users.created_on", `ww_users`.`created_by` as "users.created_by", `ww_users`.`modified_on` as "users.modified_on", `ww_users`.`modified_by` as "users.modified_by", DATE_FORMAT(ww_users_profile.birth_date, \'%M %d, %Y\') as "users_profile.birth_date", ww_users_profile.group_id as "users_profile.group_id", ww_users_profile.division_id as "users_profile.division_id", ww_users_department.immediate_id as "users_department.immediate_id", DATE_FORMAT(ww_partners.effectivity_date, \'%M %d, %Y\') as "partners.effectivity_date", ww_partners.status_id as "partners.status_id", ww_users_profile.location_id as "users_profile.location_id", ww_users_profile.company as "users_profile.company", ww_users_profile.position_id as "users_profile.position_id", ww_partners.shift_id as "partners.shift_id", ww_users.role_id as "users.role_id", ww_partners.biometric as "partners.biometric", ww_partners.id_number as "partners.id_number", ww_users.email as "users.email", ww_users_profile.nickname as "users_profile.nickname", ww_users_profile.maidenname as "users_profile.maidenname", ww_users_profile.middlename as "users_profile.middlename", ww_users_profile.firstname as "users_profile.firstname", ww_users_profile.lastname as "users_profile.lastname"
FROM (`ww_users`)
LEFT JOIN `ww_users_profile` ON `ww_users_profile`.`birth_date` = `ww_users`.`user_id`
LEFT JOIN `ww_users_department` ON `ww_users_department`.`immediate_id` = `ww_users`.`user_id`
LEFT JOIN `ww_partners` ON `ww_partners`.`effectivity_date` = `ww_users`.`user_id`
WHERE `ww_users`.`user_id` = "{$record_id}"';