<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_training_employee_database`.`employee_database_id` as record_id, `ww_training_employee_database`.`created_on` as "training_employee_database.created_on", `ww_training_employee_database`.`created_by` as "training_employee_database.created_by", `ww_training_employee_database`.`modified_on` as "training_employee_database.modified_on", `ww_training_employee_database`.`modified_by` as "training_employee_database.modified_by"
FROM (`ww_training_employee_database`)
WHERE `ww_training_employee_database`.`employee_database_id` = "{$record_id}"';