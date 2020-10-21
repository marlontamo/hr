<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_system_upload_log`.`log_id` as record_id, `ww_system_upload_log`.`created_on` as "system_upload_log.created_on", `ww_system_upload_log`.`created_by` as "system_upload_log.created_by", `ww_system_upload_log`.`modified_on` as "system_upload_log.modified_on", `ww_system_upload_log`.`modified_by` as "system_upload_log.modified_by"
FROM (`ww_system_upload_log`)
WHERE `ww_system_upload_log`.`log_id` = "{$record_id}"';