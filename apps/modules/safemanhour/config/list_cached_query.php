<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_partners_safe_manhour`.`safe_manhour_id` as record_id, ww_partners_safe_manhour.medication_qty as "partners_safe_manhour_medication_qty", ww_partners_safe_manhour.attachment as "partners_safe_manhour_attachment", ww_partners_safe_manhour.details as "partners_safe_manhour_details", ww_partners_safe_manhour.medication as "partners_safe_manhour_medication", T7.status as "partners_safe_manhour_status_id", DATE_FORMAT(ww_partners_safe_manhour.date_return_to_work, \'%M %d, %Y\') as "partners_safe_manhour_date_return_to_work", DATE_FORMAT(ww_partners_safe_manhour.date_incident, \'%M %d, %Y\') as "partners_safe_manhour_date_incident", ww_partners_safe_manhour.total_manhour as "partners_safe_manhour_total_manhour", ww_partners_safe_manhour.health_provider as "partners_safe_manhour_health_provider", T2.nature as "partners_safe_manhour_nature_id", T1.alias as "partners_safe_manhour_partner_id", `ww_partners_safe_manhour`.`created_on` as "partners_safe_manhour_created_on", `ww_partners_safe_manhour`.`created_by` as "partners_safe_manhour_created_by", `ww_partners_safe_manhour`.`modified_on` as "partners_safe_manhour_modified_on", `ww_partners_safe_manhour`.`modified_by` as "partners_safe_manhour_modified_by"
, `T8`.`position` 
FROM (`ww_partners_safe_manhour`)
LEFT JOIN `ww_partners_safe_manhour_status` T7 ON `T7`.`status_id` = `ww_partners_safe_manhour`.`status_id`
LEFT JOIN `ww_partners_safe_manhour_nature` T2 ON `T2`.`nature_id` = `ww_partners_safe_manhour`.`nature_id`
LEFT JOIN `ww_partners` T1 ON `T1`.`partner_id` = `ww_partners_safe_manhour`.`partner_id`
LEFT JOIN `ww_users_profile` T6 ON `T6`.`partner_id` = `T1`.`partner_id`
LEFT JOIN `ww_users_position` T8 ON `T8`.`position_id` = `T6`.`position_id`
WHERE (
	ww_partners_safe_manhour.medication_qty like "%{$search}%" OR 
	ww_partners_safe_manhour.attachment like "%{$search}%" OR 
	ww_partners_safe_manhour.details like "%{$search}%" OR 
	ww_partners_safe_manhour.medication like "%{$search}%" OR 
	T7.status like "%{$search}%" OR 
	DATE_FORMAT(ww_partners_safe_manhour.date_return_to_work, \'%M %d, %Y\') like "%{$search}%" OR 
	DATE_FORMAT(ww_partners_safe_manhour.date_incident, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_partners_safe_manhour.total_manhour like "%{$search}%" OR 
	ww_partners_safe_manhour.health_provider like "%{$search}%" OR 
	T2.nature like "%{$search}%" OR 
	T1.alias like "%{$search}%"
)';