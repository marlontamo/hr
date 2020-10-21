<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['payroll_late_exemption.lates_exemption'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Late Exemption',
	'description' => '',
	'table' => 'payroll_late_exemption',
	'column' => 'lates_exemption',
	'uitype_id' => 20,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['payroll_late_exemption.employment_type_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Employment Type',
	'description' => '',
	'table' => 'payroll_late_exemption',
	'column' => 'employment_type_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'partners_employment_type',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'employment_type_id',
		'value' => 'employment_type',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['payroll_late_exemption.company_id'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Company',
	'description' => '',
	'table' => 'payroll_late_exemption',
	'column' => 'company_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
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
