<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT 
`ww_1`.`1` as record_id, 
`ww_1`.`created_on` as "1_created_on", 
`ww_1`.`created_by` as "1_created_by", 
`ww_1`.`modified_on` as "1_modified_on", 
`ww_1`.`modified_by` as "1_modified_by"
FROM (`ww_1`)';