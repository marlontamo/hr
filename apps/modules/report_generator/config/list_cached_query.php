<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_report_generator`.`report_id` as record_id, ww_report_generator.roles as "report_generator_roles", T4.category as "report_generator_category_id", ww_report_generator.description as "report_generator_description", ww_report_generator.report_name as "report_generator_report_name", ww_report_generator.report_code as "report_generator_report_code", `ww_report_generator`.`created_on` as "report_generator_created_on", `ww_report_generator`.`created_by` as "report_generator_created_by", `ww_report_generator`.`modified_on` as "report_generator_modified_on", `ww_report_generator`.`modified_by` as "report_generator_modified_by", ww_users.full_name as "report_generator_created_by"
FROM (`ww_report_generator`)
LEFT JOIN `ww_report_generator_category` T4 ON `T4`.`category_id` = `ww_report_generator`.`category_id`
LEFT JOIN `ww_users` on `ww_users`.`user_id` = `ww_report_generator`.`created_by`
WHERE (
	ww_report_generator.roles like "%{$search}%" OR 
	T4.category like "%{$search}%" OR 
	ww_report_generator.description like "%{$search}%" OR 
	ww_report_generator.report_name like "%{$search}%" OR 
	ww_report_generator.report_code like "%{$search}%"
)';