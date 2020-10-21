<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_users`.`user_id` as record_id, 
										ww_users.display_name as "users_department_immediate_id", 
										ww_partners_employment_status.employment_status as "partners_status_id", 
										ww_partners.effectivity_date as "partners_effectivity_date", 
										ww_users_location.location as "users_profile_location_id", 
										ww_users_company.company as "users_profile_company", 
										ww_users_position.position as "users_profile_position_id", 
										ww_time_shift.shift as "partners_shift_id", 
										ww_roles.role as "users_role_id", 
										ww_partners.biometric as "partners_biometric", 
										ww_partners.id_number as "partners_id_number", 
										ww_users.email as "users_email", 
										ww_users_profile.nickname as "users_profile_nickname", 
										ww_users_profile.maidenname as "users_profile_maidenname", 
										ww_users_profile.middlename as "users_profile_middlename", 
										ww_users_profile.firstname as "users_profile_firstname", 
										ww_users_profile.lastname as "users_profile_lastname",  
										ww_users_profile.suffix as "users_profile_suffix", 
										`ww_users`.`created_on` as "users_created_on", 
										`ww_users`.`created_by` as "users_created_by", 
										`ww_users`.`modified_on` as "users_modified_on", 
										`ww_users`.`modified_by` as "users_modified_by"
FROM (`ww_users`)
LEFT JOIN `ww_users_department` ON `ww_users_department`.`user_id` = `ww_users`.`user_id`
LEFT JOIN `ww_partners` ON `ww_partners`.`user_id` = `ww_users`.`user_id`
LEFT JOIN `ww_users_profile` ON `ww_users_profile`.`user_id` = `ww_users`.`user_id`
LEFT JOIN `ww_users` ON `ww_users`.`user_id` = `ww_users_department`.`immediate_id`
LEFT JOIN `ww_partners_employment_status` ON `ww_partners_employment_status`.`employment_status_id` = `ww_partners`.`status_id`
LEFT JOIN `ww_users_location` ON `ww_users_location`.`location_id` = `ww_users_profile`.`location_id`
LEFT JOIN `ww_users_company` ON `ww_users_company`.`company_id` = `ww_users_profile`.`company`
LEFT JOIN `ww_users_position` ON `ww_users_position`.`position_id` = `ww_users_profile`.`position_id`
LEFT JOIN `ww_time_shift` ON `ww_time_shift`.`shift_id` = `ww_partners`.`shift_id`
LEFT JOIN `ww_roles` ON `ww_roles`.`role_id` = `ww_users`.`role_id`
WHERE (
	ww_users.display_name like "%{$search}%" OR 
	ww_partners_employment_status.employment_status like "%{$search}%" OR 
	ww_partners.effectivity_date like "%{$search}%" OR 
	ww_users_location.location like "%{$search}%" OR 
	ww_users_company.company like "%{$search}%" OR 
	ww_users_position.position like "%{$search}%" OR 
	ww_time_shift.shift like "%{$search}%" OR 
	ww_roles.role like "%{$search}%" OR 
	ww_partners.biometric like "%{$search}%" OR 
	ww_partners.id_number like "%{$search}%" OR 
	ww_users.email like "%{$search}%" OR 
	ww_users_profile.nickname like "%{$search}%" OR 
	ww_users_profile.maidenname like "%{$search}%" OR 
	ww_users_profile.middlename like "%{$search}%" OR 
	ww_users_profile.firstname like "%{$search}%" OR 
	ww_users_profile.lastname like "%{$search}%"
)';