<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_leave_conversion.employment_type_id'][] = array(
	'field'   => 'payroll_leave_conversion[employment_type_id]',
	'label'   => 'Employment Type',
	'rules'   => ''
);
$config['field_validations']['payroll_leave_conversion.forfeited'][] = array(
	'field'   => 'payroll_leave_conversion[forfeited]',
	'label'   => 'Forfeited',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_leave_conversion.convertible'][] = array(
	'field'   => 'payroll_leave_conversion[convertible]',
	'label'   => 'Covertible',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_leave_conversion.form_id'][] = array(
	'field'   => 'payroll_leave_conversion[form_id]',
	'label'   => 'Form Type',
	'rules'   => 'required'
);
$config['field_validations']['payroll_leave_conversion.company_id'][] = array(
	'field'   => 'payroll_leave_conversion[company_id]',
	'label'   => 'Company',
	'rules'   => 'required'
);
$config['field_validations']['payroll_leave_conversion.nontax'][] = array(
	'field'   => 'payroll_leave_conversion[nontax]',
	'label'   => 'Non-Taxable',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_leave_conversion.taxable'][] = array(
	'field'   => 'payroll_leave_conversion[taxable]',
	'label'   => 'Taxable',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_leave_conversion.carry_over'][] = array(
	'field'   => 'payroll_leave_conversion[carry_over]',
	'label'   => 'Carry Over',
	'rules'   => 'numeric'
);
