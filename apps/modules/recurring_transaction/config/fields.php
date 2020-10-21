<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['payroll_entry_recurring.document_no'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Document No.',
	'description' => '',
	'table' => 'payroll_entry_recurring',
	'column' => 'document_no',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_entry_recurring.transaction_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Transaction',
	'description' => '',
	'table' => 'payroll_entry_recurring',
	'column' => 'transaction_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '2',
		'table' => 'SELECT a.*, b.transaction_class
FROM {dbprefix}payroll_transaction a
LEFT JOIN {dbprefix}payroll_transaction_class b on b.transaction_class_id = a.transaction_class_id
WHERE a.deleted = 0 and b.is_recurring = 1',
		'multiple' => 0,
		'group_by' => 'transaction_class',
		'label' => 'transaction_label',
		'value' => 'transaction_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_entry_recurring.date'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Date From - To',
	'description' => '',
	'table' => 'payroll_entry_recurring',
	'column' => 'date',
	'uitype_id' => 12,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_entry_recurring.transaction_method_id'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Method',
	'description' => '',
	'table' => 'payroll_entry_recurring',
	'column' => 'transaction_method_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'payroll_transaction_method',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'payroll_transaction_method',
		'value' => 'payroll_transaction_method_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_entry_recurring.account_id'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'Account Code',
	'description' => '',
	'table' => 'payroll_entry_recurring',
	'column' => 'account_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
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
$config['fields'][1]['payroll_entry_recurring.week'] = array(
	'f_id' => 6,
	'fg_id' => 1,
	'label' => 'Apply Week/s',
	'description' => '',
	'table' => 'payroll_entry_recurring',
	'column' => 'week',
	'uitype_id' => 10,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 6,
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
$config['fields'][1]['payroll_entry_recurring.amount'] = array(
	'f_id' => 7,
	'fg_id' => 1,
	'label' => 'Rate',
	'description' => '',
	'table' => 'payroll_entry_recurring',
	'column' => 'amount',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 7,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 1
);
$config['fields'][1]['payroll_entry_recurring.remarks'] = array(
	'f_id' => 8,
	'fg_id' => 1,
	'label' => 'Remarks',
	'description' => '',
	'table' => 'payroll_entry_recurring',
	'column' => 'remarks',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 8,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
