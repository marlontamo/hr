<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_report_query`.`report_id` as record_id, ww_report_query.report_title as "report_query_report_title", ww_report_query.report_query as "report_query_report_query", `ww_report_query`.`created_on` as "report_query_created_on", `ww_report_query`.`created_by` as "report_query_created_by", `ww_report_query`.`modified_on` as "report_query_modified_on", `ww_report_query`.`modified_by` as "report_query_modified_by"
FROM (`ww_report_query`)
WHERE (
	ww_report_query.report_title like "%{$search}%" OR 
	ww_report_query.report_query like "%{$search}%"
)';