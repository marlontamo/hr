<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Career Level Information',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'users_job_rank_level.job_rank_level',
		'users_job_rank_level.job_rank_level_code',
		'users_job_rank_level.status_id'
	)
);
