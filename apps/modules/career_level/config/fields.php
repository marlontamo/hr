<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['users_job_rank_level.status_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Active',
	'description' => '',
	'table' => 'users_job_rank_level',
	'column' => 'status_id',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_job_rank_level.job_rank_level_code'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Job Rank Level Code',
	'description' => '',
	'table' => 'users_job_rank_level',
	'column' => 'job_rank_level_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_job_rank_level.job_rank_level'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Job Rank Level',
	'description' => '',
	'table' => 'users_job_rank_level',
	'column' => 'job_rank_level',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
