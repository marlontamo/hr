<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_training_evaluation_template`.`evaluation_template_id` as record_id, ww_training_evaluation_template.description as "training_evaluation_template_description", T2.applicable_for as "training_evaluation_template_applicable_for", ww_training_evaluation_template.title as "training_evaluation_template_title", `ww_training_evaluation_template`.`created_on` as "training_evaluation_template_created_on", `ww_training_evaluation_template`.`created_by` as "training_evaluation_template_created_by", `ww_training_evaluation_template`.`modified_on` as "training_evaluation_template_modified_on", `ww_training_evaluation_template`.`modified_by` as "training_evaluation_template_modified_by"
FROM (`ww_training_evaluation_template`)
LEFT JOIN `ww_training_applicable_for` T2 ON `T2`.`applicable_for_id` = `ww_training_evaluation_template`.`applicable_for`
WHERE (
	ww_training_evaluation_template.description like "%{$search}%" OR 
	T2.applicable_for like "%{$search}%" OR 
	ww_training_evaluation_template.title like "%{$search}%"
)';