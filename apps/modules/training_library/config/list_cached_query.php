<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_training_library`.`library_id` as record_id, DATE_FORMAT(ww_training_library.published_date, \'%M %d, %Y\') as "training_library_published_date", ww_training_library.module as "training_library_module", ww_training_library.description as "training_library_description", ww_training_library.author as "training_library_author", ww_training_library.library as "training_library_library", `ww_training_library`.`created_on` as "training_library_created_on", `ww_training_library`.`created_by` as "training_library_created_by", `ww_training_library`.`modified_on` as "training_library_modified_on", `ww_training_library`.`modified_by` as "training_library_modified_by"
FROM (`ww_training_library`)
WHERE (
	DATE_FORMAT(ww_training_library.published_date, \'%M %d, %Y\') like "%{$search}%" OR 
	ww_training_library.module like "%{$search}%" OR 
	ww_training_library.description like "%{$search}%" OR 
	ww_training_library.author like "%{$search}%" OR 
	ww_training_library.library like "%{$search}%"
)';