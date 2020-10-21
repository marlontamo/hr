<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT `ww_roles`.`role_id` as record_id, `ww_roles`.`created_on` as "roles.created_on", `ww_roles`.`created_by` as "roles.created_by", `ww_roles`.`modified_on` as "roles.modified_on", `ww_roles`.`modified_by` as "roles.modified_by", ww_roles.profile_id as "roles.profile_id", ww_roles.description as "roles.description", ww_roles.role as "roles.role"
FROM (`ww_roles`)
WHERE `ww_roles`.`role_id` = "{$record_id}"';