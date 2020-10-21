<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_requisition`.`requisition_id` as record_id, 
`ww_requisition`.`created_on` as "requisition.created_on", 
`ww_requisition`.`created_by` as "requisition.created_by", 
`ww_requisition`.`modified_on` as "requisition.modified_on", 
`ww_requisition`.`modified_by` as "requisition.modified_by", 
ww_requisition.project_name as "requisition.project_name", 
ww_requisition.priority_id as "requisition.priority_id", 
ww_requisition.approver as "requisition.approver_id",
ww_requisition.total_price as "requisition.total_price",
ww_requisition.no_of_items as "requisition.no_of_items",
ww_requisition.status_id as "requisition.status_id",
T1.full_name as "requisition.requested_by",
T3.department as "requisition.department",
T4.priority as "requisition.priority",
T5.full_name as "requisition.approver",
T6.status_id as "approver.status_id"
FROM (`ww_requisition`)
LEFT JOIN `ww_users` T1 on T1.user_id = `ww_requisition`.`created_by`
LEFT JOIN `ww_users_profile` T2 on T2.user_id = T1.user_id
LEFT JOIN `ww_users_department` T3 on T3.department_id = T2.department_id
LEFT JOIN `ww_requisition_priority` T4 on T4.priority_id = `ww_requisition`.`priority_id`
LEFT JOIN `ww_users` T5 on T5.user_id = `ww_requisition`.`approver`
LEFT JOIN `ww_requisition_mc_signatories` T6 on T6.requisition_id = `ww_requisition`.`requisition_id`
WHERE `ww_requisition`.`requisition_id` = "{$record_id}"';