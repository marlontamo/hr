<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][3]['users_job_title.job_title'] = array(
	'f_id' => 1,
	'fg_id' => 3,
	'label' => 'Job Title',
	'description' => '',
	'table' => 'users_job_title',
	'column' => 'job_title',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][3]['users_job_title.job_title_code'] = array(
	'f_id' => 2,
	'fg_id' => 3,
	'label' => 'Job Title Code',
	'description' => '',
	'table' => 'users_job_title',
	'column' => 'job_title_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][3]['users_job_title.status_id'] = array(
	'f_id' => 3,
	'fg_id' => 3,
	'label' => 'Active',
	'description' => '',
	'table' => 'users_job_title',
	'column' => 'status_id',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
