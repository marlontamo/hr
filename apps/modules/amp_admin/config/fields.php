<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['recruitment_manpower_plan.year'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Year',
	'description' => '',
	'table' => 'recruitment_manpower_plan',
	'column' => 'year',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);

$config['fields'][1]['recruitment_manpower_plan.company_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Company',
	'description' => '',
	'table' => 'recruitment_manpower_plan',
	'column' => 'company_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
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
$config['fields'][1]['recruitment_manpower_plan.department_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Department ',
	'description' => '',
	'table' => 'recruitment_manpower_plan',
	'column' => 'department_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'users_department',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'department',
		'value' => 'department_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['recruitment_manpower_plan.departmenthead'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Department Head',
	'description' => '',
	'table' => 'recruitment_manpower_plan',
	'column' => 'departmenthead',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['recruitment_manpower_plan.created_by'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'Created By',
	'description' => '',
	'table' => 'recruitment_manpower_plan',
	'column' => 'created_by',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['recruitment_manpower_plan.attachment'] = array(
	'f_id' => 6,
	'fg_id' => 1,
	'label' => 'Attachments',
	'description' => '',
	'table' => 'recruitment_manpower_plan',
	'column' => 'attachment',
	'uitype_id' => 9,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 6,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);