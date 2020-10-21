<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_performance_competency_values`.`competency_values_id` as record_id, T1.competency_category as "performance_competency_values_competency_category_id", ww_performance_competency_values.competency_values as "performance_competency_values_competency_values", ww_performance_competency_values.description as "performance_competency_values_description", `ww_performance_competency_values`.`created_on` as "performance_competency_values_created_on", `ww_performance_competency_values`.`created_by` as "performance_competency_values_created_by", `ww_performance_competency_values`.`modified_on` as "performance_competency_values_modified_on", `ww_performance_competency_values`.`modified_by` as "performance_competency_values_modified_by"
FROM (`ww_performance_competency_values`)
LEFT JOIN `ww_performance_competency_category` T1 ON `T1`.`competency_category_id` = `ww_performance_competency_values`.`competency_category_id`
WHERE (
	T1.competency_category like "%{$search}%" OR 
	ww_performance_competency_values.competency_values like "%{$search}%" OR 
	ww_performance_competency_values.description like "%{$search}%"
)';