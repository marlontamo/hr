<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_partners`.`partner_id` as record_id, ww_users_profile.lastname as "users_profile_lastname", `ww_partners`.`created_on` as "partners_created_on", `ww_partners`.`created_by` as "partners_created_by", `ww_partners`.`modified_on` as "partners_modified_on", `ww_partners`.`modified_by` as "partners_modified_by"
FROM (`ww_partners`)
LEFT JOIN `ww_users_profile` ON `ww_users_profile`.`partner_id` = `ww_partners`.`partner_id`
WHERE (
	ww_users_profile.lastname like "%{$search}%"
)';