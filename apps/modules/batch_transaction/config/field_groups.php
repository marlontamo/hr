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
		'payroll_entry_batch.document_no',
		'payroll_entry_batch.transaction_id',
		'payroll_entry_batch.payroll_date',
		'payroll_entry_batch.unit_rate_main',
		'payroll_entry_batch.remarks'
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
