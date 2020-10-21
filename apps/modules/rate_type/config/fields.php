<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['payroll_rate_type.payroll_rate_type'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Rate Type',
	'description' => '',
	'table' => 'payroll_rate_type',
	'column' => 'payroll_rate_type',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_rate_type.description'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => '',
	'table' => 'payroll_rate_type',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);