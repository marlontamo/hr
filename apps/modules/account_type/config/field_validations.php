<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_account_type.account_type'][] = array(
	'field'   => 'payroll_account_type[account_type]',
	'label'   => 'Account Type',
	'rules'   => 'required'
);
