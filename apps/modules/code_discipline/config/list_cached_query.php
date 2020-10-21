<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_partners_offense`.`offense_id` as record_id, 
T2.offense_level as "partners_offense_offense_level_id", 
T1.offense_category as "partners_offense_offense_category_id", 
ww_partners_offense.offense as "partners_offense_offense", 
`ww_partners_offense`.`created_on` as "partners_offense_created_on", 
`ww_partners_offense`.`created_by` as "partners_offense_created_by", 
`ww_partners_offense`.`modified_on` as "partners_offense_modified_on", 
`ww_partners_offense`.`modified_by` as "partners_offense_modified_by",
GROUP_CONCAT(CONCAT(T2.offense_level," - ",T3.sanction) SEPARATOR "<br> ") AS "partners_offense_sanction"
FROM (`ww_partners_offense`)
LEFT JOIN `ww_partners_offense_sanction` T3 ON FIND_IN_SET(T3.sanction_id,ww_partners_offense.sanction_id)
LEFT JOIN `ww_partners_offense_level` T2 ON `T2`.`offense_level_id` = T3.`offense_level_id`
LEFT JOIN `ww_partners_offense_category` T1 ON `T1`.`offense_category_id` = `ww_partners_offense`.`offense_category_id`
WHERE (
	T2.offense_level like "%{$search}%" OR 
	T1.offense_category like "%{$search}%" OR 
	ww_partners_offense.offense like "%{$search}%"
)';