<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_resources_policies`.`resource_policy_id` as record_id, ww_resources_policies.attachments as "resources_policies_attachments", ww_resources_policies.description as "resources_policies_description", T3.category as "resources_policies_category", ww_resources_policies.title as "resources_policies_title", `ww_resources_policies`.`created_on` as "resources_policies_created_on", `ww_resources_policies`.`created_by` as "resources_policies_created_by", `ww_resources_policies`.`modified_on` as "resources_policies_modified_on", `ww_resources_policies`.`modified_by` as "resources_policies_modified_by"
, T5.full_name AS createdbyname, T5.login AS login
FROM (`ww_resources_policies`)
LEFT JOIN `ww_resources_category` T3 ON `T3`.`category` = `ww_resources_policies`.`category`
LEFT JOIN `ww_users` T5 ON `T5`.`user_id` = `ww_resources_policies`.`created_by`
WHERE (
	ww_resources_policies.attachments like "%{$search}%" OR 
	ww_resources_policies.description like "%{$search}%" OR 
	T3.category like "%{$search}%" OR 
	ww_resources_policies.title like "%{$search}%"
)';