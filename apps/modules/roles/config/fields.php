<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][2]['roles.profile_id'] = array(
	'f_id' => 7,
	'fg_id' => 2,
	'label' => 'Profile Associated',
	'description' => '',
	'table' => 'roles',
	'column' => 'profile_id',
	'uitype_id' => 10,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'profiles',
		'multiple' => 1,
		'group_by' => '',
		'label' => 'profile',
		'value' => 'profile_id',
		'textual_value_column' => ''
	)
);
$config['fields'][2]['roles.description'] = array(
	'f_id' => 6,
	'fg_id' => 2,
	'label' => 'Description',
	'description' => '',
	'table' => 'roles',
	'column' => 'description',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['roles.role'] = array(
	'f_id' => 4,
	'fg_id' => 2,
	'label' => 'Role Name',
	'description' => '',
	'table' => 'roles',
	'column' => 'role',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['roles.company_id'] = array(
	'f_id' => 5,
	'fg_id' => 2,
	'label' => 'Profile Associated',
	'description' => '',
	'table' => 'roles',
	'column' => 'company_id',
	'uitype_id' => 10,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'profiles',
		'multiple' => 1,
		'group_by' => '',
		'label' => 'company',
		'value' => 'company_id',
		'textual_value_column' => ''
	)
);
$config['fields'][2]['roles.branch_id'] = array(
	'f_id' => 3,
	'fg_id' => 2,
	'label' => 'Profile Associated',
	'description' => '',
	'table' => 'roles',
	'column' => 'branch_id',
	'uitype_id' => 10,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'profiles',
		'multiple' => 1,
		'group_by' => '',
		'label' => 'branch',
		'value' => 'branch_id',
		'textual_value_column' => ''
	)
);

