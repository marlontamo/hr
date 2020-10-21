<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_performance_setup_scorecard`.`scorecard_id` as record_id, IF(ww_performance_setup_scorecard.status_id = 1, "Yes", "No") as "performance_setup_scorecard_status_id", ww_performance_setup_scorecard.description as "performance_setup_scorecard_description", ww_performance_setup_scorecard.scorecard as "performance_setup_scorecard_scorecard", `ww_performance_setup_scorecard`.`created_on` as "performance_setup_scorecard_created_on", `ww_performance_setup_scorecard`.`created_by` as "performance_setup_scorecard_created_by", `ww_performance_setup_scorecard`.`modified_on` as "performance_setup_scorecard_modified_on", `ww_performance_setup_scorecard`.`modified_by` as "performance_setup_scorecard_modified_by"
FROM (`ww_performance_setup_scorecard`)
WHERE (
	IF(ww_performance_setup_scorecard.status_id = 1, "Yes", "No") like "%{$search}%" OR 
	ww_performance_setup_scorecard.description like "%{$search}%" OR 
	ww_performance_setup_scorecard.scorecard like "%{$search}%"
)';