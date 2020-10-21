<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_training_calendar`.`training_calendar_id` as record_id,
`ww_training_calendar`.`topic` as training_calendar_topic, 
CONCAT( `t1`.`course` ) AS training_subject, 
`ww_training_calendar`.`training_calendar_id`, 
`ww_training_feedback`.`feedback_id`,
`t3`.`start_date` as `start_date`,
`t3`.`end_date` as `end_date`,
`t2`.`sessiontime_from` as `sessiontime_from`,
`t2`.`sessiontime_to` as `sessiontime_to`,
`t2`.`instructor` as `instructor`
FROM (`ww_training_calendar`)
LEFT JOIN `ww_training_calendar_session` t2 ON `t2`.`training_calendar_id`=`ww_training_calendar`.`training_calendar_id`
LEFT JOIN `ww_training_employee_database` t3 ON `t3`.`calendar_id`=`ww_training_calendar`.`training_calendar_id`
LEFT JOIN `ww_training_course` t1 ON `t1`.`course_id`=`ww_training_calendar`.`course_id`
LEFT JOIN `ww_training_feedback` ON `ww_training_feedback`.`training_calendar_id` = `ww_training_calendar`.`training_calendar_id`
WHERE (`ww_training_calendar`.`closed` =  1)
';