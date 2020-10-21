<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_transaction.transaction_type_id'][] = array(
	'field'   => 'payroll_transaction[transaction_type_id]',
	'label'   => 'Transaction Type',
	'rules'   => 'required'
);
$config['field_validations']['payroll_transaction.transaction_code'][] = array(
	'field'   => 'payroll_transaction[transaction_code]',
	'label'   => 'Transaction Code',
	'rules'   => 'required'
);
$config['field_validations']['payroll_transaction.transaction_label'][] = array(
	'field'   => 'payroll_transaction[transaction_label]',
	'label'   => 'Transaction Label',
	'rules'   => 'required'
);
$config['field_validations']['payroll_transaction.transaction_class_id'][] = array(
	'field'   => 'payroll_transaction[transaction_class_id]',
	'label'   => 'Transaction Class',
	'rules'   => 'required'
);
$config['field_validations']['payroll_transaction.priority_id'][] = array(
	'field'   => 'payroll_transaction[priority_id]',
	'label'   => 'Priority',
	'rules'   => 'required'
);

