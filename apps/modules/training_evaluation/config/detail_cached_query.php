<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT `ww_training_calendar`.`training_calendar_id` as record_id, `ww_training_calendar`.`created_on` as "training_calendar_created_on", `ww_training_calendar`.`created_by` as "training_calendar_created_by", `ww_training_calendar`.`modified_on` as "training_calendar_modified_on", `ww_training_calendar`.`modified_by` as "training_calendar_modified_by"
FROM (`ww_training_calendar`)
WHERE `ww_training_calendar`.`training_calendar_id` = "{$record_id}"';