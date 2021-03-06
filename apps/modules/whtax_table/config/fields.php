<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['payroll_whtax_table.payroll_schedule_id'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Frequency ',
	'description' => '',
	'table' => 'payroll_whtax_table',
	'column' => 'payroll_schedule_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'payroll_schedule',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'payroll_schedule',
		'value' => 'payroll_schedule_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_whtax_table.taxcode_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Tax Code',
	'description' => '',
	'table' => 'payroll_whtax_table',
	'column' => 'taxcode_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'taxcode',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'taxcode',
		'value' => 'taxcode_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_whtax_table.salary_from'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Salary From',
	'description' => '',
	'table' => 'payroll_whtax_table',
	'column' => 'salary_from',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_whtax_table.salary_to'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Salary To',
	'description' => '',
	'table' => 'payroll_whtax_table',
	'column' => 'salary_to',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_whtax_table.fixed_amount'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'Fixed Amount',
	'description' => '',
	'table' => 'payroll_whtax_table',
	'column' => 'fixed_amount',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_whtax_table.excess_percentage'] = array(
	'f_id' => 6,
	'fg_id' => 1,
	'label' => 'Excess Percentage',
	'description' => '',
	'table' => 'payroll_whtax_table',
	'column' => 'excess_percentage',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 6,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
