<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_partners_clearance_exit_interview_layout`.`exit_interview_layout_id` as record_id, 
`ww_partners_clearance_exit_interview_layout`.`created_on` as "partners_clearance_exit_interview_layout_created_on", 
`ww_partners_clearance_exit_interview_layout`.`created_by` as "partners_clearance_exit_interview_layout_created_by", 
`ww_partners_clearance_exit_interview_layout`.`modified_on` as "partners_clearance_exit_interview_layout_modified_on", 
`ww_partners_clearance_exit_interview_layout`.`modified_by` as "partners_clearance_exit_interview_layout_modified_by",
ww_partners_clearance_exit_interview_layout.can_delete as "can_delete"
, `ww_partners_clearance_exit_interview_layout`.`department_id` as "partners_clearance_exit_interview_layout_department_id" 
, `ww_partners_clearance_exit_interview_layout`.`company_id` as "partners_clearance_exit_interview_layout_company_id" 
, ww_partners_clearance_exit_interview_layout.layout_name, ww_partners_clearance_exit_interview_layout.default
, ww_users_company.company, ww_users_company.company_code

FROM (`ww_partners_clearance_exit_interview_layout`) 
LEFT JOIN ww_users_company ON ww_partners_clearance_exit_interview_layout.company_id = ww_users_company.company_id
WHERE (
	ww_partners_clearance_exit_interview_layout.layout_name like "%{$search}%" OR
	ww_users_company.company like "%{$search}%" 
)';