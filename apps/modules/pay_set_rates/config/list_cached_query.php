<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_users_pay_set_rates`.`pay_set_rates_id` as record_id, 
ww_users_pay_set_rates.pay_set_rates as "users_pay_set_rates_pay_set_rates", 
ww_users_pay_set_rates.pay_set_rates_code as "users_pay_set_rates_pay_set_rates_code", 
IF(ww_users_pay_set_rates.status_id = 1, "Active", "Inactive") as "users_pay_set_rates_status_id", 
ww_users_pay_set_rates.can_delete as "can_delete",
`ww_users_pay_set_rates`.`created_on` as "users_pay_set_rates_created_on", 
`ww_users_pay_set_rates`.`created_by` as "users_pay_set_rates_created_by", 
`ww_users_pay_set_rates`.`modified_on` as "users_pay_set_rates_modified_on", 
`ww_users_pay_set_rates`.`modified_by` as "users_pay_set_rates_modified_by"
FROM (`ww_users_pay_set_rates`)
WHERE (
	ww_users_pay_set_rates.pay_set_rates like "%{$search}%" OR 
	ww_users_pay_set_rates.pay_set_rates_code like "%{$search}%" OR 
	IF(ww_users_pay_set_rates.status_id = 1, "Active", "Inactive") like "%{$search}%"
)';