<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_recruitment`.`recruit_id` as record_id,
DATE_FORMAT(ww_recruitment.birth_date, \'%M %d, %Y\') as "birth_date", 
DATE_FORMAT(ww_recruitment.recruitment_date, \'%M %d, %Y\') as "recruitment_date", 
  `ww_recruitment`.`status_id` AS "recruitment_status_id",
  `ww_recruitment`.`email` AS "recruitment_email",
  `ww_recruitment`.`nickname` AS "recruitment_nickname",
  `ww_recruitment`.`maidenname` AS "recruitment_maidenname",
  `ww_recruitment`.`middlename` AS "recruitment_middlename",
  `ww_recruitment`.`firstname` AS "recruitment_firstname",
  `ww_recruitment`.`lastname` AS "recruitment_lastname",
  `ww_recruitment`.`created_on` AS "recruitment_created_on",
  `ww_recruitment`.`created_by` AS "recruitment_created_by",
  `ww_recruitment`.`modified_on` AS "recruitment_modified_on",
  `ww_recruitment`.`modified_by` AS "recruitment_modified_by",
  `ww_recruitment_personal`.`key_value` as "recruitment_position_sought",
  `ww_recruitment_status`.`recruit_status`,
  `ww_recruitment`.`request_id`,
  `req`.`document_no`,
  `req`.`department_id`,
  `req`.`company_id`,
  `dept`.`department`,
  `comp`.`company_code`,
  recpro.status_id AS process_stat_id,
  recpro.process_id,
  recstat.label AS process_stat,
  recpro.modified_on AS process_modified,
  IF(`ww_recruitment`.`partner_id` > 0, "internal", "external") as applicant_type
FROM (`ww_recruitment`)
LEFT JOIN `ww_recruitment_personal` ON `ww_recruitment_personal`.`recruit_id` = `ww_recruitment`.`recruit_id` AND `ww_recruitment_personal`.`key` = "position_sought"
LEFT JOIN `ww_recruitment_status` ON `ww_recruitment_status`.`recruit_status_id` = `ww_recruitment`.`status_id`
LEFT JOIN `ww_recruitment_request` req ON req.`request_id` = `ww_recruitment`.`request_id`
LEFT JOIN ww_users_department dept ON req.department_id = dept.department_id 
LEFT JOIN ww_users_company comp ON req.company_id = comp.company_id
LEFT JOIN ww_recruitment_process recpro ON recpro.request_id = ww_recruitment.request_id AND recpro.recruit_id = ww_recruitment.recruit_id 
LEFT JOIN ww_recruitment_process_status recstat ON recstat.status_id = recpro.status_id
WHERE (
  ww_recruitment_personal.key_value like "%{$search}%" OR 
  ww_recruitment.email like "%{$search}%" OR 
  ww_recruitment.nickname like "%{$search}%" OR 
  ww_recruitment.maidenname like "%{$search}%" OR 
  ww_recruitment.middlename like "%{$search}%" OR 
  ww_recruitment.firstname like "%{$search}%" OR 
  ww_recruitment.lastname like "%{$search}%"
)';