<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query_custom"] = 'SELECT `ww_users`.`user_id` as record_id, 
`ww_users`.`created_on` as "users.created_on", 
`ww_users`.`created_by` as "users.created_by", 
`ww_users`.`modified_on` as "users.modified_on", 
`ww_users`.`modified_by` as "users.modified_by", 
ww_partners.status_id as "partners.status_id", 
ww_partners.employment_type_id as "partners.employment_type_id", 
ww_partners.job_grade_id as "partners.job_grade_id", 
ww_partners.classification_id as "partners.classification_id", 
ww_partners.shift_id as "partners.shift_id", 
ww_partners.calendar_id as "partners.calendar_id", 
ww_partners.biometric as "partners.biometric", 
ww_partners.id_number as "partners.id_number", 
DATE_FORMAT(ww_partners.effectivity_date, \'%M %d, %Y\') as "partners.effectivity_date", 
DATE_FORMAT(ww_partners.regularization_date, \'%M %d, %Y\') as "partners.regularization_date", 
DATE_FORMAT(ww_partners.resigned_date, \'%M %d, %Y\') as "partners.resigned_date", 
ww_users.email as "users.email", 
ww_users.role_id as "users.role_id", 
ww_users_profile.title as "users_profile.title", 
ww_users_profile.nickname as "users_profile.nickname", 
ww_users_profile.maidenname as "users_profile.maidenname", 
ww_users_profile.middlename as "users_profile.middlename", 
ww_users_profile.firstname as "users_profile.firstname", 
ww_users_profile.lastname as "users_profile.lastname",
ww_users_profile.suffix as "users_profile.suffix",
ww_users_profile.company_id as "users_profile.company_id",
ww_users_profile.company as "users_profile.company", 
ww_users_profile.location_id as "users_profile.location_id", 
ww_users_profile.position_id as "users_profile.position_id", 
ww_users_profile.division_id as "users_profile.division_id",
ww_users_profile.department_id as "users_profile.department_id",
ww_users_profile.branch_id as "users_profile.branch_id",
ww_users_profile.section_id as "users_profile.section_id",
ww_users_profile.group_id as "users_profile.group_id", 
ww_users_profile.project_id as "users_profile.project_id", 
ww_users_profile.reports_to_id as "users_profile.reports_to_id", 
ww_users_profile.project_hr_id as "users_profile.project_hr_id",
ww_users_profile.coordinator_id as "users_profile.coordinator_id",
ww_users_profile.credit_setup_id as "users_profile.credit_setup_id",
ww_users_profile.start_date as "users_profile.start_date",
ww_users_profile.end_date as "users_profile.end_date",
CASE WHEN ww_users_profile.photo  IS NULL or ww_users_profile.photo  = "" THEN "assets/img/avatar.png"  ELSE ww_users_profile.photo END as "users_profile.photo", 
DATE_FORMAT(ww_users_profile.birth_date, \'%M %d, %Y\') as "users_profile.birth_date",
ww_users_position.position as "users_position.position",
ww_users_department.immediate_id as "users_department.immediate_id",
ww_users_profile.specialization_id as "users_profile.specialization_id"
FROM (`ww_users`)
 LEFT JOIN ww_users_profile ON ww_users_profile.user_id = ww_users.user_id
 LEFT JOIN ww_partners ON ww_partners.user_id = ww_users.user_id
 LEFT JOIN ww_users_position ON ww_users_position.position_id = ww_users_profile.position_id
 LEFT JOIN ww_users_department ON ww_users_department.department_id = ww_users_profile.department_id
WHERE `ww_users`.`user_id` = "{$record_id}"';

$config["edit_cached_query_personal_custom"] = 'SELECT 
`ww_partners`.`user_id` AS record_id, 
`ww_partners`.`partner_id` AS partner_id, 
`ww_partners_personal`.`key_id` AS key_id, 
`ww_partners_personal`.`key` AS `key`, 
`ww_partners_personal`.`sequence` AS `sequence`, 
`ww_partners_personal`.`key_name` AS `key_name`, 
`ww_partners_personal`.`key_value` AS `key_value`
 FROM ww_partners_personal 
LEFT JOIN ww_partners ON ww_partners.partner_id = ww_partners_personal.partner_id
WHERE ww_partners.user_id = "{$record_id}"';
