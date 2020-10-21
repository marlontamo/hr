<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_partners_offense_sanction`.`sanction_id` as record_id, 
T2.offense_level as "partners_offense_sanction_sanction_level_id", 
T1.offense_sanction_category as "partners_offense_sanction_sanction_category_id", 
ww_partners_offense_sanction.sanction as "partners_offense_sanction_sanction", 
`ww_partners_offense_sanction`.`created_on` as "partners_offense_sanction_created_on", 
`ww_partners_offense_sanction`.`created_by` as "partners_offense_sanction_created_by", 
`ww_partners_offense_sanction`.`modified_on` as "partners_offense_sanction_modified_on", 
`ww_partners_offense_sanction`.`modified_by` as "partners_offense_sanction_modified_by"
FROM (`ww_partners_offense_sanction`)
LEFT JOIN `ww_partners_offense_level` T2 ON `T2`.`offense_level_id` = `ww_partners_offense_sanction`.`offense_level_id`
LEFT JOIN `ww_partners_offense_sanction_category` T1 ON `T1`.`offense_sanction_category_id` = `ww_partners_offense_sanction`.`sanction_category_id`
WHERE (
	T2.offense_level like "%{$search}%" OR 
	T1.offense_sanction_category like "%{$search}%" OR 
	ww_partners_offense_sanction.sanction like "%{$search}%"
)';