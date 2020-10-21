<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_transaction_mode.payroll_transaction_mode'][] = array(
	'field'   => 'payroll_transaction_mode[payroll_transaction_mode]',
	'label'   => 'Mode Name',
	'rules'   => 'required'
);
$config['field_validations']['payroll_transaction_method.payroll_transaction_method'][] = array(
	'field'   => 'payroll_transaction_method[payroll_transaction_method]',
	'label'   => 'Mode Name',
	'rules'   => 'required'
);
