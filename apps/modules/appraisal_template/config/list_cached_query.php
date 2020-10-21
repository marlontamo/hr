<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_performance_template`.`template_id` as record_id, ww_performance_template.template as "performance_template_template", ww_performance_template.template_code as "performance_template_template_code", T3.applicable_to as "performance_template_applicable_to_id", ww_performance_template.applicable_to as "performance_template_applicable_to", ww_performance_template.description as "performance_template_description", `ww_performance_template`.`created_on` as "performance_template_created_on", `ww_performance_template`.`created_by` as "performance_template_created_by", `ww_performance_template`.`modified_on` as "performance_template_modified_on", `ww_performance_template`.`modified_by` as "performance_template_modified_by"
FROM (`ww_performance_template`)
LEFT JOIN `ww_performance_template_applicable` T3 ON `T3`.`applicable_to_id` = `ww_performance_template`.`applicable_to_id`
WHERE (
	ww_performance_template.template like "%{$search}%" OR 
	ww_performance_template.template_code like "%{$search}%" OR 
	T3.applicable_to like "%{$search}%" OR 
	ww_performance_template.applicable_to like "%{$search}%" OR 
	ww_performance_template.description like "%{$search}%"
)';