<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Pay Step Rates Information',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'users_pay_set_rates.pay_set_rates',
		'users_pay_set_rates.pay_set_rates_code',
		'users_pay_set_rates.status_id'
	)
);
