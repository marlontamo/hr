<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['users_specialization.status_id'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Action',
	'description' => '',
	'table' => 'users_specialization',
	'column' => 'status_id',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_specialization.specialization_code'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Specialization Code',
	'description' => '',
	'table' => 'users_specialization',
	'column' => 'specialization_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_specialization.specialization'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Specialization',
	'description' => '',
	'table' => 'users_specialization',
	'column' => 'specialization',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
