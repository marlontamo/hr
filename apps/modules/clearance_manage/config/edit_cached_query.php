<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT ww_partners_clearance.*, 
`ww_partners_clearance`.`clearance_id` as record_id, 
`ww_partners_clearance`.`created_on` as "partner_clearance_created_on", 
`ww_partners_clearance`.`created_by` as "partner_clearance_created_by", 
`ww_partners_clearance`.`modified_on` as "partner_clearance_modified_on", 
`ww_partners_clearance`.`modified_by` as "partner_clearance_modified_by"
, ww_partners_clearance_status.status as clearance_status, 
users_profile.firstname, users_profile.lastname, 
ww_users_company.company, ww_users_department.department 
, IF(ww_partners_clearance.turn_around_time="0000-00-00", null, DATE_FORMAT(ww_partners_clearance.turn_around_time,"%M %d, %Y")) as turn_around_time
, IF(ww_partners_clearance.effectivity_date="0000-00-00", null, DATE_FORMAT(ww_partners_clearance.effectivity_date,"%M %d, %Y")) as effectivity_date
FROM (`ww_partners_clearance`)
INNER JOIN ww_partners_clearance_status ON ww_partners_clearance.status_id = ww_partners_clearance_status.status_id
INNER JOIN users_profile ON ww_partners_clearance.partner_id = users_profile.partner_id
INNER JOIN ww_users_company ON users_profile.company_id = ww_users_company.company_id
LEFT JOIN ww_users_department ON users_profile.department_id = ww_users_department.department_id
WHERE `ww_partners_clearance`.`clearance_id` = "{$record_id}"';