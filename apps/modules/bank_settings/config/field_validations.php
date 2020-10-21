<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_bank.bank_type'][] = array(
	'field'   => 'payroll_bank[bank_type]',
	'label'   => 'Bank Type',
	'rules'   => 'required'
);
$config['field_validations']['payroll_bank.account_no'][] = array(
	'field'   => 'payroll_bank[account_no]',
	'label'   => 'Account Number',
	'rules'   => 'required'
);
$config['field_validations']['payroll_bank.bank'][] = array(
	'field'   => 'payroll_bank[bank]',
	'label'   => 'Bank Name',
	'rules'   => 'required'
);
$config['field_validations']['payroll_bank.account_name'][] = array(
	'field'   => 'payroll_bank[account_name]',
	'label'   => 'Account Name',
	'rules'   => 'required'
);
$config['field_validations']['payroll_bank.ceiling_amount'][] = array(
	'field'   => 'payroll_bank[ceiling_amount]',
	'label'   => 'Ceiling Amount',
	'rules'   => 'numeric'
);
