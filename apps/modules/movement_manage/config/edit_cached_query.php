<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_partners_movement`.`movement_id` as record_id, 
	`ww_partners_movement`.`created_on` as "partners_movement.created_on", 
	`ww_partners_movement`.`created_by` as "partners_movement.created_by", 
	`ww_partners_movement`.`modified_on` as "partners_movement.modified_on", 
	`ww_partners_movement`.`modified_by` as "partners_movement.modified_by", 
	ww_partners_movement_action_moving.further_reason as "partners_movement_action_moving.further_reason", 
	ww_partners_movement_action_moving.reason_id as "partners_movement_action_moving.reason_id", 
	ww_partners_movement_action_moving.blacklisted as "partners_movement_action_moving.blacklisted", 
	DATE_FORMAT(ww_partners_movement_action_moving.end_date, \'%M %d, %Y\') as "partners_movement_action_moving.end_date", 
	ww_partners_movement_action_extension.end_date as "partners_movement_action_extension.end_date", 
	ww_partners_movement_action_extension.no_of_months as "partners_movement_action_extension.no_of_months", 
	DATE_FORMAT(ww_partners_movement_action.effectivity_date, \'%M %d, %Y\') as "partners_movement_action.effectivity_date", 
	ww_partners_movement_action.remarks as "partners_movement_action.remarks", 
	ww_partners_movement.remarks as "partners_movement.remarks", 
	ww_partners_movement_action.type_id as "partners_movement_action.type_id", 
	ww_partners_movement_action.type_category_id as "partners_movement_action.type_category_id", 	
	ww_partners_movement.due_to_id as "partners_movement.due_to_id", 
	ww_partners_movement.due_to_id as "partners_movement.remarks_print_report_id",
	ww_partners_movement_action.user_id as "partners_movement_action.user_id",
	ww_partners_movement_action.created_by as "partners_movement_action.created_by", 	 
	ww_partners_movement_action.photo as "partners_movement_action.photo", 
	ww_partners_movement_action_compensation.to_salary as "partners_movement_action_compensation.to_salary", 
	ww_partners_movement_action_compensation.current_salary as "partners_movement_action_compensation.current_salary",
	`ww_partners_movement`.`status_id` as "partners_movement.status_id"
FROM (`ww_partners_movement`)
LEFT JOIN `ww_partners_movement_action_moving` ON `ww_partners_movement_action_moving`.`movement_id` = `ww_partners_movement`.`movement_id`
LEFT JOIN `ww_partners_movement_action_extension` ON `ww_partners_movement_action_extension`.`movement_id` = `ww_partners_movement`.`movement_id`
LEFT JOIN `ww_partners_movement_action` ON `ww_partners_movement_action`.`movement_id` = `ww_partners_movement`.`movement_id`
LEFT JOIN `ww_partners_movement_action_transfer` ON `ww_partners_movement_action_transfer`.`movement_id` = `ww_partners_movement`.`movement_id`
LEFT JOIN `ww_partners_movement_action_compensation` ON `ww_partners_movement_action_compensation`.`movement_id` = `ww_partners_movement`.`movement_id`
WHERE `ww_partners_movement`.`movement_id` = "{$record_id}"';