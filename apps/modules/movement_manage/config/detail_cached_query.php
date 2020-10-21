<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT `ww_partners_movement`.`movement_id` as record_id, 
	ww_partners_movement_action_moving.further_reason as "partners_movement_action_moving_further_reason", 
	ww_partners_movement_reason.reason as "partners_movement_action_moving_reason_id", 
	IF(ww_partners_movement_action_moving.blacklisted = 1, "Yes", "No") as "partners_movement_action_moving_blacklisted", 
	DATE_FORMAT(ww_partners_movement_action_moving.end_date, \'%M %d, %Y\') as "partners_movement_action_moving_end_date", 
	ww_partners_movement_action_extension.end_date as "partners_movement_action_extension_end_date", 
	ww_partners_movement_action_extension.no_of_months as "partners_movement_action_extension_no_of_months", 
	DATE_FORMAT(ww_partners_movement_action.effectivity_date, \'%M %d, %Y\') as "partners_movement_action_effectivity_date", 
	ww_partners_movement_action.remarks as "partners_movement_action_remarks", 
	ww_partners_movement.hrd_remarks as "partners_movement_hrd_remarks",
	ww_partners_movement.remarks as "partners_movement_remarks", 
	ww_partners_movement_type.type as "partners_movement_action_type_id", 
	ww_partners_movement_cause.cause as "partners_movement_due_to_id", 
	ww_users.display_name as "partners_movement_action_user_id", 
	ww_partners_movement_action_compensation.to_salary as "partners_movement_action_compensation_to_salary", 
	ww_partners_movement_action_compensation.current_salary as "partners_movement_action_compensation_current_salary", 
	`ww_partners_movement`.`created_on` as "partners_movement_created_on", 
	`ww_partners_movement`.`created_by` as "partners_movement_created_by", 
	`ww_partners_movement`.`modified_on` as "partners_movement_modified_on", 
	`ww_partners_movement`.`modified_by` as "partners_movement_modified_by", 
	`T8`.full_name as "partners_movement_created_by_fname",
	ww_partners_movement_action_moving.further_reason as "partners_movement_action_moving_further_reason", 
	ww_partners_movement_reason.reason as "partners_movement_action_moving_reason_id", 
	IF(ww_partners_movement_action_moving.blacklisted = 1, "Yes", "No") as "partners_movement_action_moving_blacklisted", 
	DATE_FORMAT(ww_partners_movement_action_moving.end_date, \'%M %d, %Y\') as "partners_movement_action_moving_end_date", 
	ww_partners_movement_action_extension.end_date as "partners_movement_action_extension_end_date", 
	ww_partners_movement_action_extension.no_of_months as "partners_movement_action_extension_no_of_months", 
	DATE_FORMAT(ww_partners_movement_action.effectivity_date, \'%M %d, %Y\') as "partners_movement_action_effectivity_date", 
	ww_partners_movement_action.remarks as "partners_movement_action_remarks", 
	ww_partners_movement_action.photo as "partners_movement_action.photo", 
	ww_partners_movement.remarks as "partners_movement_remarks", 
	ww_partners_movement_type.type as "partners_movement_action_type_id", 
	ww_partners_movement_cause.cause_id as "partners_movement_due_to_id", 
	ww_users.display_name as "partners_movement_action_user_id", 
	ww_partners_movement_action_compensation.to_salary as "partners_movement_action_compensation_to_salary", 
	ww_partners_movement_action_compensation.current_salary as "partners_movement_action_compensation_current_salary",
	`ww_partners_movement`.`status_id` as "partners_movement_status_id",
	T7.status_id as "approver_movement_status_id",
	MAX(`T9`.full_name) as "partners_movement_reviewed_by",
	MAX(`T10`.full_name) as "partners_movement_approver1",
	MAX(`T11`.full_name) as "partners_movement_approver2",
	MAX(CASE WHEN `ww_partners_movement_approver_hr`.`sequence` = 1 THEN `ww_partners_movement_approver_hr`.`comment_date` END) AS "partners_movement_reviewed_by_approved_date",
	MAX(CASE WHEN `ww_partners_movement_approver_hr`.`sequence` = 2 THEN `ww_partners_movement_approver_hr`.`comment_date` END) AS "partners_movement_approver1_approved_date",
	MAX(CASE WHEN `ww_partners_movement_approver_hr`.`sequence` = 3 THEN `ww_partners_movement_approver_hr`.`comment_date` END) AS "partners_movement_approver2_approved_date"	
FROM (`ww_partners_movement`)
LEFT JOIN `ww_partners_movement_action_moving` ON `ww_partners_movement_action_moving`.`movement_id` = `ww_partners_movement`.`movement_id`
LEFT JOIN `ww_partners_movement_action_extension` ON `ww_partners_movement_action_extension`.`movement_id` = `ww_partners_movement`.`movement_id`
LEFT JOIN `ww_partners_movement_action` ON `ww_partners_movement_action`.`movement_id` = `ww_partners_movement`.`movement_id`
LEFT JOIN `ww_partners_movement_action_compensation` ON `ww_partners_movement_action_compensation`.`movement_id` = `ww_partners_movement`.`movement_id`
LEFT JOIN `ww_partners_movement_reason` ON `ww_partners_movement_reason`.`reason_id` = `ww_partners_movement_action_moving`.`reason_id`
LEFT JOIN `ww_partners_movement_type` ON `ww_partners_movement_type`.`type_id` = `ww_partners_movement_action`.`type_id`
LEFT JOIN `ww_partners_movement_cause` ON `ww_partners_movement_cause`.`cause_id` = `ww_partners_movement`.`due_to_id`
LEFT JOIN `ww_partners_movement_remarks` ON `ww_partners_movement_remarks`.`remarks_print_report_id` = `ww_partners_movement`.`remarks_print_report_id`
LEFT JOIN `ww_partners_movement_approver` T6 ON `T6`.`movement_id` = `ww_partners_movement`.`movement_id`
LEFT JOIN `ww_partners_movement_status` T7 ON `T7`.`status_id` = `T6`.`movement_status_id`
LEFT JOIN `ww_users` ON `ww_users`.`user_id` = `ww_partners_movement_action`.`user_id`
LEFT JOIN `ww_users` T8 ON `T8`.`user_id` = `ww_partners_movement`.`created_by`
LEFT JOIN `ww_partners_movement_approver_hr` ON `ww_partners_movement`.`movement_id` = `ww_partners_movement_approver_hr`.`movement_id`
LEFT JOIN `ww_users` T9 ON `T9`.`user_id` = `ww_partners_movement_approver_hr`.`user_id` AND `ww_partners_movement_approver_hr`.`sequence` = 1
LEFT JOIN `ww_users` T10 ON `T10`.`user_id` = `ww_partners_movement_approver_hr`.`user_id` AND `ww_partners_movement_approver_hr`.`sequence` = 2
LEFT JOIN `ww_users` T11 ON `T11`.`user_id` = `ww_partners_movement_approver_hr`.`user_id` AND `ww_partners_movement_approver_hr`.`sequence` = 3
WHERE (`ww_partners_movement`.`movement_id` = "{$record_id}" AND `T6`.`user_id` = {$approver_userid}) OR (`ww_partners_movement`.`movement_id` = "{$record_id}" AND `ww_partners_movement`.created_by = {$approver_userid})';