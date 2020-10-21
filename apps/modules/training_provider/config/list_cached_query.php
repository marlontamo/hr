<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_training_provider`.`provider_id` as record_id, ww_training_provider.description as "training_provider_description", ww_training_provider.provider_code as "training_provider_provider_code", ww_training_provider.provider as "training_provider_provider", `ww_training_provider`.`created_on` as "training_provider_created_on", `ww_training_provider`.`created_by` as "training_provider_created_by", `ww_training_provider`.`modified_on` as "training_provider_modified_on", `ww_training_provider`.`modified_by` as "training_provider_modified_by"
FROM (`ww_training_provider`)
WHERE (
	ww_training_provider.description like "%{$search}%" OR 
	ww_training_provider.provider_code like "%{$search}%" OR 
	ww_training_provider.provider like "%{$search}%"
)';