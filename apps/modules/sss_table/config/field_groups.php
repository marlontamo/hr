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
		'payroll_sss_table.from',
		'payroll_sss_table.to',
		'payroll_sss_table.eeshare',
		'payroll_sss_table.ershare',
		'payroll_sss_table.ec'
	)
);
