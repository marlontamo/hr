<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT `ww_users_group`.`group_id` as record_id, `ww_users_group`.`created_on` as "users_group.created_on", `ww_users_group`.`created_by` as "users_group.created_by", `ww_users_group`.`modified_on` as "users_group.modified_on", `ww_users_group`.`modified_by` as "users_group.modified_by", ww_users_group.group as "users_group.group", ww_users_group.group_code as "users_group.group_code", ww_users_group.immediate_id as "users_group.immediate_id", ww_users_group.position as "users_group.position", ww_users_group.status_id as "users_group.status_id"
FROM (`ww_users_group`)
WHERE `ww_users_group`.`group_id` = "{$record_id}"';