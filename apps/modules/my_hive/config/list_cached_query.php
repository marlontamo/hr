<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_hive`.`hive_id` as record_id, `ww_hive`.`created_on` as "hive_created_on", `ww_hive`.`created_by` as "hive_created_by", `ww_hive`.`modified_on` as "hive_modified_on", `ww_hive`.`modified_by` as "hive_modified_by"
FROM (`ww_hive`)';