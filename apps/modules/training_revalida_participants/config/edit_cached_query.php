<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config["edit_cached_query"] = '
SELECT `ww_training_revalida`.`training_revalida_id` as record_id,
`ww_users`.`full_name` AS "training_revalida.name", 
`ww_training_calendar_session`.`session_date` as `training_revalida.start_date`,
`ww_training_calendar_session`.`sessiontime_from` as `training_revalida.start_time`,
`ww_training_calendar_session`.`sessiontime_to` as `training_revalida.end_time`,
`ww_training_calendar_session`.`session_date` as `training_revalida.instructor`,
`ww_training_revalida`.`created_date` as "training_revalida.created_on", 
`ww_training_revalida`.`created_by` as "training_revalida.created_by", 
`ww_training_revalida`.`updated_date` as "traininteg_revalida.modified_on", 
`ww_training_revalida`.`updated_by` as "training_revalida.modified_by", 
ww_training_revalida.average_score as "training_revalida.average_score", 
ww_training_revalida.total_score as "training_revalida.total_score"
FROM (`ww_training_revalida`) 
    LEFT JOIN `ww_users` 
    	ON `ww_users`.`user_id` = `ww_training_revalida`.`employee_id` 
    LEFT JOIN `ww_partners` 
    	ON `ww_partners`.`user_id` = `ww_training_revalida`.`employee_id`
	LEFT JOIN `ww_training_calendar_session` 
    	ON `ww_training_calendar_session`.`training_calendar_id` = `ww_training_revalida`.`training_calendar_id`
WHERE `ww_training_revalida`.`training_revalida_id` = "{$record_id}"';