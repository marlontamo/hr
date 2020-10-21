<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT `ww_training_cost`.`cost_id` as record_id, `ww_training_cost`.`created_on` as "training_cost.created_on", `ww_training_cost`.`created_by` as "training_cost.created_by", `ww_training_cost`.`modified_on` as "training_cost.modified_on", `ww_training_cost`.`modified_by` as "training_cost.modified_by", ww_training_cost.description as "training_cost.description", ww_training_cost.cost as "training_cost.cost"
FROM (`ww_training_cost`)
WHERE `ww_training_cost`.`cost_id` = "{$record_id}"';