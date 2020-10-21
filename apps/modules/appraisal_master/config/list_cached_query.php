<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_performance_competency_category`.`competency_category_id` as record_id, ww_performance_competency_category.description as "performance_competency_category_description", ww_performance_competency_category.competency_category as "performance_competency_category_competency_category", `ww_performance_competency_category`.`created_on` as "performance_competency_category_created_on", `ww_performance_competency_category`.`created_by` as "performance_competency_category_created_by", `ww_performance_competency_category`.`modified_on` as "performance_competency_category_modified_on", `ww_performance_competency_category`.`modified_by` as "performance_competency_category_modified_by"
FROM (`ww_performance_competency_category`)
WHERE (
	ww_performance_competency_category.description like "%{$search}%" OR 
	ww_performance_competency_category.competency_category like "%{$search}%"
)';