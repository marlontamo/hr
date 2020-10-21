<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT 
`ww_training_type`.`type_id` as record_id, 
`ww_training_type`.`created_on` as "training_type.created_on", 
`ww_training_type`.`created_by` as "training_type.created_by", 
`ww_training_type`.`modified_on` as "training_type.modified_on", 
`ww_training_type`.`modified_by` as "training_type.modified_by", 
`ww_training_type`.`description` as "training_type.description", 
`ww_training_type`.`training_type` as "training_type.training_type", 
`ww_training_type`.`training_type_code` as "training_type.training_type_code"
FROM (`ww_training_type`)
WHERE `ww_training_type`.`type_id` = "{$record_id}"';