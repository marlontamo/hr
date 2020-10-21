<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_groups`.`group_id` as record_id, 
`ww_groups`.`created_on` as "groups_created_on", 
`ww_groups`.`created_by` as "groups_created_by", 
`ww_groups`.`modified_on` as "groups_modified_on", 
`ww_groups`.`modified_by` as "groups_modified_by",
`ww_groups`.`group_name` as "groups_group_name",
`ww_groups`.`description` as "groups_description"
FROM (`ww_groups`)
JOIN `ww_groups_members` T1 on T1.`group_id` = `ww_groups`.`group_id`';