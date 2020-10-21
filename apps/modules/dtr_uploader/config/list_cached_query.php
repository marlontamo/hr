<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_system_upload_log`.`log_id` as record_id,
		`ww_system_upload_template`.`template_name` AS template_name, 
		CONCAT(`ww_users`.`full_name`) AS uploaded_by, 
		`ww_system_upload_log`.`file_path` AS file_path,
		`ww_system_upload_log`.`rows` AS rows,
		`ww_system_upload_log`.`valid_count` AS valid_rec
FROM (`ww_system_upload_log`)
LEFT JOIN (`ww_users`) ON `ww_system_upload_log`.`created_by` = `ww_users`.`user_id`
LEFT JOIN (`ww_system_upload_template`) ON `ww_system_upload_log`.`template_id` = `ww_system_upload_template`.`template_id`
WHERE `ww_system_upload_template`.`module_id` = 46';