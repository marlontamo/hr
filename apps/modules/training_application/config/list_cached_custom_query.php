<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_training_application`.`application_id` as record_id, ww_training_application.remarks as "training_application_remarks", ww_training_application.total_hours as "training_application_total_hours", DATE_FORMAT(ww_training_application.date_to, \'%M %d, %Y\') as "training_application_date_to", DATE_FORMAT(ww_training_application.date_from, \'%M %d, %Y\') as "training_application_date_from", ww_training_application.estimated_cost as "training_application_estimated_cost", ww_training_application.venue as "training_application_venue", T4.source as "training_application_source_id", T3.course as "training_application_course_id", T2.competency as "training_application_competency_id", T1.type as "training_application_type_id", `ww_training_application`.`created_on` as "training_application_created_on", `ww_training_application`.`created_by` as "training_application_created_by", `ww_training_application`.`modified_on` as "training_application_modified_on", `ww_training_application`.`modified_by` as "training_application_modified_by"
 , T5.status as training_application_status_id, T5.status_code as training_application_status_code
FROM (`ww_training_application`)
LEFT JOIN `ww_training_source` T4 ON `T4`.`source_id` = `ww_training_application`.`source_id`
LEFT JOIN `ww_training_course` T3 ON `T3`.`course_id` = `ww_training_application`.`course_id`
LEFT JOIN `ww_training_competency` T2 ON `T2`.`competency_id` = `ww_training_application`.`competency_id`
LEFT JOIN `ww_training_type` T1 ON `T1`.`type_id` = `ww_training_application`.`type_id`
LEFT JOIN `ww_training_application_status` T5 ON `T5`.`application_status_id` = `ww_training_application`.`status_id`
WHERE (
	ww_training_application.remarks like "%{$search}%" OR 
	ww_training_application.total_hours like "%{$search}%" OR 
	DATE_FORMAT(ww_training_application.date_to, \'%M %d, %Y\') like "%{$search}%" OR 
	DATE_FORMAT(ww_training_application.date_from, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_training_application.estimated_cost like "%{$search}%" OR 
	ww_training_application.venue like "%{$search}%" OR 
	T4.source like "%{$search}%" OR 
	T3.course like "%{$search}%" OR 
	T2.competency like "%{$search}%" OR 
	T1.type like "%{$search}%"
)';