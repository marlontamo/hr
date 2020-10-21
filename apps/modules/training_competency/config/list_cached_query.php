<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_training_competency`.`competency_id` as record_id, ww_training_competency.description as "training_competency_description", ww_training_competency.competency_code as "training_competency_competency_code", ww_training_competency.competency as "training_competency_competency", `ww_training_competency`.`created_on` as "training_competency_created_on", `ww_training_competency`.`created_by` as "training_competency_created_by", `ww_training_competency`.`modified_on` as "training_competency_modified_on", `ww_training_competency`.`modified_by` as "training_competency_modified_by"
FROM (`ww_training_competency`)
WHERE (
	ww_training_competency.description like "%{$search}%" OR 
	ww_training_competency.competency_code like "%{$search}%" OR 
	ww_training_competency.competency like "%{$search}%"
)';