<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['payroll_transaction_class.transaction_class_code'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Class Code',
	'description' => '',
	'table' => 'payroll_transaction_class',
	'column' => 'transaction_class_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_transaction_class.transaction_class'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Class Name',
	'description' => '',
	'table' => 'payroll_transaction_class',
	'column' => 'transaction_class',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_transaction_class.description'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => '',
	'table' => 'payroll_transaction_class',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
