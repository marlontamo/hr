<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['users_job_class.status_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Active',
	'description' => '',
	'table' => 'users_job_class',
	'column' => 'status_id',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_job_class.job_class_code'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Job Class Code',
	'description' => '',
	'table' => 'users_job_class',
	'column' => 'job_class_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_job_class.job_class'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Job Class',
	'description' => '',
	'table' => 'users_job_class',
	'column' => 'job_class',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
