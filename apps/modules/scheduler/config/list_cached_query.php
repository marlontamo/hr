<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_scheduler`.`scheduler_id` as record_id, ww_scheduler.description as "scheduler_description", ww_scheduler.sp_function as "scheduler_sp_function", ww_scheduler.arguments as "scheduler_arguments", ww_scheduler.title as "scheduler_title", `ww_scheduler`.`created_on` as "scheduler_created_on", `ww_scheduler`.`created_by` as "scheduler_created_by", `ww_scheduler`.`modified_on` as "scheduler_modified_on", `ww_scheduler`.`modified_by` as "scheduler_modified_by"
FROM (`ww_scheduler`)
WHERE (
	ww_scheduler.description like "%{$search}%" OR 
	ww_scheduler.sp_function like "%{$search}%" OR 
	ww_scheduler.title like "%{$search}%"
)';