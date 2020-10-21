<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_resources_request`.`request_id` as record_id, T5.full_name as "resources_request_user_id", ww_resources_request_upload.upload_id as "resources_request_upload_upload_id", ww_resources_request.reason as "resources_request_reason", DATE_FORMAT(ww_resources_request.date_needed, \'%M %d, %Y\') as "resources_request_date_needed", ww_resources_request.request as "resources_request_request", `ww_resources_request`.`created_on` as "resources_request_created_on", `ww_resources_request`.`created_by` as "resources_request_created_by", `ww_resources_request`.`modified_on` as "resources_request_modified_on", `ww_resources_request`.`modified_by` as "resources_request_modified_by"
,`ww_resources_request`.`request_status_id` as request_status_id, `ww_resources_request`.`status` as status, rstat.request_status
,(SELECT COUNT(*) FROM ww_resources_request_notes req_notes
WHERE req_notes.request_id = ww_resources_request.request_id AND req_notes.user_id != created_by) AS discussion_count 
, appr.user_id AS approver_id
FROM (`ww_resources_request`)
INNER JOIN ww_resources_request_approver appr ON ww_resources_request.`request_id` = appr.request_id
LEFT JOIN `ww_resources_request_upload` ON `ww_resources_request_upload`.`request_id` = `ww_resources_request`.`request_id`
LEFT JOIN `ww_users` T5 ON `T5`.`user_id` = `ww_resources_request`.`user_id`
LEFT JOIN `ww_resources_request_status` rstat ON `ww_resources_request`.`request_status_id` = `rstat`.`request_status_id`
WHERE (
	T5.full_name like "%{$search}%" OR 
	ww_resources_request_upload.upload_id like "%{$search}%" OR 
	ww_resources_request.reason like "%{$search}%" OR 
	DATE_FORMAT(ww_resources_request.date_needed, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_resources_request.request like "%{$search}%"
)';