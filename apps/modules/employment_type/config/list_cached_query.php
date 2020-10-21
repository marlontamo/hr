<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_partners_employment_type`.`employment_type_id` as record_id, 
ww_partners_employment_type.employment_type as "partners_employment_type_employment_type",
IF(ww_partners_employment_type.active = 1, "Active", "Inactive") as "partners_employment_type_status_id", 
ww_partners_employment_type.can_delete as "can_delete",
`ww_partners_employment_type`.`created_on` as "partners_employment_type_created_on", 
`ww_partners_employment_type`.`created_by` as "partners_employment_type_created_by", 
`ww_partners_employment_type`.`modified_on` as "partners_employment_type_modified_on", 
`ww_partners_employment_type`.`modified_by` as "partners_employment_type_modified_by"
FROM (`ww_partners_employment_type`)
WHERE (
	ww_partners_employment_type.employment_type like "%{$search}%"
)';