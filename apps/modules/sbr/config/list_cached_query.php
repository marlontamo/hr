<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT CONCAT( YEAR(`ww_payroll_period`.`payroll_date`), MONTH(`ww_payroll_period`.`payroll_date`)) as record_id, 
`ww_payroll_period`.`created_on` as "payroll_period_created_on", `ww_payroll_period`.`created_by` as "payroll_period_created_by", 
`ww_payroll_period`.`modified_on` as "payroll_period_modified_on", `ww_payroll_period`.`modified_by` as "payroll_period_modified_by",
YEAR(`ww_payroll_period`.payroll_date) as `year`, MONTHNAME(`ww_payroll_period`.payroll_date) as `month` 
FROM (`ww_payroll_period`)';