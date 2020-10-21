<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_training_calendar`.`training_calendar_id` as record_id, DATE_FORMAT(ww_training_calendar.revalida_date, \'%M %d, %Y\') as "training_calendar_revalida_date", IF(ww_training_calendar.planned = 1, "Yes", "No") as "training_calendar_planned", IF(ww_training_calendar.with_certification = 1, "Yes", "No") as "training_calendar_with_certification", T17.revalida_type as "training_calendar_training_revalida_master_id", DATE_FORMAT(ww_training_calendar.publish_date, \'%M %d, %Y\') as "training_calendar_publish_date", ww_training_calendar.feedback_category_id as "training_calendar_feedback_category_id", DATE_FORMAT(ww_training_calendar.last_registration_date, \'%M %d, %Y\') as "training_calendar_last_registration_date", ww_training_calendar.cost_per_pax as "training_calendar_cost_per_pax", DATE_FORMAT(ww_training_calendar.registration_date, \'%M %d, %Y\') as "training_calendar_registration_date", ww_training_calendar.topic as "training_calendar_topic", ww_training_calendar.venue as "training_calendar_venue", ww_training_calendar.equipment as "training_calendar_equipment", IF(ww_training_calendar.tba = 1, "Yes", "No") as "training_calendar_tba", ww_training_calendar.training_capacity as "training_calendar_training_capacity", ww_training_calendar.min_training_capacity as "training_calendar_min_training_capacity", ww_training_calendar.training_category_id as "training_calendar_training_category_id", ww_training_calendar.training_calendar_id as "training_calendar_training_calendar_id", T2.calendar_type as "training_calendar_calendar_type_id", T1.course as "training_calendar_course_id", `ww_training_calendar`.`created_on` as "training_calendar_created_on", `ww_training_calendar`.`created_by` as "training_calendar_created_by", `ww_training_calendar`.`modified_on` as "training_calendar_modified_on", `ww_training_calendar`.`modified_by` as "training_calendar_modified_by",
`ww_training_calendar`.`closed` as "training_calendar_status"
FROM (`ww_training_calendar`)
LEFT JOIN `ww_training_revalida_master` T17 ON `T17`.`training_revalida_master_id` = `ww_training_calendar`.`training_revalida_master_id`
LEFT JOIN `ww_training_calendar_type` T2 ON `T2`.`calendar_type_id` = `ww_training_calendar`.`calendar_type_id`
LEFT JOIN `ww_training_course` T1 ON `T1`.`course_id` = `ww_training_calendar`.`course_id`
WHERE (
	DATE_FORMAT(ww_training_calendar.revalida_date, \'%M %d, %Y\') like "%{$search}%" OR 
	IF(ww_training_calendar.planned = 1, "Yes", "No") like "%{$search}%" OR 
	IF(ww_training_calendar.with_certification = 1, "Yes", "No") like "%{$search}%" OR 
	T17.revalida_type like "%{$search}%" OR 
	DATE_FORMAT(ww_training_calendar.publish_date, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_training_calendar.feedback_category_id like "%{$search}%" OR 
	DATE_FORMAT(ww_training_calendar.last_registration_date, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_training_calendar.cost_per_pax like "%{$search}%" OR 
	DATE_FORMAT(ww_training_calendar.registration_date, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_training_calendar.topic like "%{$search}%" OR 
	ww_training_calendar.venue like "%{$search}%" OR 
	ww_training_calendar.equipment like "%{$search}%" OR 
	IF(ww_training_calendar.tba = 1, "Yes", "No") like "%{$search}%" OR 
	ww_training_calendar.training_capacity like "%{$search}%" OR 
	ww_training_calendar.min_training_capacity like "%{$search}%" OR 
	ww_training_calendar.training_category_id like "%{$search}%" OR 
	ww_training_calendar.training_calendar_id like "%{$search}%" OR 
	T2.calendar_type like "%{$search}%" OR 
	T1.course like "%{$search}%"
)';