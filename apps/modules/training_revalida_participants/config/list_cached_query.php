<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
  `ww_training_revalida`.`training_revalida_id` as record_id,
  `t0`.`full_name` AS training_revalida_participants_name,
  `ww_training_revalida`.`total_score` as training_revalida_participants_total_score,
  `ww_training_revalida`.`average_score` as training_revalida_participants_average_score
FROM
  (`ww_training_revalida`) 
  LEFT JOIN `ww_users` t0 
    ON `t0`.`user_id` = `ww_training_revalida`.`employee_id` 
  LEFT JOIN `ww_partners` 
    ON `ww_partners`.`user_id` = `ww_training_revalida`.`employee_id`';



