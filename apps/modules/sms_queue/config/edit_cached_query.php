<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_system_sms_queue`.`id` as record_id, ww_system_sms_queue.sent_on as "system_sms_queue.sent_on", ww_system_sms_queue.status as "system_sms_queue.status", ww_system_sms_queue.body as "system_sms_queue.body", ww_system_sms_queue.subject as "system_sms_queue.subject", ww_system_sms_queue.bcc as "system_sms_queue.bcc", ww_system_sms_queue.cc as "system_sms_queue.cc", ww_system_sms_queue.to as "system_sms_queue.to", ww_system_sms_queue.timein as "system_sms_queue.timein"
FROM (`ww_system_sms_queue`)
WHERE `ww_system_sms_queue`.`id` = "{$record_id}"';