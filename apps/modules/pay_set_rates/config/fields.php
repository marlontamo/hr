<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['users_pay_set_rates.pay_set_rates'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Pay Step Rates',
	'description' => '',
	'table' => 'users_pay_set_rates',
	'column' => 'pay_set_rates',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_pay_set_rates.pay_set_rates_code'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Pay Step Rates Code',
	'description' => '',
	'table' => 'users_pay_set_rates',
	'column' => 'pay_set_rates_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_pay_set_rates.status_id'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Active',
	'description' => '',
	'table' => 'users_pay_set_rates',
	'column' => 'status_id',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
