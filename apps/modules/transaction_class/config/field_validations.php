<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_transaction_class.transaction_class_code'][] = array(
	'field'   => 'payroll_transaction_class[transaction_class_code]',
	'label'   => 'Class Code',
	'rules'   => 'required'
);
$config['field_validations']['payroll_transaction_class.transaction_class'][] = array(
	'field'   => 'payroll_transaction_class[transaction_class]',
	'label'   => 'Class Name',
	'rules'   => 'required'
);
