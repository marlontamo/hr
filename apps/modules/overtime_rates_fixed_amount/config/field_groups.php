<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Overtime Rates Information',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'payroll_overtime_rates_amount.company_id',
		'payroll_overtime_rates_amount.employment_type_id',
		'payroll_overtime_rates_amount.overtime_location_id'
	)
);
