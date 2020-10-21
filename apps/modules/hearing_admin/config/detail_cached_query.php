<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = ' SELECT ww_partners_incident.*, 
ww_partners_incident.incident_id as record_id, 
partnerso.offense, 
partnersis.incident_status, 
(SELECT IF(hearing_date="0000-00-00", null, hearing_date) FROM ww_partners_incident_hearing WHERE `ww_partners_incident_hearing`.`incident_id` = "{$record_id}" LIMIT 1) as nte_hearing_date,
(SELECT hr_remarks FROM ww_partners_incident_hearing WHERE `ww_partners_incident_hearing`.`incident_id` = "{$record_id}" LIMIT 1) as nte_hr_remarks 
FROM (`ww_partners_incident`)
LEFT JOIN ww_partners_offense partnerso ON ww_partners_incident.offense_id = partnerso.offense_id 
LEFT JOIN ww_partners_incident_status partnersis ON ww_partners_incident.incident_status_id = partnersis.incident_status_id 
WHERE `ww_partners_incident`.`incident_id` = "{$record_id}"';