<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query_custom"] = 'SELECT `ww_recruitment_request`.`request_id` as record_id, 
ww_recruitment_request.user_id as "recruitment_request_user_id", 
ww_recruitment_request.document_no as "recruitment_request_document_no", 
DATE_FORMAT(ww_recruitment_request.created_on, \'%M %d, %Y %h:%i %p\') as "recruitment_request_created_on_mod",
ww_recruitment_request.description as "recruitment_request_description", 
DATE_FORMAT(ww_recruitment_request.date_needed, \'%M %d, %Y\') as "recruitment_request_date_needed", 
T2.department as "recruitment_request_department_id", 
T1.company as "recruitment_request_company_id",
T3.recruit_status as "recruitment_request_status",
T3.recruit_status_id as "recruitment_request_status_id",
T6.recruit_status as "recruitment_request_status_approver",
T6.recruit_status_id as "recruitment_request_status_approver_id",
T4.position as "recruitment_request_position", 
T7.full_name as "recruitment_request_name",
DATE_FORMAT(T5.modified_on, \'%M %d, %Y %h:%i %p\') as "recruitment_request_date_approved",
DATE_FORMAT(ww_recruitment_request.delivery_date, \'%M %d, %Y\') as "recruitment_request_delivery_date",
`ww_recruitment_request`.`created_on` as "recruitment_request_created_on", 
`ww_recruitment_request`.`created_by` as "recruitment_request_created_by", 
`ww_recruitment_request`.`modified_on` as "recruitment_request_modified_on", 
`ww_recruitment_request`.`modified_by` as "recruitment_request_modified_by"
FROM (`ww_recruitment_request`)
LEFT JOIN `ww_users_department` T2 ON `T2`.`department_id` = `ww_recruitment_request`.`department_id`
LEFT JOIN `ww_users_company` T1 ON `T1`.`company_id` = `ww_recruitment_request`.`company_id`
LEFT JOIN `ww_recruitment_request_status` T3 ON `T3`.`recruit_status_id` = `ww_recruitment_request`.`status_id`
LEFT JOIN `ww_users_position` T4 ON `T4`.`position_id` = `ww_recruitment_request`.`position_id`
LEFT JOIN `ww_recruitment_request_approver` T5 ON `T5`.`request_id` = `ww_recruitment_request`.`request_id`
LEFT JOIN `ww_recruitment_request_status` T6 ON `T6`.`recruit_status_id` = `T5`.`status_id`
LEFT JOIN `ww_users` T7 ON `T7`.`user_id` = `ww_recruitment_request`.`user_id`
WHERE (
	ww_recruitment_request.user_id like "%{$search}%" OR 
	DATE_FORMAT(ww_recruitment_request.created_on, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_recruitment_request.description like "%{$search}%" OR 
	DATE_FORMAT(ww_recruitment_request.date_needed, \'%M %d, %Y\') like "%{$search}%" OR 
	T2.department like "%{$search}%" OR 
	T1.company like "%{$search}%"
)';