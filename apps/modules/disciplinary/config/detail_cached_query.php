<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = ' SELECT ww_partners_incident.*, ww_partners_incident.incident_id as record_id, partnerso.offense, partnersis.incident_status 
, hr_remarks, nte_partner, nte_immediate, nte_witnesses, nte_others
, da.sanction_id as da_sanction_id, if(da.date_from = "0000-00-00", null, da.date_from) as da_date_from, if(da.date_to = "0000-00-00", null, da.date_to) as da_date_to, da.suspension_days as da_suspension_days 
, da.damages_payment as da_damages_payment, da.remarks as da_remarks, offsanction.sanction as da_sanction 
, ww_partners_incident.involved_partners as involved_partners 
FROM ww_partners_incident 
LEFT JOIN ww_partners_disciplinary_action da ON ww_partners_incident.incident_id = da.incident_id 
LEFT JOIN ww_partners_offense_sanction offsanction ON da.sanction_id = offsanction.sanction_id 
LEFT JOIN ww_partners_offense partnerso ON ww_partners_incident.offense_id = partnerso.offense_id 
LEFT JOIN ww_partners_incident_status partnersis ON ww_partners_incident.incident_status_id = partnersis.incident_status_id 
WHERE `ww_partners_incident`.`incident_id` = "{$record_id}"';