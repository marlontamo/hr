<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
	user_id as record_id,
	payroll_date as payroll_date,
	date_from as date_from,
	date_to as date_to
FROM (`partner_payslip`) 
WHERE 
(
	full_name like "%{$search}%" OR 
	id_number like "%{$search}%" OR 
	DATE_FORMAT(payroll_date, \'%M %d, %Y\') like "%{$search}%" OR 
	DATE_FORMAT(date_from, \'%M %d, %Y\') like "%{$search}%" OR 
	DATE_FORMAT(date_to, \'%M %d, %Y\') like "%{$search}%" OR 
	company like "%{$search}%"
)
AND transaction_code = "NETPAY" ';