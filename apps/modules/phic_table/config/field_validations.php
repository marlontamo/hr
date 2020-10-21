<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_phic_table.from'][] = array(
	'field'   => 'payroll_phic_table[from]',
	'label'   => 'Salary From',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_phic_table.to'][] = array(
	'field'   => 'payroll_phic_table[to]',
	'label'   => 'Salary To',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_phic_table.eeshare'][] = array(
	'field'   => 'payroll_phic_table[eeshare]',
	'label'   => 'Employee Share',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_phic_table.ershare'][] = array(
	'field'   => 'payroll_phic_table[ershare]',
	'label'   => 'Employer Share',
	'rules'   => 'required|numeric'
);

