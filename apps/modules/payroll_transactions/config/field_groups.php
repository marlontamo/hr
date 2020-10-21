<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Basic Information',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'payroll_transaction.transaction_code',
		'payroll_transaction.transaction_label',
		'payroll_transaction.transaction_class_id',
		'payroll_transaction.transaction_type_id',
		'payroll_transaction.debit_account_id',
		'payroll_transaction.credit_account_id',
		'payroll_transaction.priority_id',
		'payroll_transaction.is_bonus'
	)
);
