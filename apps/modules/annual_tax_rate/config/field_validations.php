<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_annual_tax.salary_from'][] = array(
	'field'   => 'payroll_annual_tax[salary_from]',
	'label'   => 'Salary From',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_annual_tax.salary_to'][] = array(
	'field'   => 'payroll_annual_tax[salary_to]',
	'label'   => 'Salary To',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_annual_tax.amount'][] = array(
	'field'   => 'payroll_annual_tax[amount]',
	'label'   => 'Fixed Amount',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_annual_tax.rate'][] = array(
	'field'   => 'payroll_annual_tax[rate]',
	'label'   => 'Excess Rate',
	'rules'   => 'required|numeric|greater_than[0]|less_than[100]'
);
