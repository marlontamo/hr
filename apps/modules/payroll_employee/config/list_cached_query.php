<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
	`ww_payroll_partners`.`user_id` as record_id, 
	T9.full_name as "payroll_partners_user_id", 
	T6.company as "payroll_partners_company", 
	ww_payroll_partners.total_year_days as "payroll_partners_total_year_days", 
	T2.payroll_rate_type as "payroll_partners_payroll_rate_type_id", 
	T3.payroll_schedule as "payroll_partners_payroll_schedule_id", 
	ww_payroll_partners.salary as "payroll_partners_salary", 
	T5.taxcode as "payroll_partners_taxcode_id", 
	ww_payroll_partners.minimum_takehome as "payroll_partners_minimum_takehome",
	ww_payroll_partners.bank_account as "payroll_partners_bank_account", 
	T4.payment_type as "payroll_partners_payment_type_id", 
	ww_payroll_partners.fixed_rate as "payroll_partners_fixed_rate",
	T8.sensitivity as "payroll_partners_sensitivity", 
	ww_payroll_partners.sss_no as "payroll_partners_sss_no", 
	T10.payroll_transaction_mode as "payroll_partners_sss_mode", 
	ww_payroll_partners.sss_amount as "payroll_partners_sss_amount", 
	ww_payroll_partners.sss_week as "payroll_partners_sss_week", 
	ww_payroll_partners.hdmf_no as "payroll_partners_hdmf_no", 
	T14.payroll_transaction_mode as "payroll_partners_hdmf_mode", 
	ww_payroll_partners.hdmf_amount as "payroll_partners_hdmf_amount", 
	ww_payroll_partners.hdmf_week as "payroll_partners_hdmf_week", 
	ww_payroll_partners.phic_no as "payroll_partners_phic_no",
	T18.payroll_transaction_mode as "payroll_partners_phic_mode", 
	ww_payroll_partners.phic_amount as "payroll_partners_phic_amount", 
	ww_payroll_partners.phic_week as "payroll_partners_phic_week", 
	ww_payroll_partners.tin as "payroll_partners_tin", 
	T21.payroll_transaction_mode as "payroll_partners_tax_mode", 
	ww_payroll_partners.tax_amount as "payroll_partners_tax_amount", 
	ww_payroll_partners.tax_week as "payroll_partners_tax_week", 
	ww_payroll_partners.ecola_week as "payroll_partners_ecola_week", 
	`ww_payroll_partners`.`created_on` as "payroll_partners_created_on", 
	`ww_payroll_partners`.`created_by` as "payroll_partners_created_by", 
	`ww_payroll_partners`.`modified_on` as "payroll_partners_modified_on", 
	`ww_payroll_partners`.`modified_by` as "payroll_partners_modified_by",
	DATE_FORMAT(`ww_partners`.`resigned_date`, \'%M %d, %Y\') as "partners.resigned_date",
	ww_payroll_partners.attendance_base as "payroll_partners_attendance_base",
	ww_payroll_partners.whole_half as "payroll_partners_whole_half",
	ww_payroll_partners.payout_schedule as "payroll_partners_payout_schedule",
	ww_payroll_partners.on_hold as "payroll_partners_on_hold",
	ww_payroll_partners.location_id as "location_id",
	ww_payroll_partners.non_swipe as "payroll_partners_non_swipe"
FROM (`ww_payroll_partners`)
INNER JOIN `ww_users` T9 ON `T9`.`user_id` = `ww_payroll_partners`.`user_id`
INNER JOIN `ww_partners` ON `ww_partners`.`user_id` = `ww_payroll_partners`.`user_id`
INNER JOIN `ww_users_profile` ON `ww_partners`.`user_id` = `ww_users_profile`.`user_id`
LEFT JOIN `ww_payroll_rate_type` T2 ON `T2`.`payroll_rate_type_id` = `ww_payroll_partners`.`payroll_rate_type_id`
LEFT JOIN `ww_payroll_schedule` T3 ON `T3`.`payroll_schedule_id` = `ww_payroll_partners`.`payroll_schedule_id`
LEFT JOIN `ww_payroll_payment_type` T4 ON `T4`.`payment_type_id` = `ww_payroll_partners`.`payment_type_id`
LEFT JOIN `ww_taxcode` T5 ON `T5`.`taxcode_id` = `ww_payroll_partners`.`taxcode_id`
LEFT JOIN `ww_users_company` T6 ON `T6`.`company_id` = `ww_payroll_partners`.`company_id`
LEFT JOIN `ww_sensitivity` T8 ON `T8`.`sensitivity_id` = `ww_payroll_partners`.`sensitivity`
LEFT JOIN `ww_payroll_transaction_mode` T10 ON `T10`.`payroll_transaction_mode_id` = `ww_payroll_partners`.`sss_mode`
LEFT JOIN `ww_payroll_transaction_mode` T14 ON `T14`.`payroll_transaction_mode_id` = `ww_payroll_partners`.`hdmf_mode`
LEFT JOIN `ww_payroll_transaction_mode` T18 ON `T18`.`payroll_transaction_mode_id` = `ww_payroll_partners`.`phic_mode`
LEFT JOIN `ww_payroll_transaction_mode_tax` T21 ON `T21`.`payroll_transaction_mode_id` = `ww_payroll_partners`.`tax_mode`
WHERE (
	T9.full_name like "%{$search}%" OR 
	ww_payroll_partners.total_year_days like "%{$search}%" OR
	T2.payroll_rate_type like "%{$search}%" OR 
	T3.payroll_schedule like "%{$search}%" OR 
	ww_payroll_partners.salary like "%{$search}%" OR 
	T5.taxcode like "%{$search}%" OR 
	ww_payroll_partners.minimum_takehome like "%{$search}%" OR 
	ww_payroll_partners.bank_account like "%{$search}%" OR 
	T4.payment_type like "%{$search}%" OR 
	ww_payroll_partners.fixed_rate like "%{$search}%" OR 
	T8.sensitivity like "%{$search}%" OR 
	ww_payroll_partners.sss_no like "%{$search}%" OR 
	T10.payroll_transaction_mode like "%{$search}%" OR 
	ww_payroll_partners.sss_amount like "%{$search}%" OR 
	ww_payroll_partners.sss_week like "%{$search}%" OR 
	ww_payroll_partners.hdmf_no like "%{$search}%" OR 
	T14.payroll_transaction_mode like "%{$search}%" OR 
	ww_payroll_partners.hdmf_amount like "%{$search}%" OR 
	ww_payroll_partners.hdmf_week like "%{$search}%" OR 
	ww_payroll_partners.phic_no like "%{$search}%" OR 
	T18.payroll_transaction_mode like "%{$search}%" OR 
	ww_payroll_partners.phic_amount like "%{$search}%" OR 
	ww_payroll_partners.phic_week like "%{$search}%" OR 
	ww_payroll_partners.tin like "%{$search}%" OR 
	T21.payroll_transaction_mode like "%{$search}%" OR 
	ww_payroll_partners.tax_week like "%{$search}%" OR 
	ww_payroll_partners.ecola_week like "%{$search}%"
) AND T9.deleted = 0';