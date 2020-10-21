<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Career Steam Code Information',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'users_job_rank_code.job_rank_code',
		'users_job_rank_code.job_rank_code_code',
		'users_job_rank_code.status_id'
	)
);
