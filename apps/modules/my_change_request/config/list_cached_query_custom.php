<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query_custom"] = 'SELECT `ww_partners_personal_request`.`personal_id` AS record_id,
`ww_partners_personal_request`.`key_id`,
`ww_partners_personal_request`.`key_name`,
`ww_partners_personal_request`.`key_value`,
T1.full_name AS "partners_personal_request_employee_id",
T2.id_number AS "partners_personal_request_id_number",
T3.status AS "partners_personal_request_status", 
T3.status_id AS "partners_personal_request_status_id", 
T5.key_code, T5.key_label, 
`ww_partners_personal_request`.`partner_id` AS "partners_personal_request_partner_id",
`ww_partners_personal_request`.`created_on` AS "partners_personal_request_created_on", 
`ww_partners_personal_request`.`created_by` AS "partners_personal_request_created_by", 
`ww_partners_personal_request`.`modified_on` AS "partners_personal_request_modified_on", 
`ww_partners_personal_request`.`modified_by` AS "partners_personal_request_modified_by"
FROM (`ww_partners_personal_request`)
LEFT JOIN `ww_users_profile` T4 ON `T4`.`partner_id` = `ww_partners_personal_request`.`partner_id`
LEFT JOIN `ww_users` T1 ON `T1`.`user_id` = `T4`.`user_id`
LEFT JOIN `ww_partners` T2 ON `T2`.`partner_id` = `T4`.`partner_id`
LEFT JOIN `ww_partners_personal_request_status` T3 ON `T3`.`status_id` = `ww_partners_personal_request`.`status`
LEFT JOIN `ww_partners_key` T5 ON `T5`.`key_id` = `ww_partners_personal_request`.`key_id`
WHERE ( 
	T1.full_name LIKE "%{$search}%" OR 
	T2.id_number LIKE "%{$search}%"OR 
	ww_partners_personal_request.key_value LIKE "%{$search}%" OR 
	T5.key_label LIKE "%{$search}%" OR 
	T5.key_code LIKE "%{$search}%"
)';