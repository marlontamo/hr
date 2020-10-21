<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['partners_employment_type.employment_type'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Employment Type',
	'description' => '',
	'table' => 'partners_employment_type',
	'column' => 'employment_type',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['partners_employment_type.active'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Active',
	'description' => '',
	'table' => 'partners_employment_type',
	'column' => 'active',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);