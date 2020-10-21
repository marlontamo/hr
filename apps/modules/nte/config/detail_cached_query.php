<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = ' SELECT ww_partners_incident.*, ww_partners_incident.incident_id as record_id, partnerso.offense, partnersis.incident_status 
, ww_partners_incident_nte.user_id as nte_id , ww_partners_incident_nte.category as category , ww_partners_incident_nte.explanation as explanation 
, ww_partners_incident_nte.attachments as "partners_incident_nte.attachments", ww_partners_incident_nte.nte_status_id as "nte_status_id" 
, IF(ww_partners_incident_nte.category = "partner", "Involved Employee", "Witness") AS label,
pii.comment AS hr_remarks 
FROM (`ww_partners_incident`)
INNER JOIN ww_partners_incident_nte ON ww_partners_incident_nte.incident_id = ww_partners_incident.incident_id AND ww_partners_incident_nte.user_id = {$user_id}
LEFT JOIN ww_partners_offense partnerso ON ww_partners_incident.offense_id = partnerso.offense_id 
LEFT JOIN ww_partners_incident_immediate pii ON ww_partners_incident.incident_id = pii.incident_id 
LEFT JOIN ww_partners_incident_status partnersis ON ww_partners_incident.incident_status_id = partnersis.incident_status_id 
WHERE `ww_partners_incident`.`incident_id` = "{$record_id}"';