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
		'time_record_summary.user_id',
		'time_record_summary.date',
		'time_record_summary.payroll_date',
		'time_record_summary.day_type',
		'time_record_summary.hrs_actual',
		'time_record_summary.absent',
		'time_record_summary.lwp',
		'time_record_summary.lwop',
		'time_record_summary.late',
		'time_record_summary.undertime',
		'time_record_summary.ot'
	)
);
