<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_time_record`.`record_id` as record_id, `ww_time_record`.`created_on` as "time_record.created_on", `ww_time_record`.`created_by` as "time_record.created_by", `ww_time_record`.`modified_on` as "time_record.modified_on", `ww_time_record`.`modified_by` as "time_record.modified_by"
FROM (`ww_time_record`)
WHERE `ww_time_record`.`record_id` = "{$record_id}"';