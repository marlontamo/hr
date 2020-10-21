<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['payroll_transaction.transaction_code'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Transaction Code',
	'description' => '',
	'table' => 'payroll_transaction',
	'column' => 'transaction_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_transaction.transaction_label'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Transaction Label',
	'description' => '',
	'table' => 'payroll_transaction',
	'column' => 'transaction_label',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_transaction.transaction_class_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Transaction Class',
	'description' => '',
	'table' => 'payroll_transaction',
	'column' => 'transaction_class_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'Required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'payroll_transaction_class',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'transaction_class',
		'value' => 'transaction_class_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_transaction.transaction_type_id'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Transaction Type',
	'description' => '',
	'table' => 'payroll_transaction',
	'column' => 'transaction_type_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'payroll_transaction_type',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'transaction_type',
		'value' => 'transaction_type_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_transaction.debit_account_id'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'Debit Account Code',
	'description' => '',
	'table' => 'payroll_transaction',
	'column' => 'debit_account_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => '',
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
$config['fields'][1]['payroll_transaction.credit_account_id'] = array(
	'f_id' => 6,
	'fg_id' => 1,
	'label' => 'Credit Account Code',
	'description' => '',
	'table' => 'payroll_transaction',
	'column' => 'credit_account_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 6,
	'datatype' => '',
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
$config['fields'][1]['payroll_transaction.priority_id'] = array(
	'f_id' => 7,
	'fg_id' => 1,
	'label' => 'Priority',
	'description' => '',
	'table' => 'payroll_transaction',
	'column' => 'priority_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 7,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'payroll_transaction_priority',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'priority',
		'value' => 'priority_id',
		'textual_value_column' => ''
	)
);

$config['fields'][1]['payroll_transaction.is_bonus'] = array(
	'f_id' => 8,
	'fg_id' => 1,
	'label' => 'Is Bonus',
	'description' => '',
	'table' => 'payroll_transaction',
	'column' => 'is_bonus',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 8,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);

