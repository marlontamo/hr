<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['payroll_loan.loan_code'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Loan Code',
	'description' => '',
	'table' => 'payroll_loan',
	'column' => 'loan_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_loan.loan'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Loan Name',
	'description' => '',
	'table' => 'payroll_loan',
	'column' => 'loan',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_loan.loan_type_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Loan Type',
	'description' => '',
	'table' => 'payroll_loan',
	'column' => 'loan_type_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'payroll_loan_type',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'loan_type',
		'value' => 'loan_type_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_loan.loan_mode_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Loan Mode',
	'description' => '',
	'table' => 'payroll_loan',
	'column' => 'loan_mode_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'payroll_loan_mode',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'loan_mode',
		'value' => 'loan_mode_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_loan.principal_transid'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Principal Transaction',
	'description' => '',
	'table' => 'payroll_loan',
	'column' => 'principal_transid',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '2',
		'table' => 'SELECT a.transaction_code, a.transaction_id, a.transaction_label, b.transaction_class
FROM {dbprefix}payroll_transaction a
LEFT JOIN {dbprefix}payroll_transaction_class b ON b.transaction_class_id =  a.transaction_class_id
WHERE a.deleted = 0 AND b.transaction_class_code = \'LNEMPL\'',
		'multiple' => 0,
		'group_by' => 'transaction_class',
		'label' => 'transaction_label',
		'value' => 'transaction_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_loan.amortization_transid'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'Amortization Transaction',
	'description' => '',
	'table' => 'payroll_loan',
	'column' => 'amortization_transid',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 6,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '2',
		'table' => 'SELECT a.transaction_code, a.transaction_id, a.transaction_label, b.transaction_class
FROM {dbprefix}payroll_transaction a
LEFT JOIN {dbprefix}payroll_transaction_class b ON b.transaction_class_id =  a.transaction_class_id
WHERE a.deleted = 0 AND b.transaction_class_code = \'LOAN_AMORTIZATION\'',
		'multiple' => 0,
		'group_by' => 'transaction_class',
		'label' => 'transaction_label',
		'value' => 'transaction_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_loan.amount_limit'] = array(
	'f_id' => 6,
	'fg_id' => 1,
	'label' => 'Amount Limit',
	'description' => '',
	'table' => 'payroll_loan',
	'column' => 'amount_limit',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 7,
	'datatype' => 'numeric',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['payroll_loan.interest_transid'] = array(
	'f_id' => 7,
	'fg_id' => 2,
	'label' => 'Interest Transaction',
	'description' => '',
	'table' => 'payroll_loan',
	'column' => 'interest_transid',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '2',
		'table' => 'SELECT a.transaction_code, a.transaction_id, a.transaction_label, b.transaction_class
FROM {dbprefix}payroll_transaction a
LEFT JOIN {dbprefix}payroll_transaction_class b ON b.transaction_class_id =  a.transaction_class_id
WHERE a.deleted = 0 AND b.transaction_class_code = \'LOAN_INTEREST\'',
		'multiple' => 0,
		'group_by' => 'transaction_class',
		'label' => 'transaction_label',
		'value' => 'transaction_id',
		'textual_value_column' => ''
	)
);
$config['fields'][2]['payroll_loan.interest_type_id'] = array(
	'f_id' => 8,
	'fg_id' => 2,
	'label' => 'Interest Mode',
	'description' => '',
	'table' => 'payroll_loan',
	'column' => 'interest_type_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'payroll_loan_interest_type',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'interest_type',
		'value' => 'interest_type_id',
		'textual_value_column' => ''
	)
);
$config['fields'][2]['payroll_loan.debit'] = array(
	'f_id' => 9,
	'fg_id' => 2,
	'label' => 'Debit',
	'description' => '',
	'table' => 'payroll_loan',
	'column' => 'debit',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
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
$config['fields'][2]['payroll_loan.credit'] = array(
	'f_id' => 10,
	'fg_id' => 2,
	'label' => 'Credit',
	'description' => '',
	'table' => 'payroll_loan',
	'column' => 'credit',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
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
$config['fields'][2]['payroll_loan.interest'] = array(
	'f_id' => 11,
	'fg_id' => 2,
	'label' => 'Monthly Interest',
	'description' => '',
	'table' => 'payroll_loan',
	'column' => 'interest',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => 'numeric',
	'active' => '1',
	'encrypt' => 0
);
