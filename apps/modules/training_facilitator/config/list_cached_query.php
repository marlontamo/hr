<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_training_facilitator`.`facilitator_id` as record_id, ww_training_facilitator.course_id as "training_facilitator_course_id", IF(ww_training_facilitator.is_internal = 1, "Yes", "No") as "training_facilitator_is_internal", T6.provider as "training_facilitator_provider_id", ww_training_facilitator.facilitator as "training_facilitator_facilitator", `ww_training_facilitator`.`created_on` as "training_facilitator_created_on", `ww_training_facilitator`.`created_by` as "training_facilitator_created_by", `ww_training_facilitator`.`modified_on` as "training_facilitator_modified_on", `ww_training_facilitator`.`modified_by` as "training_facilitator_modified_by"
FROM (`ww_training_facilitator`)
LEFT JOIN `ww_training_provider` T6 ON `T6`.`provider_id` = `ww_training_facilitator`.`provider_id`
WHERE (
	ww_training_facilitator.course_id like "%{$search}%" OR 
	IF(ww_training_facilitator.is_internal = 1, "Yes", "No") like "%{$search}%" OR 
	T6.provider like "%{$search}%" OR 
	ww_training_facilitator.facilitator like "%{$search}%"
)';