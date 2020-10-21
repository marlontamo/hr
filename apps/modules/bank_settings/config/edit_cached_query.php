<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_payroll_bank`.`bank_id` as record_id, `ww_payroll_bank`.`created_on` as "payroll_bank.created_on", `ww_payroll_bank`.`created_by` as "payroll_bank.created_by", `ww_payroll_bank`.`modified_on` as "payroll_bank.modified_on", `ww_payroll_bank`.`modified_by` as "payroll_bank.modified_by", ww_payroll_bank.description as "payroll_bank.description", ww_payroll_bank.address as "payroll_bank.address", ww_payroll_bank.signatory_2 as "payroll_bank.signatory_2", ww_payroll_bank.signatory_1 as "payroll_bank.signatory_1", ww_payroll_bank.branch_position as "payroll_bank.branch_position", ww_payroll_bank.branch_officer as "payroll_bank.branch_officer", ww_payroll_bank.branch_code as "payroll_bank.branch_code", ww_payroll_bank.ceiling_amount as "payroll_bank.ceiling_amount", ww_payroll_bank.batch_no as "payroll_bank.batch_no", ww_payroll_bank.account_no as "payroll_bank.account_no", ww_payroll_bank.bank as "payroll_bank.bank", ww_payroll_bank.account_name as "payroll_bank.account_name", ww_payroll_bank.bank_code_alpha as "payroll_bank.bank_code_alpha", ww_payroll_bank.bank_code_numeric as "payroll_bank.bank_code_numeric", ww_payroll_bank.bank_type as "payroll_bank.bank_type"
FROM (`ww_payroll_bank`)
WHERE `ww_payroll_bank`.`bank_id` = "{$record_id}"';