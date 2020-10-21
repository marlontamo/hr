<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_training_cost`.`cost_id` as record_id, ww_training_cost.description as "training_cost_description", ww_training_cost.cost as "training_cost_cost", `ww_training_cost`.`created_on` as "training_cost_created_on", `ww_training_cost`.`created_by` as "training_cost_created_by", `ww_training_cost`.`modified_on` as "training_cost_modified_on", `ww_training_cost`.`modified_by` as "training_cost_modified_by"
FROM (`ww_training_cost`)
WHERE (
	ww_training_cost.description like "%{$search}%" OR 
	ww_training_cost.cost like "%{$search}%"
)';