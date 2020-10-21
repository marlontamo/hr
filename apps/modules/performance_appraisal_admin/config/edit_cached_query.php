<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_performance_appraisal`.`appraisal_id` as record_id, `ww_performance_appraisal`.`created_on` as "performance_appraisal.created_on", `ww_performance_appraisal`.`created_by` as "performance_appraisal.created_by", `ww_performance_appraisal`.`modified_on` as "performance_appraisal.modified_on", `ww_performance_appraisal`.`modified_by` as "performance_appraisal.modified_by"
FROM (`ww_performance_appraisal`)
WHERE `ww_performance_appraisal`.`appraisal_id` = "{$record_id}"';