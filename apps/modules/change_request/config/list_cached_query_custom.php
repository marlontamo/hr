<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query_custom"] = 'SELECT `ww_partners_personal_request`.`personal_id` as record_id, 
`ww_partners_personal_request`.`key_id` as partners_personal_request_key_id, 
T1.full_name as "partners_personal_request_employee_id",
T2.id_number as "partners_personal_request_id_number",
T3.status as "partners_personal_request_status", 
T3.status_id as "partners_personal_request_status_id",  
COUNT(`ww_partners_personal_request`.`personal_id`) as "partners_personal_request_changes",
`ww_partners_personal_request`.`partner_id` as "partners_personal_request_partner_id",
`ww_partners_personal_request`.`created_on` as "partners_personal_request_created_on", 
`ww_partners_personal_request`.`created_by` as "partners_personal_request_created_by", 
`ww_partners_personal_request`.`modified_on` as "partners_personal_request_modified_on", 
`ww_partners_personal_request`.`modified_by` as "partners_personal_request_modified_by",
ppa.user_id AS approver_id
FROM (`ww_partners_personal_request`)

LEFT JOIN `ww_partners` T2 ON `T2`.`partner_id` = `ww_partners_personal_request`.`partner_id`
LEFT JOIN `ww_users` T1 ON `T1`.`user_id` = `T2`.`user_id`
LEFT JOIN `ww_partners_personal_request_status` T3 on `T3`.`status_id` = `ww_partners_personal_request`.`status`

LEFT JOIN ww_partners_personal_approver ppa ON ww_partners_personal_request.personal_id = ppa.personal_request_id
WHERE (
	T1.full_name like "%{$search}%" OR 
	T2.id_number like "%{$search}%"
)';