<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT 
			ted.`employee_database_id` AS `record_id`,
			u.`full_name` AS `employee`,
			upos.position AS `position`,
			ud.division AS `division`,
			udep.department AS `department`,
			uproj.project AS `project`,
			ujr.job_rank AS `rank`, 
			pes.employment_status AS `employment_status`,
			ted.`daily_training_cost` AS `daily_training_cost`,
			ted.`training_balance` AS `training_balance`

			FROM ww_training_employee_database ted 
			LEFT JOIN ww_users u ON u.`user_id` = ted.`employee_id`	
			LEFT JOIN ww_partners p ON p.`user_id` = ted.`employee_id`
			LEFT JOIN ww_users_profile up ON up.`user_id` = ted.`employee_id`
			LEFT JOIN ww_users_position upos ON upos.`position_id` = ted.`position_id`
			LEFT JOIN ww_users_division ud ON ud.`division_id` = ted.`division_id`
			LEFT JOIN ww_users_department udep ON udep.`department_id` = ted.`department_id`
			LEFT JOIN ww_users_project uproj ON uproj.`project_id` = ted.`project_name_id`
			LEFT JOIN ww_users_job_rank ujr ON ujr.`job_rank_id` = ted.`rank_id`
			LEFT JOIN ww_partners_employment_status pes ON pes.`employment_status_id` = p.`status_id`
			WHERE ted.`employee_database_id` = "{$record_id}"';