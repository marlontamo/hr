<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_time_shift_class_company`.`id` as record_id, `ww_time_shift_class_company`.`created_on` as "time_shift_class_company.created_on", `ww_time_shift_class_company`.`created_by` as "time_shift_class_company.created_by", `ww_time_shift_class_company`.`modified_on` as "time_shift_class_company.modified_on", `ww_time_shift_class_company`.`modified_by` as "time_shift_class_company.modified_by"
FROM (`ww_time_shift_class_company`)
WHERE `ww_time_shift_class_company`.`id` = "{$record_id}"';