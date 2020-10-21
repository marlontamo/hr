<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_performance_setup_rating_score`.`rating_score_id` as record_id, ww_performance_setup_rating_score.description as "performance_setup_rating_score_description", ww_performance_setup_rating_score.rating_score as "performance_setup_rating_score_rating_score", T1.rating_group as "performance_setup_rating_score_rating_group_id", `ww_performance_setup_rating_score`.`created_on` as "performance_setup_rating_score_created_on", `ww_performance_setup_rating_score`.`created_by` as "performance_setup_rating_score_created_by", `ww_performance_setup_rating_score`.`modified_on` as "performance_setup_rating_score_modified_on", `ww_performance_setup_rating_score`.`modified_by` as "performance_setup_rating_score_modified_by"
FROM (`ww_performance_setup_rating_score`)
LEFT JOIN `ww_performance_setup_rating_group` T1 ON `T1`.`rating_group_id` = `ww_performance_setup_rating_score`.`rating_group_id`
WHERE (
	ww_performance_setup_rating_score.description like "%{$search}%" OR 
	ww_performance_setup_rating_score.rating_score like "%{$search}%" OR 
	T1.rating_group like "%{$search}%"
)';