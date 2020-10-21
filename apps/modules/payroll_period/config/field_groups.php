<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Basic Info',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'payroll_period.date',
		'payroll_period.payroll_date',
		'payroll_period.posting_date',
		'payroll_period.include_basic_and_allowances',
		'payroll_period.include_13th_month_pay',
		'payroll_period.apply_to_id',
		'payroll_period.period_processing_type_id',
		'payroll_period.payroll_schedule_id',
		'payroll_period.week',
		'payroll_period.remarks',
		'payroll_period.period_status_id'
	)
);
