<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['payroll_bonus.bonus_transaction_id'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Bonus Type',
	'description' => '',
	'table' => 'payroll_bonus',
	'column' => 'bonus_transaction_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '2',
		'table' => 'SELECT a.transaction_id, a.transaction_label, b.transaction_class
FROM {dbprefix}payroll_transaction a
LEFT JOIN {dbprefix}payroll_transaction_class b ON b.transaction_class_id =  a.transaction_class_id
WHERE a.deleted = 0 AND b.is_bonus = 1',
		'multiple' => 1,
		'group_by' => 'transaction_class',
		'label' => 'transaction_label',
		'value' => 'transaction_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_bonus.taxable_bonus_transaction_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Bonus Type Taxable',
	'description' => '',
	'table' => 'payroll_bonus',
	'column' => 'taxable_bonus_transaction_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_bonus.payroll_date'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Payroll Date',
	'description' => '',
	'table' => 'payroll_bonus',
	'column' => 'payroll_date',
	'uitype_id' => 6,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_bonus.date'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Period',
	'description' => '',
	'table' => 'payroll_bonus',
	'column' => 'date',
	'uitype_id' => 12,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_bonus.period'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'No. of Periods',
	'description' => '',
	'table' => 'payroll_bonus',
	'column' => 'period',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_bonus.week'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'Apply Week/s',
	'description' => '',
	'table' => 'payroll_bonus',
	'column' => 'week',
	'uitype_id' => 10,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'payroll_week',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'week',
		'value' => 'week_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_bonus.transaction_method_id'] = array(
	'f_id' => 6,
	'fg_id' => 1,
	'label' => 'Method',
	'description' => '',
	'table' => 'payroll_bonus',
	'column' => 'transaction_method_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 6,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'payroll_transaction_method_bonus',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'payroll_transaction_method_bonus',
		'value' => 'payroll_transaction_method_bonus_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_bonus.account_id'] = array(
	'f_id' => 7,
	'fg_id' => 1,
	'label' => 'Account',
	'description' => '',
	'table' => 'payroll_bonus',
	'column' => 'account_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 7,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '2',
		'table' => 'SELECT a.*, b.account_type
FROM {dbprefix}payroll_account a
LEFT JOIN {dbprefix}payroll_account_type b on b.account_type_id = a.account_type_id
WHERE a.deleted = 0 AND b.deleted = 0',
		'multiple' => 0,
		'group_by' => 'account_type',
		'label' => 'account_name',
		'value' => 'account_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_bonus.description'] = array(
	'f_id' => 8,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => '',
	'table' => 'payroll_bonus',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 8,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
