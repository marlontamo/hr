<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['payroll_account.arrangement'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Arrangement',
	'description' => 'arrangement for display on JV',
	'table' => 'payroll_account',
	'column' => 'arrangement',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_account.account_code'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Account Code',
	'description' => '',
	'table' => 'payroll_account',
	'column' => 'account_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_account.account_name'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Account Name',
	'description' => '',
	'table' => 'payroll_account',
	'column' => 'account_name',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_account.account_type_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Account Type',
	'description' => '',
	'table' => 'payroll_account',
	'column' => 'account_type_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'payroll_account_type',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'account_type',
		'value' => 'account_type_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_account.description'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => '',
	'table' => 'payroll_account',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
