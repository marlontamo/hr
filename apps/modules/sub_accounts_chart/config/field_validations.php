<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_account_sub.category_val_id'][] = array(
	'field'   => 'payroll_account_sub[category_val_id]',
	'label'   => 'Category Value',
	'rules'   => 'required'
);
$config['field_validations']['payroll_account_sub.category_value_id'][] = array(
	'field'   => 'payroll_account_sub[category_value_id]',
	'label'   => 'Category Value',
	'rules'   => 'required'
);
$config['field_validations']['payroll_account_sub.account_sub'][] = array(
	'field'   => 'payroll_account_sub[account_sub]',
	'label'   => 'Sub Account Name',
	'rules'   => 'required'
);
$config['field_validations']['payroll_account_sub.account_sub_code'][] = array(
	'field'   => 'payroll_account_sub[account_sub_code]',
	'label'   => 'Sub Account Code',
	'rules'   => 'required'
);
$config['field_validations']['payroll_account_sub.category_id'][] = array(
	'field'   => 'payroll_account_sub[category_id]',
	'label'   => 'Category',
	'rules'   => 'required'
);
$config['field_validations']['payroll_account_sub.account_id'][] = array(
	'field'   => 'payroll_account_sub[account_id]',
	'label'   => 'Account Name',
	'rules'   => 'required'
);
