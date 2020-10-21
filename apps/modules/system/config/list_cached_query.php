<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_config`.`config_id` as record_id, `ww_config`.`created_on` as "config_created_on", `ww_config`.`created_by` as "config_created_by", `ww_config`.`modified_on` as "config_modified_on", `ww_config`.`modified_by` as "config_modified_by"
FROM (`ww_config`)';