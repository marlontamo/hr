<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['users_competency_level.status_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Action',
	'description' => '',
	'table' => 'users_competency_level',
	'column' => 'status_id',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_competency_level.competency_level_code'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Competency Level Code',
	'description' => '',
	'table' => 'users_competency_level',
	'column' => 'competency_level_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_competency_level.competency_level'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Competency Level',
	'description' => '',
	'table' => 'users_competency_level',
	'column' => 'competency_level',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
