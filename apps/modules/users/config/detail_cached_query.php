<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT `ww_users`.`user_id` as record_id, 
									   `ww_users`.`created_on` as "users.created_on", 
									   `ww_users`.`created_by` as "users.created_by", 
									   `ww_users`.`modified_on` as "users.modified_on", 
									   `ww_users`.`modified_by` as "users.modified_by", 
									   ww_users.login as "users.login", 
									   ww_users.hash as "users.hash", 
									   ww_users_profile.company_id as "users_profile.company_id", 
									   ww_users.role_id as "users.role_id", 
									   ww_users.active as "users.active", 
									   ww_users_profile.firstname as "users_profile.firstname", 
									   ww_users_profile.lastname as "users_profile.lastname", 
									   ww_users_profile.middlename as "users_profile.middlename", 
									   ww_users_profile.nickname as "users_profile.nickname", 
									   ww_users_profile.suffix as "users_profile.suffix", 
									   ww_users_profile.photo as "users_profile.photo", 
									   ww_users.email as "users.email", 
									   ww_users_profile.business_level_id as "users_profile.level_id", DATE_FORMAT(ww_users_profile.birth_date, \'%M %d, %Y\') as "users_profile.birth_date"
FROM (`ww_users`)
LEFT JOIN `ww_users_profile` ON `ww_users_profile`.`user_id` = `ww_users`.`user_id`
WHERE `ww_users`.`user_id` = "{$record_id}"';