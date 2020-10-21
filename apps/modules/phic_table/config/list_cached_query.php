<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_payroll_phic_table`.`phic_id` as record_id, ww_payroll_phic_table.from as "payroll_phic_table_from", ww_payroll_phic_table.to as "payroll_phic_table_to", ww_payroll_phic_table.eeshare as "payroll_phic_table_eeshare", ww_payroll_phic_table.ershare as "payroll_phic_table_ershare", `ww_payroll_phic_table`.`created_on` as "payroll_phic_table_created_on", `ww_payroll_phic_table`.`created_by` as "payroll_phic_table_created_by", `ww_payroll_phic_table`.`modified_on` as "payroll_phic_table_modified_on", `ww_payroll_phic_table`.`modified_by` as "payroll_phic_table_modified_by"
FROM (`ww_payroll_phic_table`)
WHERE (
	ww_payroll_phic_table.from like "%{$search}%" OR 
	ww_payroll_phic_table.to like "%{$search}%" OR 
	ww_payroll_phic_table.eeshare like "%{$search}%" OR 
	ww_payroll_phic_table.ershare like "%{$search}%"
)';