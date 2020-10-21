<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_users`.`user_id` as record_id, 
										ww_users.login as "users_login", 
										T4.company as "users_profile_company_id", 
										T5.role as "users_role_id", IF(ww_users.active = 1, "Yes", "No") as "users_active", 
										ww_users_profile.firstname as "users_profile_firstname", 
										ww_users_profile.lastname as "users_profile_lastname", 
										ww_users_profile.middlename as "users_profile_middlename", 
										ww_users_profile.nickname as "users_profile_nickname", 
										ww_users_profile.suffix as "users_profile_suffix", 
										ww_users_profile.photo as "users_profile_photo", 
										ww_users.email as "users_email", 
										ww_users.can_delete as "can_delete",
										`ww_users`.`created_on` as "users_created_on", 
										`ww_users`.`created_by` as "users_created_by", 
										`ww_users`.`modified_on` as "users_modified_on", 
										`ww_users`.`modified_by` as "users_modified_by"
FROM (`ww_users`)
JOIN `ww_users_profile` ON `ww_users_profile`.`user_id` = `ww_users`.`user_id`
JOIN `ww_users_company` T4 ON `T4`.`company_id` = `ww_users_profile`.`company_id`
JOIN `ww_roles` T5 ON `T5`.`role_id` = `ww_users`.`role_id` AND T5.`role_id`>1
WHERE (
	ww_users.login like "%{$search}%" OR 
	T4.company like "%{$search}%" OR 
	T5.role like "%{$search}%" OR 
	IF(ww_users.active = 1, "Yes", "No") like "%{$search}%" OR 
	ww_users_profile.firstname like "%{$search}%" OR 
	ww_users_profile.lastname like "%{$search}%" OR 
	ww_users_profile.middlename like "%{$search}%" OR 
	ww_users_profile.nickname like "%{$search}%" OR 
	ww_users_profile.photo like "%{$search}%" OR 
	ww_users.email like "%{$search}%"
)';