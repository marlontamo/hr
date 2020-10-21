<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_partners_offense_level`.`offense_level_id` as record_id, ww_partners_offense_level.offense_level as "partners_offense_level_offense_level", ww_partners_offense_level.description as "partners_offense_level_description", ww_partners_offense_level.offense_level_id as "partners_offense_level_offense_level_id", `ww_partners_offense_level`.`created_on` as "partners_offense_level_created_on", `ww_partners_offense_level`.`created_by` as "partners_offense_level_created_by", `ww_partners_offense_level`.`modified_on` as "partners_offense_level_modified_on", `ww_partners_offense_level`.`modified_by` as "partners_offense_level_modified_by"
FROM (`ww_partners_offense_level`)
WHERE (
	ww_partners_offense_level.offense_level like "%{$search}%" OR 
	ww_partners_offense_level.description like "%{$search}%" OR 
	ww_partners_offense_level.offense_level_id like "%{$search}%"
)';