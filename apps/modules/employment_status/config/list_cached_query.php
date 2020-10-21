<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_partners_employment_status`.`employment_status_id` as record_id, 
ww_partners_employment_status.employment_status as "partners_employment_status_employment_status", 
IF(ww_partners_employment_status.active = 1, "Active", "Inactive") as "partners_employment_status_active", 
ww_partners_employment_status.can_delete as "can_delete",
`ww_partners_employment_status`.`created_on` as "partners_employment_status_created_on", 
`ww_partners_employment_status`.`created_by` as "partners_employment_status_created_by", 
`ww_partners_employment_status`.`modified_on` as "partners_employment_status_modified_on", 
`ww_partners_employment_status`.`modified_by` as "partners_employment_status_modified_by"
FROM (`ww_partners_employment_status`)
WHERE (
	ww_partners_employment_status.employment_status like "%{$search}%" OR 
	IF(ww_partners_employment_status.active = 1, "Active", "Inactive") like "%{$search}%"
)';