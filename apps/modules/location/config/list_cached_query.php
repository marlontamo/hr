<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_users_location`.`location_id` as record_id, 
ww_users_location.ecola_amt_month as "users_location_ecola_amt_month", 
ww_users_location.ecola_amt as "users_location_ecola_amt", 
ww_users_location.min_wage_amt as "users_location_min_wage_amt", 
IF(ww_users_location.status_id = 1, "Active", "Inactive") as "users_location_status_id", 
ww_users_location.can_delete as "can_delete",
ww_users_location.location_code as "users_location_location_code", 
ww_users_location.location as "users_location_location", 
`ww_users_location`.`created_on` as "users_location_created_on", 
`ww_users_location`.`created_by` as "users_location_created_by", 
`ww_users_location`.`modified_on` as "users_location_modified_on", 
`ww_users_location`.`modified_by` as "users_location_modified_by"
FROM (`ww_users_location`)
WHERE (
	ww_users_location.ecola_amt_month like "%{$search}%" OR 
	ww_users_location.ecola_amt like "%{$search}%" OR 
	ww_users_location.min_wage_amt like "%{$search}%" OR 
	IF(ww_users_location.status_id = 1, "Active", "Inactive") like "%{$search}%" OR 
	ww_users_location.location_code like "%{$search}%" OR 
	ww_users_location.location like "%{$search}%"
)';