<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['users_division.division'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Division',
	'description' => '',
	'table' => 'users_division',
	'column' => 'division',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_division.division_code'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Division Code',
	'description' => '',
	'table' => 'users_division',
	'column' => 'division_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_division.immediate_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Immediate Head',
	'description' => '',
	'table' => 'users_division',
	'column' => 'immediate_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'users',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'display_name',
		'value' => 'user_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['users_division.position'] = array(
	'f_id' => 6,
	'fg_id' => 1,
	'label' => 'Immediate Position',
	'description' => '',
	'table' => 'users_division',
	'column' => 'position',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_division.status_id'] = array(
	'f_id' => 7,
	'fg_id' => 1,
	'label' => 'Active',
	'description' => '',
	'table' => 'users_division',
	'column' => 'status_id',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
