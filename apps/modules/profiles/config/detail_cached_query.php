<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT `ww_profiles`.`profile_id` as record_id, 
`ww_profiles`.`created_on` as "profiles.created_on", 
`ww_profiles`.`created_by` as "profiles.created_by", 
`ww_profiles`.`modified_on` as "profiles.modified_on", 
`ww_profiles`.`modified_by` as "profiles.modified_by", 
ww_profiles.description as "profiles.description", 
ww_profiles.profile as "profiles.profile"
FROM (`ww_profiles`)
WHERE `ww_profiles`.`profile_id` = "{$record_id}"';