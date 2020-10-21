<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_performance_setup_library`.`library_id` as record_id, IF(ww_performance_setup_library.status_id = 1, "Yes", "No") as "performance_setup_library_status_id", ww_performance_setup_library.description as "performance_setup_library_description", ww_performance_setup_library.library as "performance_setup_library_library", `ww_performance_setup_library`.`created_on` as "performance_setup_library_created_on", `ww_performance_setup_library`.`created_by` as "performance_setup_library_created_by", `ww_performance_setup_library`.`modified_on` as "performance_setup_library_modified_on", `ww_performance_setup_library`.`modified_by` as "performance_setup_library_modified_by"
FROM (`ww_performance_setup_library`)
WHERE (
	IF(ww_performance_setup_library.status_id = 1, "Yes", "No") like "%{$search}%" OR 
	ww_performance_setup_library.description like "%{$search}%" OR 
	ww_performance_setup_library.library like "%{$search}%"
)';