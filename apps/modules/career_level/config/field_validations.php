<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_job_rank_level.status_id'][] = array(
	'field'   => 'users_job_rank_level[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
$config['field_validations']['users_job_rank_level.job_rank_level_code'][] = array(
	'field'   => 'users_job_rank_level[job_rank_level_code]',
	'label'   => 'Job Rank Level Code',
	'rules'   => 'required'
);
$config['field_validations']['users_job_rank_level.job_rank_level'][] = array(
	'field'   => 'users_job_rank_level[job_rank_level]',
	'label'   => 'Job Rank Level',
	'rules'   => 'required'
);
