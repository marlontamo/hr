<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_performance_setup_rating_group`.`rating_group_id` as record_id, IF(ww_performance_setup_rating_group.status_id = 1, "Yes", "No") as "performance_setup_rating_group_status_id", ww_performance_setup_rating_group.description as "performance_setup_rating_group_description", ww_performance_setup_rating_group.rating_group as "performance_setup_rating_group_rating_group", `ww_performance_setup_rating_group`.`created_on` as "performance_setup_rating_group_created_on", `ww_performance_setup_rating_group`.`created_by` as "performance_setup_rating_group_created_by", `ww_performance_setup_rating_group`.`modified_on` as "performance_setup_rating_group_modified_on", `ww_performance_setup_rating_group`.`modified_by` as "performance_setup_rating_group_modified_by"
FROM (`ww_performance_setup_rating_group`)
WHERE (
	IF(ww_performance_setup_rating_group.status_id = 1, "Yes", "No") like "%{$search}%" OR 
	ww_performance_setup_rating_group.description like "%{$search}%" OR 
	ww_performance_setup_rating_group.rating_group like "%{$search}%"
)';