<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_job_rank_code.job_rank_code_code'][] = array(
	'field'   => 'users_job_rank_code[job_rank_code_code]',
	'label'   => 'Career Steam Code Code',
	'rules'   => 'V'
);
$config['field_validations']['users_job_rank_code.status_id'][] = array(
	'field'   => 'users_job_rank_code[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
$config['field_validations']['users_job_rank_code.job_rank_code'][] = array(
	'field'   => 'users_job_rank_code[job_rank_code]',
	'label'   => 'Career Steam Code',
	'rules'   => 'V'
);
