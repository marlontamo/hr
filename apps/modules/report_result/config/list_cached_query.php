<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_report_results`.`result_id` as record_id, ww_report_results.filepath as "report_results_filepath", ww_report_results.file_type as "report_results_file_type", T1.report_name as "report_results_report_id", `ww_report_results`.`created_on` as "report_results_created_on", `ww_report_results`.`created_by` as "report_results_created_by", `ww_report_results`.`modified_on` as "report_results_modified_on", `ww_report_results`.`modified_by` as "report_results_modified_by"
FROM (`ww_report_results`)
LEFT JOIN `ww_report_generator` T1 ON `T1`.`report_id` = `ww_report_results`.`report_id`
WHERE (
	ww_report_results.filepath like "%{$search}%" OR 
	ww_report_results.file_type like "%{$search}%" OR 
	T1.report_name like "%{$search}%"
)';