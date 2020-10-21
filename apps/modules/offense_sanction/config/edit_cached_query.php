<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_partners_offense_sanction`.`sanction_id` as record_id, 
`ww_partners_offense_sanction`.`created_on` as "partners_offense_sanction.created_on", 
`ww_partners_offense_sanction`.`created_by` as "partners_offense_sanction.created_by", 
`ww_partners_offense_sanction`.`modified_on` as "partners_offense_sanction.modified_on", 
`ww_partners_offense_sanction`.`modified_by` as "partners_offense_sanction.modified_by", 
ww_partners_offense_sanction.offense_level_id as "partners_offense_sanction.offense_level_id", 
ww_partners_offense_sanction.sanction_category_id as "partners_offense_sanction.sanction_category_id", 
ww_partners_offense_sanction.sanction as "partners_offense_sanction.sanction"
FROM (`ww_partners_offense_sanction`)
WHERE `ww_partners_offense_sanction`.`sanction_id` = "{$record_id}"';