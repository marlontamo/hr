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
		'payroll_entry_recurring.document_no',
		'payroll_entry_recurring.transaction_id',
		'payroll_entry_recurring.date',
		'payroll_entry_recurring.transaction_method_id',
		'payroll_entry_recurring.account_id',
		'payroll_entry_recurring.week',
		'payroll_entry_recurring.amount',
		'payroll_entry_recurring.remarks'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Employees',
	'description' => 'This section manage to add company, division, department, position, employee type and location.',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(	)
);
