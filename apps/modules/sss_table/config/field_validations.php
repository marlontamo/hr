<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_sss_table.from'][] = array(
	'field'   => 'payroll_sss_table[from]',
	'label'   => 'Salary From',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_sss_table.to'][] = array(
	'field'   => 'payroll_sss_table[to]',
	'label'   => 'Salary To',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_sss_table.eeshare'][] = array(
	'field'   => 'payroll_sss_table[eeshare]',
	'label'   => 'Employee Share',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_sss_table.ershare'][] = array(
	'field'   => 'payroll_sss_table[ershare]',
	'label'   => 'Employer Share',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_sss_table.ec'][] = array(
	'field'   => 'payroll_sss_table[ec]',
	'label'   => 'EC',
	'rules'   => 'required|numeric'
);
