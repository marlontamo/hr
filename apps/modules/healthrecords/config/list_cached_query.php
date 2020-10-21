<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_partners_health_records`.`health_id` as record_id, ww_partners_health_records.recommendation as "partners_health_records_recommendation", ww_partners_health_records.diagnosis as "partners_health_records_diagnosis", ww_partners_health_records.findings as "partners_health_records_findings", ww_partners_health_records.attachments as "partners_health_records_attachments", T5.health_type_status as "partners_health_records_health_type_status_id", DATE_FORMAT(ww_partners_health_records.date_of_completion, \'%M %d, %Y\') as "partners_health_records_date_of_completion", ww_partners_health_records.health_provider as "partners_health_records_health_provider", T2.health_type as "partners_health_records_health_type_id", T1.alias as "partners_health_records_partner_id", `ww_partners_health_records`.`created_on` as "partners_health_records_created_on", `ww_partners_health_records`.`created_by` as "partners_health_records_created_by", `ww_partners_health_records`.`modified_on` as "partners_health_records_modified_on", `ww_partners_health_records`.`modified_by` as "partners_health_records_modified_by"
, `T7`.`position`
FROM (`ww_partners_health_records`)
LEFT JOIN `ww_partners_health_type_status` T5 ON `T5`.`health_type_status_id` = `ww_partners_health_records`.`health_type_status_id`
LEFT JOIN `ww_partners_health_type` T2 ON `T2`.`health_type_id` = `ww_partners_health_records`.`health_type_id`
LEFT JOIN `ww_partners` T1 ON `T1`.`partner_id` = `ww_partners_health_records`.`partner_id`
LEFT JOIN `ww_users_profile` T6 ON `T6`.`partner_id` = `T1`.`partner_id`
LEFT JOIN `ww_users_position` T7 ON `T7`.`position_id` = `T6`.`position_id`
WHERE (
	ww_partners_health_records.recommendation like "%{$search}%" OR 
	ww_partners_health_records.diagnosis like "%{$search}%" OR 
	ww_partners_health_records.findings like "%{$search}%" OR 
	ww_partners_health_records.attachments like "%{$search}%" OR 
	T5.health_type_status like "%{$search}%" OR 
	DATE_FORMAT(ww_partners_health_records.date_of_completion, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_partners_health_records.health_provider like "%{$search}%" OR 
	T2.health_type like "%{$search}%" OR 
	T1.alias like "%{$search}%"
)';