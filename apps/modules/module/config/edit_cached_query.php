<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_modules`.`mod_id` as record_id, `ww_modules`.`created_on` as "modules.created_on", `ww_modules`.`created_by` as "modules.created_by", `ww_modules`.`modified_on` as "modules.modified_on", `ww_modules`.`modified_by` as "modules.modified_by", `ww_modules`.`short_name` as "modules.short_name", `ww_modules`.`long_name` as "modules.long_name", `ww_modules`.`description` as "modules.description", `ww_modules`.`disabled` as "modules.disabled", `ww_modules`.`mod_code` as "modules.mod_code", `ww_modules`.`route` as "modules.route", `ww_modules`.`table` as "modules.table", `ww_modules`.`primary_key` as "modules.primary_key", `ww_modules`.`enable_mass_action` as "modules.enable_mass_action", `ww_modules`.`wizard_on_new` as "modules.wizard_on_new", `ww_modules`.`list_template_header` as "modules.list_template_header", `ww_modules`.`list_template` as "modules.list_template", `ww_modules`.`icon` as "modules.icon", `ww_modules`.`fg_id` as "modules.fg_if", `ww_modules`.`f_id` as "modules.f_id"
FROM (`ww_modules`)
WHERE `ww_modules`.`mod_id` = "{$record_id}"';