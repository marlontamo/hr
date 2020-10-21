<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['payroll_account_sub.account_sub'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Sub Account Name',
	'description' => '',
	'table' => 'payroll_account_sub',
	'column' => 'account_sub',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_account_sub.account_sub_code'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Sub Account Code',
	'description' => '',
	'table' => 'payroll_account_sub',
	'column' => 'account_sub_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_account_sub.category_id'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Category',
	'description' => '',
	'table' => 'payroll_account_sub',
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
		'table' => 'payroll_account_category',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'category',
		'value' => 'category_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_account_sub.account_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Account Name',
	'description' => '',
	'table' => 'payroll_account_sub',
	'column' => 'account_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'payroll_account',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'account_name',
		'value' => 'account_id',
		'textual_value_column' => ''
	)
);
