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
		'payroll_whtax_table.payroll_schedule_id',
		'payroll_whtax_table.taxcode_id',
		'payroll_whtax_table.salary_from',
		'payroll_whtax_table.salary_to',
		'payroll_whtax_table.fixed_amount',
		'payroll_whtax_table.excess_percentage'
	)
);
