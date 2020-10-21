<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_users`.`user_id` as record_id,
  `ww_users`.`email` AS "users_email",
  `ww_users_profile`.`photo` AS "users_profile_photo",
  `ww_users_profile`.`nickname` AS "users_profile_nickname",
  `ww_users_profile`.`maidenname` AS "users_profile_maidenname",
  `ww_users_profile`.`middlename` AS "users_profile_middlename",
  `ww_users_profile`.`firstname` AS "users_profile_firstname",
  `ww_users_profile`.`lastname` AS "users_profile_lastname",
  `ww_users_profile`.`suffix` as "users_profile_suffix",
  `ww_users`.`created_on` AS "users_created_on",
  `ww_users`.`created_by` AS "users_created_by",
  `ww_users`.`modified_on` AS "users_modified_on",
  `ww_users`.`modified_by` AS "users_modified_by",
  `ww_users_position`.`position` as "users_profile_position_id", 
  IF(`ww_users`.`active` = 1, "Yes", "No") as "users_active",
  `ww_partners_employment_status`.`employment_status`,
  IF(`ww_partners`.`blacklisted` = 1, "BlackListed", "") as "blacklisted",
  `ww_partners_employment_status`.`employment_status`  
FROM (`ww_users`)
LEFT JOIN `ww_users_profile` ON `ww_users_profile`.`user_id` = `ww_users`.`user_id`
LEFT JOIN `ww_users_position` ON `ww_users_position`.`position_id` = `ww_users_profile`.`position_id`
LEFT JOIN `ww_users_company` ON `ww_users_company`.`company_id` = `ww_users_profile`.`company_id`
JOIN `ww_partners` ON `ww_users`.`user_id` = `ww_partners`.`user_id`
LEFT JOIN `ww_partners_employment_status` ON `ww_partners_employment_status`.`employment_status_id` = `ww_partners`.`status_id`
WHERE (
	ww_users.active like "%{$search}%" OR 
	ww_users_company.company like "%{$search}%" OR 
	ww_users_position.position like "%{$search}%" OR 
	ww_partners.biometric like "%{$search}%" OR 
	ww_partners.id_number like "%{$search}%" OR 
	ww_users.email like "%{$search}%" OR 
	ww_users_profile.nickname like "%{$search}%" OR 
	ww_users_profile.maidenname like "%{$search}%" OR 
	ww_users_profile.middlename like "%{$search}%" OR 
	ww_users_profile.firstname like "%{$search}%" OR 
	ww_users_profile.lastname like "%{$search}%"
)';