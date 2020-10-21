<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT `ww_payroll_period`.`payroll_period_id` as record_id, `ww_payroll_period`.`created_on` as "payroll_period_created_on", `ww_payroll_period`.`created_by` as "payroll_period_created_by", `ww_payroll_period`.`modified_on` as "payroll_period_modified_on", `ww_payroll_period`.`modified_by` as "payroll_period_modified_by"
FROM (`ww_payroll_period`)
WHERE `ww_payroll_period`.`payroll_period_id` = "{$record_id}"';