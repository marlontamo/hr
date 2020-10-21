<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_performance_appraisal_contributor`.`appraisal_id` as record_id, T3.full_name as "performance_appraisal_contributor_contributor", T2.template_section as "performance_appraisal_contributor_template_section_id", T1.full_name as "performance_appraisal_contributor_user_id", `ww_performance_appraisal_contributor`.`created_on` as "performance_appraisal_contributor_created_on", `ww_performance_appraisal_contributor`.`created_by` as "performance_appraisal_contributor_created_by", `ww_performance_appraisal_contributor`.`modified_on` as "performance_appraisal_contributor_modified_on", `ww_performance_appraisal_contributor`.`modified_by` as "performance_appraisal_contributor_modified_by"
FROM (`ww_performance_appraisal_contributor`)
LEFT JOIN `ww_users` T3 ON `T3`.`user_id` = `ww_performance_appraisal_contributor`.`contributor`
LEFT JOIN `ww_performance_template_section` T2 ON `T2`.`template_section_id` = `ww_performance_appraisal_contributor`.`template_section_id`
LEFT JOIN `ww_users` T1 ON `T1`.`user_id` = `ww_performance_appraisal_contributor`.`user_id`
WHERE (
	T3.full_name like "%{$search}%" OR 
	T2.template_section like "%{$search}%" OR 
	T1.full_name like "%{$search}%"
)';