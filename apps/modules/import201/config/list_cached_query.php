<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_users`.`user_id` as record_id, `ww_users`.`created_on` as "users_created_on", `ww_users`.`created_by` as "users_created_by", `ww_users`.`modified_on` as "users_modified_on", `ww_users`.`modified_by` as "users_modified_by"
FROM (`ww_users`)';