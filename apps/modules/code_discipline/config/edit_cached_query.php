<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_partners_offense`.`offense_id` as record_id, 
`ww_partners_offense`.`created_on` as "partners_offense.created_on", 
`ww_partners_offense`.`created_by` as "partners_offense.created_by", 
`ww_partners_offense`.`modified_on` as "partners_offense.modified_on", 
`ww_partners_offense`.`modified_by` as "partners_offense.modified_by", 
ww_partners_offense.offense_level_id as "partners_offense.offense_level_id", 
ww_partners_offense.sanction_id as "partners_offense.sanction_id",
ww_partners_offense.offense_category_id as "partners_offense.offense_category_id",
ww_partners_offense.offense as "partners_offense.offense"
FROM (`ww_partners_offense`)
WHERE `ww_partners_offense`.`offense_id` = "{$record_id}"';