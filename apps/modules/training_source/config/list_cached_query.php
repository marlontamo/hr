<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_training_source`.`source_id` as record_id, ww_training_source.description as "training_source_description", ww_training_source.source as "training_source_source", ww_training_source.source_code as "training_source_source_code", `ww_training_source`.`created_on` as "training_source_created_on", `ww_training_source`.`created_by` as "training_source_created_by", `ww_training_source`.`modified_on` as "training_source_modified_on", `ww_training_source`.`modified_by` as "training_source_modified_by"
FROM (`ww_training_source`)
WHERE (
	ww_training_source.description like "%{$search}%" OR 
	ww_training_source.source like "%{$search}%" OR 
	ww_training_source.source_code like "%{$search}%"
)';