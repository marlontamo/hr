<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = ' SELECT ww_partners_incident.*, 
ww_partners_incident.incident_id as record_id, 
partnerso.offense, 
partnersis.incident_status, 
appr.user_id AS approver_id, 
appr.incident_status_id AS approver_status_id,
(SELECT comment FROM ww_partners_incident_approver iapp 
	WHERE iapp.`incident_id` = "{$record_id}" AND iapp.user_id = "{$approverid}" ) AS app_remarks,
(SELECT comment FROM ww_partners_incident_immediate ime 
	WHERE ime.`incident_id` = "{$record_id}" AND ime.user_id = "{$approverid}" ) AS ime_remarks
FROM ww_partners_incident 
LEFT JOIN ww_partners_incident_approver appr ON ww_partners_incident.incident_id = appr.incident_id AND appr.user_id = "{$approverid}" 
LEFT JOIN ww_partners_incident_immediate ime ON ww_partners_incident.incident_id = ime.incident_id AND ime.user_id = "{$approverid}" 
LEFT JOIN ww_partners_offense partnerso ON ww_partners_incident.offense_id = partnerso.offense_id 
LEFT JOIN ww_partners_incident_status partnersis ON ww_partners_incident.incident_status_id = partnersis.incident_status_id 
WHERE `ww_partners_incident`.`incident_id` = "{$record_id}"';