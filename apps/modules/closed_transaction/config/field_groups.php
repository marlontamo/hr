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
		'payroll_closed_transaction.employee_id',
		'payroll_closed_transaction.payroll_date',
		'payroll_closed_transaction.transaction_id',
		'payroll_closed_transaction.quantity',
		'payroll_closed_transaction.unit_rate',
		'payroll_closed_transaction.amount',
		'payroll_closed_transaction.remarks'
	)
);
