<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = ' SELECT ww_partners_incident.*, ww_partners_incident.incident_id as record_id, partnerso.offense, partnersis.incident_status 
, ww_partners_incident_hearing.user_id as nte_id , ww_partners_incident_hearing.category as category , ww_partners_incident_hearing.explanation as explanation 
, ww_partners_incident_hearing.attachments as "partners_incident_nte.attachments", ww_partners_incident_hearing.nte_status_id as "nte_status_id" 
, IF(ww_partners_incident_hearing.category = "partner", "Involved Employee", "Witness") AS label 
, ww_partners_incident_hearing.hearing_date as "hearing_date",ww_partners_incident_hearing.hr_remarks 
FROM (`ww_partners_incident`)
INNER JOIN ww_partners_incident_hearing ON ww_partners_incident_hearing.incident_id = ww_partners_incident.incident_id AND ww_partners_incident_hearing.user_id = {$user_id}
LEFT JOIN ww_partners_offense partnerso ON ww_partners_incident.offense_id = partnerso.offense_id 
LEFT JOIN ww_partners_incident_status partnersis ON ww_partners_incident.incident_status_id = partnersis.incident_status_id 
WHERE `ww_partners_incident`.`incident_id` = "{$record_id}"';