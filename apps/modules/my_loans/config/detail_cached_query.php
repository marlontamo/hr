<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT ww_payroll_partners_loan.*, ww_payroll_loan_status.loan_status, 
ww_payroll_partners_loan.partner_loan_id as record_id,
ROUND(AES_DECRYPT(`ww_payroll_partners_loan`.`loan_principal`,`encryption_key`()),2) as lprincipal, 
ROUND(AES_DECRYPT(`ww_payroll_partners_loan`.`interest`,`encryption_key`()),2) as linterest, 
ROUND(AES_DECRYPT(`ww_payroll_partners_loan`.`amount`,`encryption_key`()),2) as lamount , 
ROUND(AES_DECRYPT(`ww_payroll_partners_loan`.`total_amount_paid`,`encryption_key`()),2) as lamount_paid
FROM ww_payroll_partners_loan 
LEFT JOIN ww_payroll_loan_status 
ON ww_payroll_partners_loan.loan_status_id = ww_payroll_loan_status.loan_status_id
WHERE 
 `ww_payroll_partners_loan`.`partner_loan_id` = "{$record_id}"
 AND `ww_payroll_partners_loan`.`deleted` = 0';