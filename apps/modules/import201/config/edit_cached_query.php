<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_users`.`user_id` as record_id, `ww_users`.`created_on` as "users.created_on", `ww_users`.`created_by` as "users.created_by", `ww_users`.`modified_on` as "users.modified_on", `ww_users`.`modified_by` as "users.modified_by"
FROM (`ww_users`)
WHERE `ww_users`.`user_id` = "{$record_id}"';