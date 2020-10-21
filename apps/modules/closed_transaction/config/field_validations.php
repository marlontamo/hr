<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_current_transaction.amount'][] = array(
	'field'   => 'payroll_current_transaction[amount]',
	'label'   => 'Amount',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_current_transaction.unit_rate'][] = array(
	'field'   => 'payroll_current_transaction[unit_rate]',
	'label'   => 'Unit Rate',
	'rules'   => 'require|numeric'
);
$config['field_validations']['payroll_current_transaction.quantity'][] = array(
	'field'   => 'payroll_current_transaction[quantity]',
	'label'   => 'Quantity',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_current_transaction.payroll_date'][] = array(
	'field'   => 'payroll_current_transaction[payroll_date]',
	'label'   => 'Payroll Date',
	'rules'   => 'required'
);
$config['field_validations']['payroll_current_transaction.employee_id'][] = array(
	'field'   => 'payroll_current_transaction[employee_id]',
	'label'   => 'Employee',
	'rules'   => 'required'
);
$config['field_validations']['payroll_current_transaction.processing_type_id'][] = array(
	'field'   => 'payroll_current_transaction[processing_type_id]',
	'label'   => 'Processing Type',
	'rules'   => 'required'
);
$config['field_validations']['payroll_current_transaction.transaction_id'][] = array(
	'field'   => 'payroll_current_transaction[transaction_id]',
	'label'   => 'Transaction',
	'rules'   => 'required'
);
