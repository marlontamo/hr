<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_resources_downloadable`.`resource_download_id` as record_id, ww_resources_downloadable.attachments as "resources_downloadable_attachments", ww_resources_downloadable.description as "resources_downloadable_description", T3.category as "resources_downloadable_category", ww_resources_downloadable.title as "resources_downloadable_title", `ww_resources_downloadable`.`created_on` as "resources_downloadable_created_on", `ww_resources_downloadable`.`created_by` as "resources_downloadable_created_by", `ww_resources_downloadable`.`modified_on` as "resources_downloadable_modified_on", `ww_resources_downloadable`.`modified_by` as "resources_downloadable_modified_by"
, T5.full_name AS createdbyname, T5.login AS login
FROM (`ww_resources_downloadable`)
LEFT JOIN `ww_resources_category` T3 ON `T3`.`category` = `ww_resources_downloadable`.`category`
LEFT JOIN `ww_users` T5 ON `T5`.`user_id` = `ww_resources_downloadable`.`created_by`
WHERE (
	ww_resources_downloadable.attachments like "%{$search}%" OR 
	ww_resources_downloadable.description like "%{$search}%" OR 
	T3.category like "%{$search}%" OR 
	ww_resources_downloadable.title like "%{$search}%"
)';