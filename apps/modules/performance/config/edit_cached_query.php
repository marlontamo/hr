<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_performance_setup_performance`.`performance_id` as record_id, `ww_performance_setup_performance`.`created_on` as "performance_setup_performance.created_on", `ww_performance_setup_performance`.`created_by` as "performance_setup_performance.created_by", `ww_performance_setup_performance`.`modified_on` as "performance_setup_performance.modified_on", `ww_performance_setup_performance`.`modified_by` as "performance_setup_performance.modified_by", ww_performance_setup_performance.status_id as "performance_setup_performance.status_id", ww_performance_setup_performance.send_feeds as "performance_setup_performance.send_feeds", ww_performance_setup_performance.send_email as "performance_setup_performance.send_email", ww_performance_setup_performance.send_sms as "performance_setup_performance.send_sms", ww_performance_setup_performance.description as "performance_setup_performance.description", ww_performance_setup_performance.performance_group as "performance_setup_performance.performance_group", ww_performance_setup_performance.performance as "performance_setup_performance.performance"
FROM (`ww_performance_setup_performance`)
WHERE `ww_performance_setup_performance`.`performance_id` = "{$record_id}"';