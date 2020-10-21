<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['ww_payroll_overtime_rates_amount.overtime_amount'][] = array(
	'field'   => 'ww_payroll_overtime_rates_amount[overtime_amount]',
	'label'   => 'Amount',
	'rules'   => 'required'
);
$config['field_validations']['ww_payroll_overtime_rates_amount.overtime_id'][] = array(
	'field'   => 'ww_payroll_overtime_rates_amount[overtime_id]',
	'label'   => 'Overtime',
	'rules'   => 'required'
);
$config['field_validations']['ww_payroll_overtime_rates_amount.overtime_location_id'][] = array(
	'field'   => 'ww_payroll_overtime_rates_amount[overtime_location_id]',
	'label'   => 'Location',
	'rules'   => 'required'
);
$config['field_validations']['ww_payroll_overtime_rates_amount.company_id'][] = array(
	'field'   => 'ww_payroll_overtime_rates_amount[company_id]',
	'label'   => 'Company',
	'rules'   => 'required'
);
$config['field_validations']['ww_payroll_overtime_rates_amount.employment_type_id'][] = array(
	'field'   => 'ww_payroll_overtime_rates_amount[employment_type_id]',
	'label'   => 'Employment Type',
	'rules'   => 'required'
);
