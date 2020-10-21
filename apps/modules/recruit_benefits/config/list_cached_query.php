<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_recruitment_benefit_package`.`package_id` as record_id, IF(ww_recruitment_benefit_package.status_id = 1, "Yes", "No") as "recruitment_benefit_package_status_id", ww_recruitment_benefit_package.description as "recruitment_benefit_package_description", T2.employment_type as "recruitment_benefit_package_rank_id", ww_recruitment_benefit_package.benefit as "recruitment_benefit_package_benefit", `ww_recruitment_benefit_package`.`created_on` as "recruitment_benefit_package_created_on", `ww_recruitment_benefit_package`.`created_by` as "recruitment_benefit_package_created_by", `ww_recruitment_benefit_package`.`modified_on` as "recruitment_benefit_package_modified_on", `ww_recruitment_benefit_package`.`modified_by` as "recruitment_benefit_package_modified_by"
FROM (`ww_recruitment_benefit_package`)
LEFT JOIN `ww_partners_employment_type` T2 ON `T2`.`employment_type_id` = `ww_recruitment_benefit_package`.`rank_id`
WHERE (
	IF(ww_recruitment_benefit_package.status_id = 1, "Yes", "No") like "%{$search}%" OR 
	ww_recruitment_benefit_package.description like "%{$search}%" OR 
	T2.employment_type like "%{$search}%" OR 
	ww_recruitment_benefit_package.benefit like "%{$search}%"
)';