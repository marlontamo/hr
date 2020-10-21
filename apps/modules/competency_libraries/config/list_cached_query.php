<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_performance_competency_libraries`.`competency_libraries_id` as record_id, T1.competency_category as "performance_competency_libraries_competency_category_id", T2.competency_values as "performance_competency_libraries_competency_values_id", ww_performance_competency_libraries.competency_libraries as "performance_competency_libraries_competency_libraries", ww_performance_competency_libraries.description as "performance_competency_libraries_description", `ww_performance_competency_libraries`.`created_on` as "performance_competency_libraries_created_on", `ww_performance_competency_libraries`.`created_by` as "performance_competency_libraries_created_by", `ww_performance_competency_libraries`.`modified_on` as "performance_competency_libraries_modified_on", `ww_performance_competency_libraries`.`modified_by` as "performance_competency_libraries_modified_by"
FROM (`ww_performance_competency_libraries`)
LEFT JOIN `ww_performance_competency_category` T1 ON `T1`.`competency_category_id` = `ww_performance_competency_libraries`.`competency_category_id`
LEFT JOIN `ww_performance_competency_values` T2 ON `T2`.`competency_values_id` = `ww_performance_competency_libraries`.`competency_values_id`
WHERE (
	T1.competency_category like "%{$search}%" OR 
	T2.competency_values like "%{$search}%" OR 
	ww_performance_competency_libraries.competency_libraries like "%{$search}%" OR 
	ww_performance_competency_libraries.description like "%{$search}%"
)';