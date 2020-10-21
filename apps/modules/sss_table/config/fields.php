<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['payroll_sss_table.from'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Salary From',
	'description' => '',
	'table' => 'payroll_sss_table',
	'column' => 'from',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_sss_table.to'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Salary To',
	'description' => '',
	'table' => 'payroll_sss_table',
	'column' => 'to',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_sss_table.eeshare'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Employee Share',
	'description' => '',
	'table' => 'payroll_sss_table',
	'column' => 'eeshare',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_sss_table.ershare'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Employer Share',
	'description' => '',
	'table' => 'payroll_sss_table',
	'column' => 'ershare',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_sss_table.ec'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'EC',
	'description' => '',
	'table' => 'payroll_sss_table',
	'column' => 'ec',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => 'required|numeric',
	'active' => '1',
	'encrypt' => 0
);
