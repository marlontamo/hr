<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_time_shift`.`shift_id` as record_id, ww_time_shift.shift as "time_shift_shift", DATE_FORMAT(ww_time_shift.time_start, \'%h:%i %p\') as "time_shift_time_start", DATE_FORMAT(ww_time_shift.time_end, \'%h:%i %p\') as "time_shift_time_end", ww_time_shift.color as "time_shift_color", `ww_time_shift`.`created_on` as "time_shift_created_on", `ww_time_shift`.`created_by` as "time_shift_created_by", `ww_time_shift`.`modified_on` as "time_shift_modified_on", `ww_time_shift`.`modified_by` as "time_shift_modified_by"
FROM (`ww_time_shift`)
WHERE (
	ww_time_shift.shift like "%{$search}%" OR 
	DATE_FORMAT(ww_time_shift.time_start, \'%h:%i %p\') like "%{$search}%" OR 
	DATE_FORMAT(ww_time_shift.time_end, \'%h:%i %p\') like "%{$search}%" OR 
	ww_time_shift.color like "%{$search}%"
)';