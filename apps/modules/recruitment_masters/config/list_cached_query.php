<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_recruits`.`recruit_id` as record_id, `ww_recruits`.`created_on` as "recruits_created_on", `ww_recruits`.`created_by` as "recruits_created_by", `ww_recruits`.`modified_on` as "recruits_modified_on", `ww_recruits`.`modified_by` as "recruits_modified_by"
FROM (`ww_recruits`)';