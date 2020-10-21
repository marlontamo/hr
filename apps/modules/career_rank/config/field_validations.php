<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_job_rank.status_id'][] = array(
	'field'   => 'users_job_rank[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
$config['field_validations']['users_job_rank.job_rank_code'][] = array(
	'field'   => 'users_job_rank[job_rank_code]',
	'label'   => 'Career Rank Code',
	'rules'   => 'V'
);
$config['field_validations']['users_job_rank.job_rank'][] = array(
	'field'   => 'users_job_rank[job_rank]',
	'label'   => 'Career Rank',
	'rules'   => 'V'
);
