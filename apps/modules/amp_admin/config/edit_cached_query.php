<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_recruitment_manpower_plan`.`plan_id` as record_id, 
`ww_recruitment_manpower_plan`.`created_on` as "recruitment_manpower_plan.created_on", 
`ww_recruitment_manpower_plan`.`created_by` as "recruitment_manpower_plan.created_by", 
`ww_recruitment_manpower_plan`.`modified_on` as "recruitment_manpower_plan.modified_on", 
`ww_recruitment_manpower_plan`.`modified_by` as "recruitment_manpower_plan.modified_by", 
ww_recruitment_manpower_plan.year as "recruitment_manpower_plan.year", 
ww_recruitment_manpower_plan.company_id as "recruitment_manpower_plan.company_id", 
T4.company as "recruitment_manpower_plan.company", 
ww_recruitment_manpower_plan.department_id as "recruitment_manpower_plan.department_id", 
T1.immediate as "recruitment_manpower_plan.departmenthead", 
ww_recruitment_manpower_plan.created_by as "recruitment_manpower_plan.created_by", 
T2.full_name as "created_by", 
ww_recruitment_manpower_plan.attachment as "recruitment_manpower_plan.attachment"
FROM (`ww_recruitment_manpower_plan`)
LEFT JOIN `ww_users_department` T1 ON T1.department_id = ww_recruitment_manpower_plan.department_id
LEFT JOIN `ww_users_company` T4 ON T4.company_id = ww_recruitment_manpower_plan.company_id
LEFT JOIN `ww_users` T2 ON T2.user_id = ww_recruitment_manpower_plan.created_by
WHERE `ww_recruitment_manpower_plan`.`plan_id` = "{$record_id}"';