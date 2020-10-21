<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_partners_clinic_records`.`clinic_records_id` as record_id, ww_partners_clinic_records.details as "partners_clinic_records_details", ww_partners_clinic_records.other_med_cost as "partners_clinic_records_other_med_cost", ww_partners_clinic_records.diagnosis as "partners_clinic_records_diagnosis", ww_partners_clinic_records.complaint as "partners_clinic_records_complaint", ww_partners_clinic_records.medication_qty as "partners_clinic_records_medication_qty", ww_partners_clinic_records.medication as "partners_clinic_records_medication", T1.alias as "partners_clinic_records_partner_id", `ww_partners_clinic_records`.`created_on` as "clinic_created_on", `ww_partners_clinic_records`.`created_by` as "clinic_created_by", `ww_partners_clinic_records`.`modified_on` as "clinic_modified_on", `ww_partners_clinic_records`.`modified_by` as "clinic_modified_by"
, `T7`.`position`, `T8`.`department`, `T9`.`company_code`, ww_partners_clinic_records.attachments as attachments
FROM (`ww_partners_clinic_records`)
LEFT JOIN `ww_partners` T1 ON `T1`.`partner_id` = `ww_partners_clinic_records`.`partner_id`
LEFT JOIN `ww_users_profile` T6 ON `T6`.`partner_id` = `T1`.`partner_id`
LEFT JOIN `ww_users_position` T7 ON `T7`.`position_id` = `T6`.`position_id`
LEFT JOIN `ww_users_department` T8 ON `T8`.`department_id` = `T6`.`department_id`
LEFT JOIN `ww_users_company` T9 ON `T9`.`company_id` = `T6`.`company_id`
WHERE (
	ww_partners_clinic_records.details like "%{$search}%" OR 
	ww_partners_clinic_records.other_med_cost like "%{$search}%" OR 
	ww_partners_clinic_records.diagnosis like "%{$search}%" OR 
	ww_partners_clinic_records.complaint like "%{$search}%" OR 
	ww_partners_clinic_records.medication_qty like "%{$search}%" OR 
	ww_partners_clinic_records.medication like "%{$search}%" OR 
	T1.alias like "%{$search}%"
)';