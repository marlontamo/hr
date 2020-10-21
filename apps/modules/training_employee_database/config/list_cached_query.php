<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_training_employee_database`.`employee_database_id` as record_id, 
`ww_training_employee_database`.`employee_id` as "training_employee_database_employee_id",
`ww_training_employee_database`.`position_id` as "training_employee_database_position_id",
`ww_training_employee_database`.`department_id` as "training_employee_database_department_id",
`ww_training_employee_database`.`training_balance` as "training_employee_database_training_balance",
`ww_training_employee_database`.`daily_training_cost` as "training_employee_database_daily_training_cost",
`ww_training_employee_database`.`start_date` as "training_employee_database_start_date",
`ww_training_employee_database`.`end_date` as "training_employee_database_end_date",
`T1`.`full_name` as "training_employee_database_employee",
`T2`.`position` as "training_employee_database_position",
`T3`.`department` as "training_employee_database_department",
`ww_training_employee_database`.`created_on` as "training_employee_database_created_on", 
`ww_training_employee_database`.`created_by` as "training_employee_database_created_by", 
`ww_training_employee_database`.`modified_on` as "training_employee_database_modified_on", 
`ww_training_employee_database`.`modified_by` as "training_employee_database_modified_by"

FROM (`ww_training_employee_database`)
LEFT JOIN `ww_users` T1 ON `T1`.`user_id` = `ww_training_employee_database`.`employee_id`
LEFT JOIN `ww_users_position` T2 ON `T2`.`position_id` = `ww_training_employee_database`.`position_id`
LEFT JOIN `ww_users_department` T3 ON `T3`.`department_id` = `ww_training_employee_database`.`department_id`
WHERE (
	T1.full_name like "%{$search}%" OR 
	T2.position like "%{$search}%" OR 
	T3.department like "%{$search}%"
)';