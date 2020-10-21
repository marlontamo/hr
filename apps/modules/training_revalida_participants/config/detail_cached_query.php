<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 
'SELECT `ww_training_revalida`.`training_revalida_id` as record_id, 
`ww_training_revalida`.`created_date` as "training_revalida_created_on", 
`ww_training_feedback`.`created_by` as "training_revalida_created_by", 
`ww_training_feedback`.`updated_date` as "training_revalida_modified_on", 
`ww_training_feedback`.`updated_by` as "training_revalida_modified_by"
FROM (`ww_training_revalida`)
WHERE `ww_training_revalida`.`revalida_id` = "{$record_id}"';