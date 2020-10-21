<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_requisition`.`requisition_id` as record_id,
ww_requisition.project_name as "requisition_project_name",
ww_requisition.no_of_items as "requisition_no_of_items",
ww_requisition.total_price as "requisition_total_price",
T4.status as "requisition_status",
T4.status_id as "requisition_status_id",
T4.class as "status_class",
T2.priority as "requisition_priority_id", 
T3.full_name as "requisition_approver", 
`ww_requisition`.`created_on` as "requisition_created_on", 
`ww_requisition`.`created_by` as "requisition_created_by", 
`ww_requisition`.`modified_on` as "requisition_modified_on", 
`ww_requisition`.`modified_by` as "requisition_modified_by"
FROM (`ww_requisition`)
LEFT JOIN `ww_requisition_priority` T2 ON `T2`.`priority_id` = `ww_requisition`.`priority_id`
LEFT JOIN `ww_users` T3 ON `T3`.`user_id` = `ww_requisition`.`approver`
LEFT JOIN `ww_requisition_status` T4 ON `T4`.`status_id` = `ww_requisition`.`status_id`
WHERE (
	ww_requisition.project_name like "%{$search}%" OR 
	T2.priority like "%{$search}%" OR 
	T3.full_name like "%{$search}%"
)';