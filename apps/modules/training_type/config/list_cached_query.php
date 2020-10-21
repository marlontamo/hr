<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_training_type`.`type_id` as record_id, 
`ww_training_type`.`description` as "training_type_description", `ww_training_type`.`training_type` as "training_type_type", `ww_training_type`.`training_type_code` as "training_type_type_code", `ww_training_type`.`created_on` as "training_type_created_on", `ww_training_type`.`created_by` as "training_type_created_by", `ww_training_type`.`modified_on` as "training_type_modified_on", `ww_training_type`.`modified_by` as "training_type_modified_by"
FROM (`ww_training_type`)
WHERE (
	`ww_training_type`.`description` like "%{$search}%" OR 
	`ww_training_type`.`training_type` like "%{$search}%" OR 
	`ww_training_type`.`training_type_code` like "%{$search}%"
)';