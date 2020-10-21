<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query_custom"] = 'SELECT `ww_payroll_partners_loan`.`partner_loan_id` as record_id, 
ww_payroll_partners_loan.user_id as "payroll_partners_loan_user_id", 
T2.loan as "payroll_partners_loan_loan_id", 
T3.loan_status as "payroll_partners_loan_loan_status_id",
T18.full_name, T19.id_number, 
DATE_FORMAT(ww_payroll_partners_loan.entry_date, \'%M %d, %Y\') as "payroll_partners_loan_entry_date", 
ww_payroll_partners_loan.no_payments as "payroll_partners_loan_no_payments", 
T6.account_name as "payroll_partners_loan_releasing_debit_account_id", 
T7.account_name as "payroll_partners_loan_releasing_credit_account_id", 
ww_payroll_partners_loan.week as "payroll_partners_loan_week", 
AES_DECRYPT(ww_payroll_partners_loan.loan_principal, encryption_key()) as "payroll_partners_loan_loan_principal", 
AES_DECRYPT(ww_payroll_partners_loan.amount, encryption_key()) as "payroll_partners_loan_amount", 
AES_DECRYPT(ww_payroll_partners_loan.interest, encryption_key()) as "payroll_partners_loan_interest", 
AES_DECRYPT(ww_payroll_partners_loan.beginning_balance, encryption_key()) as "payroll_partners_loan_beginning_balance", 
ww_payroll_partners_loan.description as "payroll_partners_loan_description", 
DATE_FORMAT(ww_payroll_partners_loan.start_date, \'%M %d, %Y\') as "payroll_partners_loan_start_date", 
T14.payment_mode as "payroll_partners_loan_payment_mode_id", 
ww_payroll_partners_loan.no_payments_remaining as "payroll_partners_loan_no_payments_remaining", 
T16.account_name as "payroll_partners_loan_amortization_credit_account_id", 
T17.account_name as "payroll_partners_loan_interest_credit_account_id", 
AES_DECRYPT(ww_payroll_partners_loan.running_balance, encryption_key()) as "payroll_partners_loan_running_balance", 
AES_DECRYPT(ww_payroll_partners_loan.system_amortization, encryption_key()) as "payroll_partners_loan_system_amortization", 
AES_DECRYPT(ww_payroll_partners_loan.system_interest, encryption_key()) as "payroll_partners_loan_system_interest", 
AES_DECRYPT(ww_payroll_partners_loan.user_amortization, encryption_key()) as "payroll_partners_loan_user_amortization", 
AES_DECRYPT(ww_payroll_partners_loan.user_interest, encryption_key()) as "payroll_partners_loan_user_interest", 
DATE_FORMAT(ww_payroll_partners_loan.last_payment_date, \'%M %d, %Y\') as "payroll_partners_loan_last_payment_date", 
AES_DECRYPT(ww_payroll_partners_loan.total_amount_paid, encryption_key()) as "payroll_partners_loan_total_amount_paid", 
ww_payroll_partners_loan.no_payments_paid as "payroll_partners_loan_no_payments_paid", 
AES_DECRYPT(ww_payroll_partners_loan.total_arrears, encryption_key()) as "payroll_partners_loan_total_arrears", 
`ww_payroll_partners_loan`.`created_on` as "payroll_partners_loan_created_on", 
`ww_payroll_partners_loan`.`created_by` as "payroll_partners_loan_created_by", 
`ww_payroll_partners_loan`.`modified_on` as "payroll_partners_loan_modified_on", 
`ww_payroll_partners_loan`.`modified_by` as "payroll_partners_loan_modified_by"
FROM (`ww_payroll_partners_loan`)
LEFT JOIN `ww_payroll_loan` T2 ON `T2`.`loan_id` = `ww_payroll_partners_loan`.`loan_id`
LEFT JOIN `ww_payroll_loan_status` T3 ON `T3`.`loan_status_id` = `ww_payroll_partners_loan`.`loan_status_id`
LEFT JOIN `ww_payroll_account` T6 ON `T6`.`account_id` = `ww_payroll_partners_loan`.`releasing_debit_account_id`
LEFT JOIN `ww_payroll_account` T7 ON `T7`.`account_id` = `ww_payroll_partners_loan`.`releasing_credit_account_id`
LEFT JOIN `ww_payroll_payment_mode` T14 ON `T14`.`payment_mode_id` = `ww_payroll_partners_loan`.`payment_mode_id`
LEFT JOIN `ww_payroll_account` T16 ON `T16`.`account_id` = `ww_payroll_partners_loan`.`amortization_credit_account_id`
LEFT JOIN `ww_payroll_account` T17 ON `T17`.`account_id` = `ww_payroll_partners_loan`.`interest_credit_account_id`
LEFT JOIN `ww_users` T18 ON `T18`.`user_id` = `ww_payroll_partners_loan`.`user_id`
LEFT JOIN `ww_partners` T19 ON `T19`.`user_id` = `T18`.`user_id`
LEFT JOIN `ww_payroll_partners` T20 ON `T20`.`user_id` = `T18`.`user_id`
WHERE (
	ww_payroll_partners_loan.user_id like "%{$search}%" OR 
	T2.loan like "%{$search}%" OR 
	T3.loan_status like "%{$search}%" OR 
	DATE_FORMAT(ww_payroll_partners_loan.entry_date, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_payroll_partners_loan.no_payments like "%{$search}%" OR 
	T6.account_name like "%{$search}%" OR 
	T7.account_name like "%{$search}%" OR 
	ww_payroll_partners_loan.week like "%{$search}%" OR 
	ww_payroll_partners_loan.loan_principal like "%{$search}%" OR 
	ww_payroll_partners_loan.amount like "%{$search}%" OR 
	ww_payroll_partners_loan.interest like "%{$search}%" OR 
	ww_payroll_partners_loan.beginning_balance like "%{$search}%" OR 
	ww_payroll_partners_loan.description like "%{$search}%" OR 
	DATE_FORMAT(ww_payroll_partners_loan.start_date, \'%M %d, %Y\') like "%{$search}%" OR 
	T14.payment_mode like "%{$search}%" OR 
	ww_payroll_partners_loan.no_payments_remaining like "%{$search}%" OR 
	T16.account_name like "%{$search}%" OR 
	T17.account_name like "%{$search}%" OR 
	ww_payroll_partners_loan.running_balance like "%{$search}%" OR 
	ww_payroll_partners_loan.system_amortization like "%{$search}%" OR 
	ww_payroll_partners_loan.system_interest like "%{$search}%" OR 
	ww_payroll_partners_loan.user_amortization like "%{$search}%" OR 
	ww_payroll_partners_loan.user_interest like "%{$search}%" OR 
	DATE_FORMAT(ww_payroll_partners_loan.last_payment_date, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_payroll_partners_loan.total_amount_paid like "%{$search}%" OR 
	ww_payroll_partners_loan.no_payments_paid like "%{$search}%" OR 
	ww_payroll_partners_loan.total_arrears like "%{$search}%" OR
	T18.full_name like "%{$search}%"
)';