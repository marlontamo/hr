<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['payroll_entry_batch.document_no'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Document No.',
	'description' => '',
	'table' => 'payroll_entry_batch',
	'column' => 'document_no',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_entry_batch.transaction_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Transaction',
	'description' => '',
	'table' => 'payroll_entry_batch',
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
WHERE a.deleted = 0 and b.is_irregular = 1',
		'multiple' => 0,
		'group_by' => 'transaction_class',
		'label' => 'transaction_label',
		'value' => 'transaction_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_entry_batch.payroll_date'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Payroll Date',
	'description' => '',
	'table' => 'payroll_entry_batch',
	'column' => 'payroll_date',
	'uitype_id' => 6,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_entry_batch.unit_rate_main'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Unit Rate',
	'description' => '',
	'table' => 'payroll_entry_batch',
	'column' => 'unit_rate_main',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 1
);
$config['fields'][1]['payroll_entry_batch.remarks'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'Remarks',
	'description' => '',
	'table' => 'payroll_entry_batch',
	'column' => 'remarks',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
