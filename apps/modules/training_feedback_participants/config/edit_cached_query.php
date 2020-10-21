<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = '
SELECT `ww_training_feedback`.`feedback_id` as record_id,
`ww_users`.`full_name` AS "training_feedback.name", 
`ww_training_calendar_session`.`session_date` as `training_feedback.start_date`,
`ww_training_calendar_session`.`sessiontime_from` as `training_feedback.start_time`,
`ww_training_calendar_session`.`sessiontime_to` as `training_feedback.end_time`,
`ww_training_calendar_session`.`instructor` as `training_feedback.instructor`,
`ww_training_feedback`.`created_on` as "training_feedback.created_on", 
`ww_training_feedback`.`created_by` as "training_feedback.created_by", 
`ww_training_feedback`.`modified_on` as "training_feedback.modified_on", 
`ww_training_feedback`.`modified_by` as "training_feedback.modified_by", 
ww_training_feedback.average_score as "training_feedback.average_score", 
ww_training_feedback.total_score as "training_feedback.total_score"
FROM (`ww_training_feedback`) 
    LEFT JOIN `ww_users` 
    	ON `ww_users`.`user_id` = `ww_training_feedback`.`employee_id` 
    LEFT JOIN `ww_partners` 
    	ON `ww_partners`.`user_id` = `ww_training_feedback`.`employee_id`
	LEFT JOIN `ww_training_calendar_session` 
    	ON `ww_training_calendar_session`.`training_calendar_id` = `ww_training_feedback`.`training_calendar_id`
WHERE `ww_training_feedback`.`feedback_id` = "{$record_id}"';