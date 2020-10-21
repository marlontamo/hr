<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_training_course`.`course_id` as record_id, ww_training_course.position_id as "training_course_position_id", IF(ww_training_course.planned = 1, "Yes", "No") as "training_course_planned", ww_training_course.facilitator as "training_course_facilitator", T4.provider as "training_course_provider_id", T3.training_type as "training_course_type_id", T2.category as "training_course_category_id", ww_training_course.course as "training_course_course", ww_training_course.remarks as "training_course_remarks", ww_training_course.length_of_service as "training_course_length_of_service", ww_training_course.cost as "training_course_cost", IF(ww_training_course.with_bond = 1, "Yes", "No") as "training_course_with_bond", `ww_training_course`.`created_on` as "training_course_created_on", `ww_training_course`.`created_by` as "training_course_created_by", `ww_training_course`.`modified_on` as "training_course_modified_on", `ww_training_course`.`modified_by` as "training_course_modified_by"
FROM (`ww_training_course`)
LEFT JOIN `ww_training_provider` T4 ON `T4`.`provider_id` = `ww_training_course`.`provider_id`
LEFT JOIN `ww_training_type` T3 ON `T3`.`type_id` = `ww_training_course`.`type_id`
LEFT JOIN `ww_training_category` T2 ON `T2`.`category_id` = `ww_training_course`.`category_id`
WHERE (
	ww_training_course.position_id like "%{$search}%" OR 
	IF(ww_training_course.planned = 1, "Yes", "No") like "%{$search}%" OR 
	ww_training_course.facilitator like "%{$search}%" OR 
	T4.provider like "%{$search}%" OR 
	T3.training_type like "%{$search}%" OR 
	T2.category like "%{$search}%" OR 
	ww_training_course.course like "%{$search}%" OR 
	ww_training_course.remarks like "%{$search}%" OR 
	ww_training_course.length_of_service like "%{$search}%" OR 
	ww_training_course.cost like "%{$search}%" OR 
	IF(ww_training_course.with_bond = 1, "Yes", "No") like "%{$search}%"
)';