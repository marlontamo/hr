<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_partners_offense_sanction_category`.`offense_sanction_category_id` as record_id, ww_partners_offense_sanction_category.description as "partners_offense_sanction_category_description", ww_partners_offense_sanction_category.offense_sanction_category as "partners_offense_sanction_category_offense_sanction_category", `ww_partners_offense_sanction_category`.`created_on` as "partners_offense_sanction_category_created_on", `ww_partners_offense_sanction_category`.`created_by` as "partners_offense_sanction_category_created_by", `ww_partners_offense_sanction_category`.`modified_on` as "partners_offense_sanction_category_modified_on", `ww_partners_offense_sanction_category`.`modified_by` as "partners_offense_sanction_category_modified_by"
FROM (`ww_partners_offense_sanction_category`)
WHERE (
	ww_partners_offense_sanction_category.description like "%{$search}%" OR 
	ww_partners_offense_sanction_category.offense_sanction_category like "%{$search}%"
)';