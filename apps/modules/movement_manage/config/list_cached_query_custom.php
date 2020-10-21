<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_partners_movement`.`movement_id` as record_id, 
ww_partners_movement_action_moving.further_reason as "partners_movement_action_moving_further_reason", 
T13.reason as "partners_movement_action_moving_reason_id", 
IF(ww_partners_movement_action_moving.blacklisted = 1, "Yes", "No") as "partners_movement_action_moving_blacklisted", 
DATE_FORMAT(ww_partners_movement_action_moving.end_date, \'%M %d, %Y\') as "partners_movement_action_moving_end_date", 
ww_partners_movement_action_extension.end_date as "partners_movement_action_extension_end_date", 
ww_partners_movement_action_extension.no_of_months as "partners_movement_action_extension_no_of_months", 
DATE_FORMAT(ww_partners_movement_action.effectivity_date, \'%M %d, %Y\') as "partners_movement_action_effectivity_date", 
ww_partners_movement_action.remarks as "partners_movement_action_remarks", 
ww_partners_movement_action.grade as "partners_movement_action_grade", 
ww_partners_movement_action_transfer.to_id as "partners_movement_action_transfer_to_id", 
ww_partners_movement_action_transfer.from_id as "partners_movement_action_transfer_from_id", 
ww_partners_movement_action_transfer.field_id as "partners_movement_action_transfer_field_id", 
ww_partners_movement.remarks as "partners_movement_remarks", 
T4.type as "partners_movement_action_type_id", 
T2.cause as "partners_movement_due_to_id", 
T1.display_name as "partners_movement_action_user_id", 
ww_partners_movement_action_compensation.to_salary as "partners_movement_action_compensation_to_salary", 
ww_partners_movement_action_compensation.current_salary as "partners_movement_action_compensation_current_salary", 
T5.status as "partners_movement_status",
T7.status as "approver_movement_status",
T5.status_id as "partners_movement_status_id",
T7.status_id as "approver_movement_status_id",
`ww_partners_movement`.`created_on` as "partners_movement_created_on", 
`ww_partners_movement`.`created_by` as "partners_movement_created_by",
`ww_partners_movement`.`modified_on` as "partners_movement_modified_on", 
`ww_partners_movement`.`modified_by` as "partners_movement_modified_by"
FROM (`ww_partners_movement`)
LEFT JOIN `ww_partners_movement_action_moving` ON `ww_partners_movement_action_moving`.`movement_id` = `ww_partners_movement`.`movement_id`
LEFT JOIN `ww_partners_movement_action_extension` ON `ww_partners_movement_action_extension`.`movement_id` = `ww_partners_movement`.`movement_id`
LEFT JOIN `ww_partners_movement_action` ON `ww_partners_movement_action`.`movement_id` = `ww_partners_movement`.`movement_id`
LEFT JOIN `ww_partners_movement_action_transfer` ON `ww_partners_movement_action_transfer`.`movement_id` = `ww_partners_movement`.`movement_id`
LEFT JOIN `ww_partners_movement_action_compensation` ON `ww_partners_movement_action_compensation`.`movement_id` = `ww_partners_movement`.`movement_id`
LEFT JOIN `ww_partners_movement_reason` T13 ON `T13`.`reason_id` = `ww_partners_movement_action_moving`.`reason_id`
LEFT JOIN `ww_partners_movement_type` T4 ON `T4`.`type_id` = `ww_partners_movement_action`.`type_id`
LEFT JOIN `ww_partners_movement_cause` T2 ON `T2`.`cause_id` = `ww_partners_movement`.`due_to_id`
LEFT JOIN `ww_partners_movement_status` T5 ON `T5`.`status_id` = `ww_partners_movement`.`status_id`
LEFT JOIN `ww_partners_movement_approver` T6 ON `T6`.`movement_id` = `ww_partners_movement`.`movement_id`
LEFT JOIN `ww_partners_movement_status` T7 ON `T7`.`status_id` = `T6`.`movement_status_id`
LEFT JOIN `ww_users` T1 ON `T1`.`user_id` = `ww_partners_movement_action`.`user_id`
WHERE (
	ww_partners_movement_action_moving.further_reason like "%{$search}%" OR 
	T13.reason like "%{$search}%" OR 
	IF(ww_partners_movement_action_moving.blacklisted = 1, "Yes", "No") like "%{$search}%" OR 
	DATE_FORMAT(ww_partners_movement_action_moving.end_date, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_partners_movement_action_extension.end_date like "%{$search}%" OR 
	ww_partners_movement_action_extension.no_of_months like "%{$search}%" OR 
	DATE_FORMAT(ww_partners_movement_action.effectivity_date, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_partners_movement_action.remarks like "%{$search}%" OR 
	ww_partners_movement_action.grade like "%{$search}%" OR 
	ww_partners_movement_action_transfer.to_id like "%{$search}%" OR 
	ww_partners_movement_action_transfer.from_id like "%{$search}%" OR 
	ww_partners_movement_action_transfer.field_id like "%{$search}%" OR 
	ww_partners_movement.remarks like "%{$search}%" OR 
	T4.type like "%{$search}%" OR 
	T2.cause like "%{$search}%" OR 
	T1.display_name like "%{$search}%" OR 
	ww_partners_movement_action_compensation.to_salary like "%{$search}%" OR 
	ww_partners_movement_action_compensation.current_salary like "%{$search}%"
)';