<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_profiles`.`profile_id` as record_id, 
ww_profiles.description as "profiles_description", 
ww_profiles.profile as "profiles_profile", 
ww_profiles.can_delete as "can_delete",
`ww_profiles`.`created_on` as "profiles_created_on", 
`ww_profiles`.`created_by` as "profiles_created_by", 
`ww_profiles`.`modified_on` as "profiles_modified_on", 
`ww_profiles`.`modified_by` as "profiles_modified_by"
FROM (`ww_profiles`)
WHERE (
	ww_profiles.description like "%{$search}%" OR 
	ww_profiles.profile like "%{$search}%"
)';