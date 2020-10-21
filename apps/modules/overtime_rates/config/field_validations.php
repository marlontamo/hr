<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_overtime_rates.overtime_id'][] = array(
	'field'   => 'payroll_overtime_rates[overtime_id]',
	'label'   => 'Overtime',
	'rules'   => 'required'
);
$config['field_validations']['payroll_overtime_rates.company_id'][] = array(
	'field'   => 'payroll_overtime_rates[company_id]',
	'label'   => 'Company',
	'rules'   => 'required'
);
$config['field_validations']['payroll_overtime_rates.overtime_rate'][] = array(
	'field'   => 'payroll_overtime_rates[overtime_rate]',
	'label'   => 'Rate',
	'rules'   => 'required|numeric'
);
