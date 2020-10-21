<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'payroll relation',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'time_period.company_id',
		'time_period.payroll_date',
		'time_period.date'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'allowable time to process ',
	'description' => '',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(
		'time_period.cutoff'
	)
);
$config['fieldgroups'][3] = array(
	'fg_id' => 3,
	'label' => 'process date to all late approval',
	'description' => '',
	'display_id' => 3,
	'sequence' => 3,
	'active' => 1,
	'fields' => array(
		'time_period.previous_cutoff'
	)
);
