<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_partners_incident`.`incident_id` as record_id, ww_partners_incident.damages as "partners_incident_damages", ww_partners_incident.violation_details as "partners_incident_violation_details", ww_partners_incident.location as "partners_incident_location", T6.full_name as "partners_incident_witnesses", ww_partners_incident.attachments as "partners_incident_attachments", DATE_FORMAT(ww_partners_incident.date_time_of_offense, \'%M %d, %Y %h:%i %p\') as "partners_incident_date_time_of_offense", T3.full_name as "partners_incident_complainants", T2.offense as "partners_incident_offense_id", T1.full_name as "partners_incident_involved_partners", `ww_partners_incident`.`created_on` as "partner_incident_created_on", `ww_partners_incident`.`created_by` as "partner_incident_created_by", `ww_partners_incident`.`modified_on` as "partner_incident_modified_on", `ww_partners_incident`.`modified_by` as "partner_incident_modified_by"
, ww_partners_incident.incident_status_id AS incident_status_id, ww_partners_incident.involved_partners as involved_partners
, ww_partners_incident.date_sent as date_sent , ww_partners_incident.status as status, stat.incident_status as incident_status 
, appr.user_id AS approver_id, ww_partners_incident.complainants as complainants 
FROM (`ww_partners_incident`)
LEFT JOIN `ww_users` T6 ON `T6`.`user_id` = `ww_partners_incident`.`witnesses`
LEFT JOIN `ww_users` T3 ON `T3`.`user_id` = `ww_partners_incident`.`complainants`
LEFT JOIN `ww_partners_offense` T2 ON `T2`.`offense_id` = `ww_partners_incident`.`offense_id`
LEFT JOIN `ww_users` T1 ON `T1`.`user_id` = `ww_partners_incident`.`involved_partners`
LEFT JOIN `ww_partners_incident_status` stat ON `stat`.`incident_status_id` = `ww_partners_incident`.`incident_status_id`
LEFT JOIN `ww_users_profile` ON `ww_users_profile`.`user_id` = `ww_partners_incident`.`involved_partners`
INNER JOIN ww_partners_incident_approver appr ON ww_partners_incident.incident_id = appr.incident_id
WHERE (
	ww_partners_incident.damages like "%{$search}%" OR 
	ww_partners_incident.violation_details like "%{$search}%" OR 
	ww_partners_incident.location like "%{$search}%" OR 
	T6.full_name like "%{$search}%" OR 
	ww_partners_incident.attachments like "%{$search}%" OR 
	DATE_FORMAT(ww_partners_incident.date_time_of_offense, \'%M %d, %Y %h:%i %p\') like "%{$search}%" OR 
	T3.full_name like "%{$search}%" OR 
	T2.offense like "%{$search}%" OR 
	T1.full_name like "%{$search}%"
)' ;