<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_leave_conversion_period.status'][] = array(
	'field'   => 'payroll_leave_conversion_period[status]',
	'label'   => 'Status',
	'rules'   => 'required'
);
$config['field_validations']['payroll_leave_conversion_period.apply_to_id'][] = array(
	'field'   => 'payroll_leave_conversion_period[apply_to_id]',
	'label'   => 'Apply To',
	'rules'   => 'required'
);
$config['field_validations']['payroll_leave_conversion_period.year'][] = array(
	'field'   => 'payroll_leave_conversion_period[year]',
	'label'   => 'Year',
	'rules'   => 'required'
);
$config['field_validations']['payroll_leave_conversion_period.payroll_date'][] = array(
	'field'   => 'payroll_leave_conversion_period[payroll_date]',
	'label'   => 'Payroll Date',
	'rules'   => 'required'
);
