<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_performance_planning`.`planning_id` as record_id, `ww_performance_planning`.`created_on` as "performance_planning.created_on", `ww_performance_planning`.`created_by` as "performance_planning.created_by", `ww_performance_planning`.`modified_on` as "performance_planning.modified_on", `ww_performance_planning`.`modified_by` as "performance_planning.modified_by"
FROM (`ww_performance_planning`)
WHERE `ww_performance_planning`.`planning_id` = "{$record_id}"';