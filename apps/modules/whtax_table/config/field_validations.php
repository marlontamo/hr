<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_whtax_table.payroll_schedule_id'][] = array(
	'field'   => 'payroll_whtax_table[payroll_schedule_id]',
	'label'   => 'Frequency ',
	'rules'   => 'required'
);
$config['field_validations']['payroll_whtax_table.taxcode_id'][] = array(
	'field'   => 'payroll_whtax_table[taxcode_id]',
	'label'   => 'Tax Code',
	'rules'   => 'required'
);
$config['field_validations']['payroll_whtax_table.salary_from'][] = array(
	'field'   => 'payroll_whtax_table[salary_from]',
	'label'   => 'Salary From',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_whtax_table.salary_to'][] = array(
	'field'   => 'payroll_whtax_table[salary_to]',
	'label'   => 'Salary To',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_whtax_table.fixed_amount'][] = array(
	'field'   => 'payroll_whtax_table[fixed_amount]',
	'label'   => 'Fixed Amount',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_whtax_table.excess_percentage'][] = array(
	'field'   => 'payroll_whtax_table[excess_percentage]',
	'label'   => 'Excess Percentage',
	'rules'   => 'required|numeric'
);
