<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_sss_table`.`sss_id` as record_id, ww_payroll_sss_table.from as "payroll_sss_table_from", ww_payroll_sss_table.to as "payroll_sss_table_to", ww_payroll_sss_table.eeshare as "payroll_sss_table_eeshare", ww_payroll_sss_table.ershare as "payroll_sss_table_ershare", ww_payroll_sss_table.ec as "payroll_sss_table_ec", `ww_payroll_sss_table`.`created_on` as "payroll_sss_table_created_on", `ww_payroll_sss_table`.`created_by` as "payroll_sss_table_created_by", `ww_payroll_sss_table`.`modified_on` as "payroll_sss_table_modified_on", `ww_payroll_sss_table`.`modified_by` as "payroll_sss_table_modified_by"
FROM (`ww_payroll_sss_table`)
WHERE (
	ww_payroll_sss_table.from like "%{$search}%" OR 
	ww_payroll_sss_table.to like "%{$search}%" OR 
	ww_payroll_sss_table.eeshare like "%{$search}%" OR 
	ww_payroll_sss_table.ershare like "%{$search}%" OR 
	ww_payroll_sss_table.ec like "%{$search}%"
)';