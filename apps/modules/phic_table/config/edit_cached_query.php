<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_payroll_phic_table`.`phic_id` as record_id, `ww_payroll_phic_table`.`created_on` as "payroll_phic_table.created_on", `ww_payroll_phic_table`.`created_by` as "payroll_phic_table.created_by", `ww_payroll_phic_table`.`modified_on` as "payroll_phic_table.modified_on", `ww_payroll_phic_table`.`modified_by` as "payroll_phic_table.modified_by", ww_payroll_phic_table.from as "payroll_phic_table.from", ww_payroll_phic_table.to as "payroll_phic_table.to", ww_payroll_phic_table.eeshare as "payroll_phic_table.eeshare", ww_payroll_phic_table.ershare as "payroll_phic_table.ershare"
FROM (`ww_payroll_phic_table`)
WHERE `ww_payroll_phic_table`.`phic_id` = "{$record_id}"';