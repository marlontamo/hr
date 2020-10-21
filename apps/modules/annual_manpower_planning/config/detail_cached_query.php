<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT `ww_recruitment_manpower_plan`.`plan_id` as record_id, 
ww_recruitment_manpower_plan.year as "recruitment_manpower_plan_year", 
ww_users_company.company as "recruitment_manpower_plan_company_id", 
ww_users_department.department as "recruitment_manpower_plan_department_id", 
ww_recruitment_manpower_plan.created_by as "recruitment_manpower_plan_created_by", 
ww_recruitment_manpower_plan.attachment as "recruitment_manpower_plan_attachment", 
`ww_recruitment_manpower_plan`.`created_on` as "recruitment_manpower_plan_created_on", 
`ww_recruitment_manpower_plan`.`created_by` as "recruitment_manpower_plan_created_by", 
`ww_recruitment_manpower_plan`.`modified_on` as "recruitment_manpower_plan_modified_on", 
`ww_recruitment_manpower_plan`.`modified_by` as "recruitment_manpower_plan_modified_by", 
ww_recruitment_manpower_plan.year as "recruitment_manpower_plan_year", 
ww_users_company.company as "recruitment_manpower_plan_company_id", 
ww_users_department.department as "recruitment_manpower_plan_department_id", 
ww_recruitment_manpower_plan.created_by as "recruitment_manpower_plan_created_by", 
ww_recruitment_manpower_plan.attachment as "recruitment_manpower_plan_attachment"
FROM (`ww_recruitment_manpower_plan`)
LEFT JOIN `ww_users_company` ON `ww_users_company`.`company_id` = `ww_recruitment_manpower_plan`.`company_id`
LEFT JOIN `ww_users_department` ON `ww_users_department`.`department_id` = `ww_recruitment_manpower_plan`.`department_id`
WHERE `ww_recruitment_manpower_plan`.`plan_id` = "{$record_id}"';