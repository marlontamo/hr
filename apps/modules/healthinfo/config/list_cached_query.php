<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_health`.`health_id` as record_id, `ww_health`.`created_on` as "health_created_on", `ww_health`.`created_by` as "health_created_by", `ww_health`.`modified_on` as "health_modified_on", `ww_health`.`modified_by` as "health_modified_by"
FROM (`ww_health`)';