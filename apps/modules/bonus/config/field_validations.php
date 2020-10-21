<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_bonus.bonus_transaction_id'][] = array(
	'field'   => 'payroll_bonus[bonus_transaction_id]',
	'label'   => 'Bonus Type',
	'rules'   => 'required'
);
$config['field_validations']['payroll_bonus.payroll_date'][] = array(
	'field'   => 'payroll_bonus[payroll_date]',
	'label'   => 'Payroll Date',
	'rules'   => 'required'
);
$config['field_validations']['payroll_bonus.date_from'][] = array(
	'field'   => 'payroll_bonus[date_from]',
	'label'   => 'Period from',
	'rules'   => 'required'
);
$config['field_validations']['payroll_bonus.date_to'][] = array(
	'field'   => 'payroll_bonus[date_to]',
	'label'   => 'Period to',
	'rules'   => 'required'
);
$config['field_validations']['payroll_bonus.period'][] = array(
	'field'   => 'payroll_bonus[period]',
	'label'   => 'No. of Periods',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_bonus.week'][] = array(
	'field'   => 'payroll_bonus[week]',
	'label'   => 'Apply Week/s',
	'rules'   => 'required'
);
$config['field_validations']['payroll_bonus.transaction_method_id'][] = array(
	'field'   => 'payroll_bonus[transaction_method_id]',
	'label'   => 'Method',
	'rules'   => 'required'
);
$config['field_validations']['payroll_bonus.account_id'][] = array(
	'field'   => 'payroll_bonus[account_id]',
	'label'   => 'Account',
	'rules'   => 'required'
);
