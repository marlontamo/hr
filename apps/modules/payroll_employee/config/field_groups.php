<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Employee Setup ',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'payroll_partners.total_year_days',
		'payroll_partners.payroll_rate_type_id',
		'payroll_partners.payroll_schedule_id',
		'payroll_partners.salary',
		'payroll_partners.company_id',
		'payroll_partners.taxcode_id',
		'payroll_partners.minimum_takehome',
		'payroll_partners.bank_account',
		'payroll_partners.payment_type_id',
		'payroll_partners.location_id',
		'payroll_partners.fixed_rate',
		'payroll_partners.sensitivity',
		'partners.resigned_date',
		'payroll_partners.attendance_base',
		'payroll_partners.whole_half',
		'payroll_partners.on_hold',
		'payroll_partners.non_swipe',
		'payroll_partners.account_type_id'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'SSS Setup ',
	'description' => '',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(
		'payroll_partners.sss_no',
		'payroll_partners.sss_mode',
		'payroll_partners.sss_amount',
		'payroll_partners.sss_week'
	)
);
$config['fieldgroups'][3] = array(
	'fg_id' => 3,
	'label' => 'HDMF Setup ',
	'description' => '',
	'display_id' => 3,
	'sequence' => 3,
	'active' => 1,
	'fields' => array(
		'payroll_partners.hdmf_no',
		'payroll_partners.hdmf_mode',
		'payroll_partners.hdmf_amount',
		'payroll_partners.hdmf_week'
	)
);
$config['fieldgroups'][4] = array(
	'fg_id' => 4,
	'label' => 'PHIC Setup ',
	'description' => '',
	'display_id' => 3,
	'sequence' => 4,
	'active' => 1,
	'fields' => array(
		'payroll_partners.phic_no',
		'payroll_partners.phic_mode',
		'payroll_partners.phic_amount',
		'payroll_partners.phic_week'
	)
);
$config['fieldgroups'][5] = array(
	'fg_id' => 5,
	'label' => 'WHTAX Setup ',
	'description' => '',
	'display_id' => 3,
	'sequence' => 5,
	'active' => 1,
	'fields' => array(
		'payroll_partners.tin',
		'payroll_partners.tax_mode',
		'payroll_partners.tax_amount',
		'payroll_partners.tax_week'
	)
);
$config['fieldgroups'][6] = array(
	'fg_id' => 6,
	'label' => 'ECOLA Setup ',
	'description' => '',
	'display_id' => 3,
	'sequence' => 6,
	'active' => 1,
	'fields' => array(
		'payroll_partners.ecola_week'
	)
);
