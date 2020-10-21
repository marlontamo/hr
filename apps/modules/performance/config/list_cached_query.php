<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_performance_setup_performance`.`performance_id` as record_id, IF(ww_performance_setup_performance.status_id = 1, "Yes", "No") as "performance_setup_performance_status_id", ww_performance_setup_performance.description as "performance_setup_performance_description", ww_performance_setup_performance.performance_group as "performance_setup_performance_performance_group", ww_performance_setup_performance.performance as "performance_setup_performance_performance", `ww_performance_setup_performance`.`created_on` as "performance_setup_performance_created_on", `ww_performance_setup_performance`.`created_by` as "performance_setup_performance_created_by", `ww_performance_setup_performance`.`modified_on` as "performance_setup_performance_modified_on", `ww_performance_setup_performance`.`modified_by` as "performance_setup_performance_modified_by"
FROM (`ww_performance_setup_performance`)
WHERE (
	IF(ww_performance_setup_performance.status_id = 1, "Yes", "No") like "%{$search}%" OR 
	ww_performance_setup_performance.description like "%{$search}%" OR 
	ww_performance_setup_performance.performance_group like "%{$search}%" OR 
	ww_performance_setup_performance.performance like "%{$search}%"
)';