<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_pay_set_rates.pay_set_rates'][] = array(
	'field'   => 'users_pay_set_rates[pay_set_rates]',
	'label'   => 'Pay Rates',
	'rules'   => 'required'
);
$config['field_validations']['users_pay_set_rates.pay_set_rates_code'][] = array(
	'field'   => 'users_pay_set_rates[pay_set_rates_code]',
	'label'   => 'Pay Rates Code',
	'rules'   => 'required'
);
$config['field_validations']['users_pay_set_rates.status_id'][] = array(
	'field'   => 'users_pay_set_rates[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
