<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_performance_competency_level`.`competency_level_id` as record_id, T1.competency_category as "performance_competency_level_competency_category_id", T2.competency_values as "performance_competency_level_competency_values_id", T5.competency_libraries as "performance_competency_level_competency_libraries_id", ww_performance_competency_level.competency_level as "performance_competency_level_competency_level", ww_performance_competency_level.description as "performance_competency_level_description", `ww_performance_competency_level`.`created_on` as "performance_competency_level_created_on", `ww_performance_competency_level`.`created_by` as "performance_competency_level_created_by", `ww_performance_competency_level`.`modified_on` as "performance_competency_level_modified_on", `ww_performance_competency_level`.`modified_by` as "performance_competency_level_modified_by"
FROM (`ww_performance_competency_level`)
LEFT JOIN `ww_performance_competency_category` T1 ON `T1`.`competency_category_id` = `ww_performance_competency_level`.`competency_category_id`
LEFT JOIN `ww_performance_competency_values` T2 ON `T2`.`competency_values_id` = `ww_performance_competency_level`.`competency_values_id`
LEFT JOIN `ww_performance_competency_libraries` T5 ON `T5`.`competency_libraries_id` = `ww_performance_competency_level`.`competency_libraries_id`
WHERE (
	T1.competency_category like "%{$search}%" OR 
	T2.competency_values like "%{$search}%" OR 
	T5.competency_libraries like "%{$search}%" OR 
	ww_performance_competency_level.competency_level like "%{$search}%" OR 
	ww_performance_competency_level.description like "%{$search}%"
)';