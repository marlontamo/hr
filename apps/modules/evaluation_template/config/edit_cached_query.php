<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_training_evaluation_template`.`evaluation_template_id` as record_id, `ww_training_evaluation_template`.`created_on` as "training_evaluation_template.created_on", `ww_training_evaluation_template`.`created_by` as "training_evaluation_template.created_by", `ww_training_evaluation_template`.`modified_on` as "training_evaluation_template.modified_on", `ww_training_evaluation_template`.`modified_by` as "training_evaluation_template.modified_by", ww_training_evaluation_template.description as "training_evaluation_template.description", ww_training_evaluation_template.applicable_for as "training_evaluation_template.applicable_for", ww_training_evaluation_template.title as "training_evaluation_template.title"
FROM (`ww_training_evaluation_template`)
WHERE `ww_training_evaluation_template`.`evaluation_template_id` = "{$record_id}"';