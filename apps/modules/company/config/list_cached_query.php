<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
	`ww_users_company`.`company_id` as record_id, 
	ww_users_company.logo as "users_company_logo",
	ww_users_company.vat as "users_company_vat", 
	ww_users_company.zipcode as "users_company_zipcode", 
	ww_users_company.country as "users_company_country_id", 
	ww_users_company.city as "users_company_city_id", 
	ww_users_company.address as "users_company_address", 
	ww_users_company.company_code as "users_company_company_code", 
	ww_users_company.company as "users_company_company", 

	ww_users_company.sss as "users_company_sss", 
	ww_users_company.hdmf as "users_company_hdmf", 
	ww_users_company.phic as "users_company_phic", 
	ww_users_company.rdo as "users_company_rdo",
	ww_users_company.can_delete as "can_delete", 

	`ww_users_company`.`created_on` as "users_company_created_on", 
	`ww_users_company`.`created_by` as "users_company_created_by", 
	`ww_users_company`.`modified_on` as "users_company_modified_on", 
	`ww_users_company`.`modified_by` as "users_company_modified_by"
FROM (`ww_users_company`)
WHERE (
ww_users_company.logo like "%{$search}%" OR 
ww_users_company.vat like "%{$search}%" OR 
ww_users_company.zipcode like "%{$search}%" OR 
ww_users_company.country like "%{$search}%" OR 
ww_users_company.city like "%{$search}%" OR 
ww_users_company.address like "%{$search}%" OR 
ww_users_company.company_code like "%{$search}%" OR 
ww_users_company.company like "%{$search}%" OR
ww_users_company.sss like "%{$search}%" OR 
ww_users_company.hdmf like "%{$search}%" OR 
ww_users_company.phic like "%{$search}%" OR 
ww_users_company.rdo like "%{$search}%"
)';