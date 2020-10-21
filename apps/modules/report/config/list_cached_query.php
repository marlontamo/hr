<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_report`.`report_id` as record_id, `ww_report`.`created_on` as "report_created_on", `ww_report`.`created_by` as "report_created_by", `ww_report`.`modified_on` as "report_modified_on", `ww_report`.`modified_by` as "report_modified_by"
FROM (`ww_report`)';