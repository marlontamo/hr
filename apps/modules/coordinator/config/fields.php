<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['users_coordinator.company_id'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Company',
	'description' => '',
	'table' => 'users_coordinator',
	'column' => 'company_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'users_company',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'company',
		'value' => 'company_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['users_coordinator.branch_id'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Branch',
	'description' => '',
	'table' => 'users_coordinator',
	'column' => 'branch_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'users_branch',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'branch',
		'value' => 'branch_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['users_coordinator.coordinator_user_id'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Coordinator',
	'description' => '',
	'table' => 'users_coordinator',
	'column' => 'coordinator_user_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'users',
		'multiple' => 1,
		'group_by' => '',
		'label' => 'full_name',
		'value' => 'user_id',
		'textual_value_column' => ''
	)
);