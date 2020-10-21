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
		'payroll_annual_tax.salary_from',
		'payroll_annual_tax.salary_to',
		'payroll_annual_tax.amount',
		'payroll_annual_tax.rate'
	)
);
