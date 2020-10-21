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
		'payroll_bonus.bonus_transaction_id',
		'payroll_bonus.payroll_date',
		'payroll_bonus.date',
		'payroll_bonus.period',
		'payroll_bonus.week',
		'payroll_bonus.transaction_method_id',
		'payroll_bonus.account_id',
		'payroll_bonus.description'
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
