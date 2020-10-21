<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_time_forms`.`forms_id` as record_id, 
DATE_FORMAT(ww_time_forms.date_from, \'%M %d, %Y\') as "time_forms_date_from", DATE_FORMAT(ww_time_forms.date_to, \'%M %d, %Y\') as "time_forms_date_to", ww_time_form.form as "time_form_form", ww_time_form_status.form_status as "time_form_status_form_status", ww_time_forms.reason as "time_forms_reason", ww_time_forms.form_status_id as "time_forms_form_status_id", 
DATE_FORMAT(ww_time_forms.date_from, \'%M %d, %Y\') as "time_forms_date_from", DATE_FORMAT(ww_time_forms.date_to, \'%M %d, %Y\') as "time_forms_date_to", ww_time_forms.reason as "time_forms_reason", ww_time_forms.form_status_id as "time_forms_form_status_id", 
DATE_FORMAT(ww_time_forms.date_from, \'%M %d, %Y\') as "time_forms_date_from", DATE_FORMAT(ww_time_forms.date_to, \'%M %d, %Y\') as "time_forms_date_to", ww_time_forms.reason as "time_forms_reason", ww_time_forms.form_status_id as "time_forms_form_status_id", 
DATE_FORMAT(ww_time_forms.date_from, \'%M %d, %Y\') as "time_forms_date_from", DATE_FORMAT(ww_time_forms.date_to, \'%M %d, %Y\') as "time_forms_date_to", ww_time_forms.reason as "time_forms_reason", ww_time_forms.form_status_id as "time_forms_form_status_id", 
-- DATE_FORMAT(ww_time_forms_date.time_from, \'%M %d, %Y\') as "time_forms_time_from", 
-- DATE_FORMAT(ww_time_forms_date.time_to, \'%M %d, %Y\') as "time_forms_time_to", 
ww_time_forms.reason as "time_forms_reason", "Undefined Searchable Dropdown" as "time_forms_maternity_delivery_id", ww_time_forms_maternity.pregnancy_no as "time_forms_maternity_pregnancy_no", DATE_FORMAT(ww_time_forms_maternity.expected_date, \'%M %d, %Y\') as "time_forms_maternity_expected_date", DATE_FORMAT(ww_time_forms_maternity.actual_date, \'%M %d, %Y\') as "time_forms_maternity_actual_date", DATE_FORMAT(ww_time_forms_maternity.return_date, \'%M %d, %Y\') as "time_forms_maternity_return_date", ww_time_forms.form_status_id as "time_forms_form_status_id", `ww_time_forms`.`scheduled` as "time_forms_scheduled", `ww_time_forms`.`created_on` as "time_forms_created_on", `ww_time_forms`.`created_by` as "time_forms_created_by", `ww_time_forms`.`modified_on` as "time_forms_modified_on", `ww_time_forms`.`modified_by` as "time_forms_modified_by",
`ww_time_form`.`class` as "time_form_class"
FROM `time_forms` as ww_time_forms
LEFT JOIN `ww_time_forms_maternity` ON `ww_time_forms_maternity`.`forms_id` = `ww_time_forms`.`forms_id`
LEFT JOIN `ww_time_form` ON `ww_time_form`.`form_id` = `ww_time_forms`.`form_id`
-- LEFT JOIN `ww_time_forms_date` ON `ww_time_forms_date`.`forms_id` = `ww_time_forms`.`forms_id`
LEFT JOIN `ww_time_form_status` ON `ww_time_form_status`.`form_status_id` = `ww_time_forms`.`form_status_id`
WHERE (
	DATE_FORMAT(ww_time_forms.date_from, \'%M %d, %Y\') like "%{$search}%" OR 
	DATE_FORMAT(ww_time_forms.date_to, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_time_forms.reason like "%{$search}%" OR 
	ww_time_form.form like "%{$search}%" OR
	ww_time_form_status.form_status like "%{$search}%" OR  
	ww_time_forms.form_status_id like "%{$search}%" OR 
	ww_time_forms_maternity.pregnancy_no like "%{$search}%" OR 
	DATE_FORMAT(ww_time_forms_maternity.expected_date, \'%M %d, %Y\') like "%{$search}%" OR 
	DATE_FORMAT(ww_time_forms_maternity.actual_date, \'%M %d, %Y\') like "%{$search}%" OR 
	DATE_FORMAT(ww_time_forms_maternity.return_date, \'%M %d, %Y\') like "%{$search}%"
)
';