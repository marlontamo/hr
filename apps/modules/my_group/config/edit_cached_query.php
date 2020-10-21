<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_groups`.`group_id` as record_id, `ww_groups`.`created_on` as "groups.created_on", `ww_groups`.`created_by` as "groups.created_by", `ww_groups`.`modified_on` as "groups.modified_on", `ww_groups`.`modified_by` as "groups.modified_by", ww_groups.group_name as "groups.group_name", ww_groups.description as "groups.description"
FROM (`ww_groups`)
WHERE `ww_groups`.`group_id` = "{$record_id}"';