<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_modules`.`mod_id` as record_id, `ww_modules`.`short_name` as "modules_short_name", `ww_modules`.`long_name` as "modules_long_name", `ww_modules`.`description` as "modules_description", IF(ww_modules.disabled = 1, "Yes", "No") as "modules_disabled", `ww_modules`.`mod_code` as "modules_mod_code", `ww_modules`.`route` as "modules_route", `ww_modules`.`table` as "modules_table", `ww_modules`.`primary_key` as "modules_primary_key", IF(ww_modules.enable_mass_action = 1, "Yes", "No") as "modules_enable_mass_action", IF(ww_modules.wizard_on_new = 1, "Yes", "No") as "modules_wizard_on_new", `ww_modules`.`list_template_header` as "modules_list_template_header", `ww_modules`.`list_template` as "modules_list_template", `ww_modules`.`icon` as "modules_icon", `ww_modules`.`created_on` as "modules_created_on", `ww_modules`.`created_by` as "modules_created_by", `ww_modules`.`modified_on` as "modules_modified_on", `ww_modules`.`modified_by` as "modules_modified_by"
FROM (`ww_modules`)
WHERE (
ww_modules.short_name like "%{$search}%" OR 
ww_modules.long_name like "%{$search}%" OR 
ww_modules.description like "%{$search}%" OR 
IF(ww_modules.disabled = 1, "Yes", "No") like "%{$search}%" OR 
ww_modules.mod_code like "%{$search}%" OR 
ww_modules.route like "%{$search}%" OR 
ww_modules.table like "%{$search}%" OR 
ww_modules.primary_key like "%{$search}%" OR 
IF(ww_modules.enable_mass_action = 1, "Yes", "No") like "%{$search}%" OR 
IF(ww_modules.wizard_on_new = 1, "Yes", "No") like "%{$search}%" OR 
ww_modules.list_template_header like "%{$search}%" OR 
ww_modules.list_template like "%{$search}%" OR 
ww_modules.icon like "%{$search}%"
)';