<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_users_company`.`company_id` as record_id, ww_users_company.company_code as "users_company_company_code", ww_users_company.company as "users_company_company", T3.bank as "users_company_bank_id", ww_users_company.sss as "users_company_sss", ww_users_company.hdmf as "users_company_hdmf", ww_users_company.phic as "users_company_phic", ww_users_company.tin as "users_company_tin", `ww_users_company`.`created_on` as "users_company_created_on", `ww_users_company`.`created_by` as "users_company_created_by", `ww_users_company`.`modified_on` as "users_company_modified_on", `ww_users_company`.`modified_by` as "users_company_modified_by"
FROM (`ww_users_company`)
LEFT JOIN `ww_payroll_bank` T3 ON `T3`.`bank_id` = `ww_users_company`.`bank_id`
WHERE (
	ww_users_company.company_code like "%{$search}%" OR 
	ww_users_company.company like "%{$search}%" OR 
	T3.bank like "%{$search}%" OR 
	ww_users_company.sss like "%{$search}%" OR 
	ww_users_company.hdmf like "%{$search}%" OR 
	ww_users_company.phic like "%{$search}%" OR 
	ww_users_company.tin like "%{$search}%"
)';