<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['report_generator.roles'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'Accessed By',
	'description' => '',
	'table' => 'report_generator',
	'column' => 'roles',
	'uitype_id' => 10,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'roles',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'role',
		'value' => 'role_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['report_generator.category_id'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Category',
	'description' => '',
	'table' => 'report_generator',
	'column' => 'category_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'report_generator_category',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'category',
		'value' => 'category_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['report_generator.description'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => '',
	'table' => 'report_generator',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['report_generator.report_name'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Report Title',
	'description' => '',
	'table' => 'report_generator',
	'column' => 'report_name',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['report_generator.report_code'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Report Code',
	'description' => '',
	'table' => 'report_generator',
	'column' => 'report_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
