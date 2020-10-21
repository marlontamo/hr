<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_system_sms_queue`.`id` as record_id, 
IF(sent_on IS NULL or sent_on = "", "", DATE_FORMAT(ww_system_sms_queue.sent_on, \'%M %d, %Y %h:%i %p\')) as "system_sms_queue_sent_on", ww_system_sms_queue.status as "system_sms_queue_status", ww_system_sms_queue.body as "system_sms_queue_body", ww_system_sms_queue.subject as "system_sms_queue_subject", 
ww_system_sms_queue.bcc as "system_sms_queue_bcc", 
ww_system_sms_queue.cc as "system_sms_queue_cc", 
ww_system_sms_queue.to as "system_sms_queue_to", 
IF(timein IS NULL or timein = "", "", DATE_FORMAT(ww_system_sms_queue.timein, \'%M %d, %Y %h:%i %p\')) as "system_sms_queue_timein" 
FROM (`ww_system_sms_queue`)
WHERE (
	DATE_FORMAT(ww_system_sms_queue.sent_on, \'%M %d, %Y %h:%i %p\') like "%{$search}%" OR 
	ww_system_sms_queue.status like "%{$search}%" OR 
	ww_system_sms_queue.body like "%{$search}%" OR 
	ww_system_sms_queue.subject like "%{$search}%" OR 
	ww_system_sms_queue.bcc like "%{$search}%" OR 
	ww_system_sms_queue.cc like "%{$search}%" OR 
	ww_system_sms_queue.to like "%{$search}%" OR 
	DATE_FORMAT(ww_system_sms_queue.timein, \'%M %d, %Y %h:%i %p\') like "%{$search}%"
)';