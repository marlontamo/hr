<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_recruitment_request`.`request_id` as record_id, ww_recruitment_request.user_id as "recruitment_request_user_id", DATE_FORMAT(ww_recruitment_request.created_on, \'%M %d, %Y\') as "recruitment_request_created_on", ww_recruitment_request.description as "recruitment_request_description", DATE_FORMAT(ww_recruitment_request.date_needed, \'%M %d, %Y\') as "recruitment_request_date_needed", T2.department as "recruitment_request_department_id", T1.company as "recruitment_request_company_id", `ww_recruitment_request`.`created_on` as "recruitment_request_created_on", `ww_recruitment_request`.`created_by` as "recruitment_request_created_by", `ww_recruitment_request`.`modified_on` as "recruitment_request_modified_on", `ww_recruitment_request`.`modified_by` as "recruitment_request_modified_by"
FROM (`ww_recruitment_request`)
LEFT JOIN `ww_users_department` T2 ON `T2`.`department_id` = `ww_recruitment_request`.`department_id`
LEFT JOIN `ww_users_company` T1 ON `T1`.`company_id` = `ww_recruitment_request`.`company_id`
WHERE (
	ww_recruitment_request.user_id like "%{$search}%" OR 
	DATE_FORMAT(ww_recruitment_request.created_on, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_recruitment_request.description like "%{$search}%" OR 
	DATE_FORMAT(ww_recruitment_request.date_needed, \'%M %d, %Y\') like "%{$search}%" OR 
	T2.department like "%{$search}%" OR 
	T1.company like "%{$search}%"
)';