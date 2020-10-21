<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT `ww_training_feedback`.`feedback_id` as record_id, `ww_training_feedback`.`created_on` as "training_feedback_created_on", `ww_training_feedback`.`created_by` as "training_feedback_created_by", `ww_training_feedback`.`modified_on` as "training_feedback_modified_on", `ww_training_feedback`.`modified_by` as "training_feedback_modified_by"
FROM (`ww_training_feedback`)
WHERE `ww_training_feedback`.`feedback_id` = "{$record_id}"';