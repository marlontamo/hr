<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_x`.`x` as record_id, `ww_x`.`created_on` as "x_created_on", `ww_x`.`created_by` as "x_created_by", `ww_x`.`modified_on` as "x_modified_on", `ww_x`.`modified_by` as "x_modified_by"
FROM (`ww_x`)';