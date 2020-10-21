<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_time_form_balance_setup_policy`.`policy_id` as record_id, 
										ww_time_form_balance_setup_policy.max_credit as "time_form_balance_setup_policy_max_credit", 
										ww_time_form_balance_setup_policy.starting_credit as "time_form_balance_setup_policy_starting_credit", 
										T2.form as "time_form_balance_setup_policy_form_id", 
										T1.employment_type as "time_form_balance_setup_policy_balance_setup_id", 
										T1.employment_status as "employment_status", 
										T3.company as "company", 
										`ww_time_form_balance_setup_policy`.`created_on` as "time_form_balance_setup_policy_created_on", 
										`ww_time_form_balance_setup_policy`.`created_by` as "time_form_balance_setup_policy_created_by", 
										`ww_time_form_balance_setup_policy`.`modified_on` as "time_form_balance_setup_policy_modified_on", 
										`ww_time_form_balance_setup_policy`.`modified_by` as "time_form_balance_setup_policy_modified_by" 
										FROM (`ww_time_form_balance_setup_policy`) 
										LEFT JOIN `ww_time_form` T2 ON `T2`.`form_id` = `ww_time_form_balance_setup_policy`.`form_id` 
										LEFT JOIN `ww_time_form_balance_setup` T1 ON `T1`.`balance_setup_id` = `ww_time_form_balance_setup_policy`.`balance_setup_id` 
										LEFT JOIN `ww_users_company` T3 ON `T3`.`company_id` = `ww_time_form_balance_setup_policy`.`company_id` 
										WHERE t1.deleted = 0 AND (
												ww_time_form_balance_setup_policy.max_credit like "%{$search}%" OR 
												ww_time_form_balance_setup_policy.starting_credit like "%{$search}%" OR 
												T2.form like "%{$search}%" OR 
												T1.employment_type like "%{$search}%"
											)';