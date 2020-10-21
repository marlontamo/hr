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
		'payroll_leave_conversion.employment_type_id',
		'payroll_leave_conversion.company_id',
		'payroll_leave_conversion.form_id',
		'payroll_leave_conversion.convertible',
		'payroll_leave_conversion.forfeited',
		'payroll_leave_conversion.nontax',
		'payroll_leave_conversion.taxable',
		'payroll_leave_conversion.description',
		'payroll_leave_conversion.carry_over'
	)
);
