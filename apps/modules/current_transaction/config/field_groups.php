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
		'payroll_current_transaction.processing_type_id',
		'payroll_current_transaction.employee_id',
		'payroll_current_transaction.payroll_date',
		'payroll_current_transaction.transaction_id',
		'payroll_current_transaction.quantity',
		'payroll_current_transaction.unit_rate',
		'payroll_current_transaction.amount',
		'payroll_current_transaction.on_hold',
		'payroll_current_transaction.remarks'
	)
);
