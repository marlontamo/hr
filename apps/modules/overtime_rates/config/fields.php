<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][2]['payroll_overtime_rates.overtime_rate'] = array(
	'f_id' => 3,
	'fg_id' => 2,
	'label' => 'Rates',
	'description' => '',
	'table' => 'payroll_overtime_rates',
	'column' => 'overtime_rate',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['payroll_overtime_rates.overtime_id'] = array(
	'f_id' => 2,
	'fg_id' => 2,
	'label' => 'Overtime',
	'description' => '',
	'table' => 'payroll_overtime_rates',
	'column' => 'overtime_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'Overtime',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'payroll_overtime',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'overtime_code',
		'value' => 'overtime_id',
		'textual_value_column' => ''
	)
);
$config['fields'][2]['payroll_overtime_rates.company_id'] = array(
	'f_id' => 1,
	'fg_id' => 2,
	'label' => 'Company',
	'description' => '',
	'table' => 'payroll_overtime_rates',
	'column' => 'company_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'Company',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'users_company',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'company',
		'value' => 'company_id',
		'textual_value_column' => ''
	)
);
