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
		'payroll_loan_type.loan_type',
		'payroll_loan_type.description'
	)
);
