<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['payroll_annual_tax.salary_from'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Salary From',
	'description' => '',
	'table' => 'payroll_annual_tax',
	'column' => 'salary_from',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_annual_tax.salary_to'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Salary To',
	'description' => '',
	'table' => 'payroll_annual_tax',
	'column' => 'salary_to',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_annual_tax.amount'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Fixed Amount',
	'description' => '',
	'table' => 'payroll_annual_tax',
	'column' => 'amount',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_annual_tax.rate'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Excess Rate',
	'description' => '',
	'table' => 'payroll_annual_tax',
	'column' => 'rate',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required|numeric|greater_than[0]|less_than[100]',
	'active' => '1',
	'encrypt' => 0
);
