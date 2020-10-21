<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_time_shift`.`shift_id` as record_id, 
									   `ww_time_shift`.`created_on` as "time_shift.created_on", 
									   `ww_time_shift`.`created_by` as "time_shift.created_by", 
									   `ww_time_shift`.`modified_on` as "time_shift.modified_on", 
									   `ww_time_shift`.`modified_by` as "time_shift.modified_by", 
									   ww_time_shift.shift as "time_shift.shift", 
									   ww_time_shift.time_start as "time_shift.time_start", 
									   ww_time_shift.time_end as "time_shift.time_end", 
									   ww_time_shift.color as "time_shift.color", 
									   ww_time_shift.default_calendar as "time_shift.default_calendar",
									   ww_time_shift.use_tag as "time_shift.use_tag"
								FROM (`ww_time_shift`)
								WHERE `ww_time_shift`.`shift_id` = "{$record_id}"';