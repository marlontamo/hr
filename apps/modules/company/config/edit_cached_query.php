<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT 
	`ww_users_company`.`company_id` as record_id, 
	`ww_users_company`.`created_on` as "users_company.created_on", 
	`ww_users_company`.`created_by` as "users_company.created_by", 
	`ww_users_company`.`modified_on` as "users_company.modified_on", 
	`ww_users_company`.`modified_by` as "users_company.modified_by", 
	`ww_users_company`.`logo` as "users_company.logo",
	`ww_users_company`.`print_logo` as "users_company.print_logo", 
	`ww_users_company`.`vat` as "users_company.vat", 
	`ww_users_company`.`zipcode` as "users_company.zipcode", 
	`ww_users_company`.`country_id` as "users_company.country_id",
	`ww_users_company`.`city_id` as "users_company.city_id", 
	`ww_users_company`.`address` as "users_company.address", 
	`ww_users_company`.`company_code` as "users_company.company_code", 
	`ww_users_company`.`company` as "users_company.company",
	ww_users_company.sss as "users_company.sss", 
	ww_users_company.sss_branch_code as "users_company.sss_branch_code",
	ww_users_company.sss_branch_code_locator as "users_company.sss_branch_code_locator",
	ww_users_company.hdmf as "users_company.hdmf", 
	ww_users_company.hdmf_branch_code as "users_company.hdmf_branch_code", 
	ww_users_company.phic as "users_company.phic", 
	ww_users_company.rdo as "users_company.rdo"

FROM (`ww_users_company`)
WHERE `ww_users_company`.`company_id` = "{$record_id}"';