<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query_custom"] = 'SELECT `ww_recruitment`.`recruit_id` as record_id,
DATE_FORMAT(ww_recruitment.birth_date, \'%M %d, %Y\') as "birth_date", 
DATE_FORMAT(ww_recruitment.recruitment_date, \'%M %d, %Y\') as "recruitment_date", 
  `ww_recruitment`.`oth_position` AS "oth_position",
  `ww_recruitment`.`status_id` AS "status_id",
  `ww_recruitment`.`email` AS "email",
  `ww_recruitment`.`nickname` AS "nickname",
  `ww_recruitment`.`maidenname` AS "maidenname",
  `ww_recruitment`.`middlename` AS "middlename",
  `ww_recruitment`.`firstname` AS "firstname",
  `ww_recruitment`.`lastname` AS "lastname",
  `ww_recruitment`.`request_id` AS "request_id",
  `ww_recruitment`.`created_on` AS "created_on",
  `ww_recruitment`.`created_by` AS "created_by",
  `ww_recruitment`.`modified_on` AS "modified_on",
  `ww_recruitment`.`modified_by` AS "modified_by",
  `ww_recruitment_status`.`recruit_status` AS `recruit_status`
FROM (`ww_recruitment`)
LEFT JOIN `ww_recruitment_status` ON `ww_recruitment_status`.`recruit_status_id` = `ww_recruitment`.`status_id`
WHERE `ww_recruitment`.`recruit_id` = "{$record_id}"';

$config["edit_cached_query_personal_custom"] = 'SELECT 
`ww_recruitment`.`recruit_id` AS record_id, 
`ww_recruitment_personal`.`key_id` AS key_id, 
`ww_recruitment_personal`.`key` AS `key`, 
`ww_recruitment_personal`.`sequence` AS `sequence`, 
`ww_recruitment_personal`.`key_name` AS `key_name`, 
`ww_recruitment_personal`.`key_value` AS `key_value`
 FROM ww_recruitment_personal 
LEFT JOIN ww_recruitment ON ww_recruitment.recruit_id = ww_recruitment_personal.recruit_id
WHERE ww_recruitment.recruit_id = "{$record_id}"';