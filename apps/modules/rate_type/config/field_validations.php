<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_rate_type.payroll_rate_type'][] = array(
	'field'   => 'payroll_rate_type[payroll_rate_type]',
	'label'   => 'Rate Type',
	'rules'   => 'required'
);
