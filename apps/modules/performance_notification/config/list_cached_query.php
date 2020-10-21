<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_performance_setup_notification`.`notification_id` as record_id, IF(ww_performance_setup_notification.status_id = 1, "Yes", "No") as "performance_setup_notification_status_id", ww_performance_setup_notification.description as "performance_setup_notification_description", ww_performance_setup_notification.notification as "performance_setup_notification_notification", `ww_performance_setup_notification`.`created_on` as "performance_setup_notification_created_on", `ww_performance_setup_notification`.`created_by` as "performance_setup_notification_created_by", `ww_performance_setup_notification`.`modified_on` as "performance_setup_notification_modified_on", `ww_performance_setup_notification`.`modified_by` as "performance_setup_notification_modified_by"
FROM (`ww_performance_setup_notification`)
WHERE (
	IF(ww_performance_setup_notification.status_id = 1, "Yes", "No") like "%{$search}%" OR 
	ww_performance_setup_notification.description like "%{$search}%" OR 
	ww_performance_setup_notification.notification like "%{$search}%"
)';