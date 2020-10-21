<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_training_revalida_master`.`training_revalida_master_id` as record_id, T4.Course as "training_revalida_master_training_course", ww_training_revalida_master.revalida_type as "training_revalida_master_evaluation_type", `ww_training_revalida_master`.`created_on` as "training_revalida_master_created_on", `ww_training_revalida_master`.`created_by` as "training_revalida_master_created_by", `ww_training_revalida_master`.`modified_on` as "training_revalida_master_modified_on", `ww_training_revalida_master`.`modified_by` as "training_revalida_master_modified_by"
FROM (`ww_training_revalida_master`)
LEFT JOIN `ww_training_course` T4 ON `T4`.`course_id` = `ww_training_revalida_master`.`course_id`
WHERE (
	T4.Course like "%{$search}%" OR 
	ww_training_revalida_master.revalida_type like "%{$search}%"
)';