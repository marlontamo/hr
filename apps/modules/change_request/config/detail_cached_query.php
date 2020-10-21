<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT 
`ww_partners_personal_request`.`personal_id` as record_id,
`ww_partners_personal_request`.`partner_id` as partner_id, 
`ww_partners_personal_request`.`status` as status, 
`ww_partners_personal_request`.`created_on` as "partners_personal_request_created_on", 
`ww_partners_personal_request`.`created_by` as "partners_personal_request_created_by", 
`ww_partners_personal_request`.`modified_on` as "partners_personal_request_modified_on", 
`ww_partners_personal_request`.`modified_by` as "partners_personal_request_modified_by",
CONCAT(up.firstname, " ", up.lastname) as employee_name,
up.company as company,
ud.department as department,
pk.key_label as label,
`ww_partners_personal_request`.`key_value` as partners_personal_request_key_value
FROM (`ww_partners_personal_request`)
LEFT JOIN ww_users_profile up ON ww_partners_personal_request.partner_id = up.partner_id 
LEFT JOIN ww_users_department ud ON up.department_id = ud.department_id 
LEFT JOIN ww_partners_key pk ON ww_partners_personal_request.key_id = pk.key_id 
WHERE 1 = 1';