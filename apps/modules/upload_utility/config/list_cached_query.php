<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_system_upload_log`.`log_id` as record_id,
`ww_system_upload_log`.`file_path` as "system_upload_log_file_path",
`ww_system_upload_log`.`filesize` as "system_upload_log_filesize",
`ww_system_upload_log`.`rows` as "system_upload_log_rows",
`ww_system_upload_log`.`valid_count` as "system_upload_log_valid_count",
`ww_system_upload_log`.`error_count` as "system_upload_log_error_count",
`ww_system_upload_log`.`created_on` as "system_upload_log_created_on", 
`ww_system_upload_log`.`created_by` as "system_upload_log_created_by", 
`ww_system_upload_log`.`modified_on` as "system_upload_log_modified_on", 
`ww_system_upload_log`.`modified_by` as "system_upload_log_modified_by"
FROM (`ww_system_upload_log`)
WHERE (
	ww_system_upload_log.file_path like "%{$search}%"
)';