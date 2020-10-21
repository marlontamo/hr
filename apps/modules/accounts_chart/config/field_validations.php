<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_account.arrangement'][] = array(
	'field'   => 'payroll_account[arrangement]',
	'label'   => 'Order',
	'rules'   => 'required'
);
$config['field_validations']['payroll_account.account_code'][] = array(
	'field'   => 'payroll_account[account_code]',
	'label'   => 'Account Code',
	'rules'   => 'required'
);
$config['field_validations']['payroll_account.account_name'][] = array(
	'field'   => 'payroll_account[account_name]',
	'label'   => 'Account Name',
	'rules'   => 'required'
);
$config['field_validations']['payroll_account.account_type_id'][] = array(
	'field'   => 'payroll_account[account_type_id]',
	'label'   => 'Account Type',
	'rules'   => 'required'
);
