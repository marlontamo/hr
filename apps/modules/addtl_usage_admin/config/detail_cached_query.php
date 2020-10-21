<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT `ww_time_forms`.`forms_id` as record_id, `ww_time_forms`.`created_on` as "time_forms_created_on", `ww_time_forms`.`created_by` as "time_forms_created_by", `ww_time_forms`.`modified_on` as "time_forms_modified_on", `ww_time_forms`.`modified_by` as "time_forms_modified_by"
FROM (`ww_time_forms`)
WHERE `ww_time_forms`.`forms_id` = "{$record_id}"';