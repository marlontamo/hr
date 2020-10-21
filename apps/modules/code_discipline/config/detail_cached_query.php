<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["detail_cached_query"] = 'SELECT `ww_partners_offense`.`offense_id` AS record_id, 
`ww_partners_offense`.`created_on` AS "partners_offense.created_on", 
`ww_partners_offense`.`created_by` AS "partners_offense.created_by", 
`ww_partners_offense`.`modified_on` AS "partners_offense.modified_on", 
`ww_partners_offense`.`modified_by` AS "partners_offense.modified_by", 
ww_partners_offense.offense AS "partners_offense.offense", 
pol.offense_level AS "partners_offense.offense_level",  
ww_partners_offense.offense_level_id AS "partners_offense.offense_level_id", 
poc.offense_category AS "partners_offense.offense_category", 
ww_partners_offense.offense_category_id AS "partners_offense.offense_category_id",
GROUP_CONCAT(CONCAT(pol.offense_level," - ",T1.sanction) SEPARATOR ",") AS "partners_offense.sanction"
FROM (`ww_partners_offense`)
LEFT JOIN `ww_partners_offense_category` poc ON  `ww_partners_offense`.`offense_category_id` = `poc`.`offense_category_id`
LEFT JOIN `ww_partners_offense_sanction` T1 ON FIND_IN_SET(T1.sanction_id,ww_partners_offense.sanction_id)
LEFT JOIN `ww_partners_offense_level` pol ON  `ww_partners_offense`.`offense_level_id` = `pol`.`offense_level_id`
WHERE `ww_partners_offense`.`offense_id` = "{$record_id}"';