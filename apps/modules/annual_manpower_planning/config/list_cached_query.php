<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_recruitment_manpower_plan`.`plan_id` as record_id, 
ww_recruitment_manpower_plan.year as "recruitment_manpower_plan_year", 
T2.company as "recruitment_manpower_plan_company_id", 
T3.department as "recruitment_manpower_plan_department_id", 
ww_recruitment_manpower_plan.manpower_plan_status_id as "recruitment_manpower_plan_status_id",
T4.status as "recruitment_manpower_plan_status", 
ww_recruitment_manpower_plan.user_id as "recruitment_manpower_plan_user_id", 
ww_recruitment_manpower_plan.created_by as "recruitment_manpower_plan_created_by",
T5.full_name as "created_by",
ww_recruitment_manpower_plan.attachment as "recruitment_manpower_plan_attachment", 
`ww_recruitment_manpower_plan`.`created_on` as "recruitment_manpower_plan_created_on", 
`ww_recruitment_manpower_plan`.`created_by` as "recruitment_manpower_plan_created_by", 
`ww_recruitment_manpower_plan`.`modified_on` as "recruitment_manpower_plan_modified_on", 
`ww_recruitment_manpower_plan`.`modified_by` as "recruitment_manpower_plan_modified_by"
FROM (`ww_recruitment_manpower_plan`)
LEFT JOIN `ww_users_company` T2 ON `T2`.`company_id` = `ww_recruitment_manpower_plan`.`company_id`
LEFT JOIN `ww_users_department` T3 ON `T3`.`department_id` = `ww_recruitment_manpower_plan`.`department_id`
LEFT JOIN `ww_recruitment_manpower_plan_status` T4 ON `T4`.`manpower_plan_status_id` = `ww_recruitment_manpower_plan`.`manpower_plan_status_id`
LEFT JOIN `ww_users` T5 ON `T5`.`user_id` = `ww_recruitment_manpower_plan`.`created_by`

WHERE (
	ww_recruitment_manpower_plan.year like "%{$search}%" OR 
	T2.company like "%{$search}%" OR 
	T3.department like "%{$search}%" OR 
	ww_recruitment_manpower_plan.user_id like "%{$search}%" OR 
	ww_recruitment_manpower_plan.created_by like "%{$search}%" OR 
	ww_recruitment_manpower_plan.attachment like "%{$search}%"
)';