<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['partners_employment_status.employment_status'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Employment Status',
	'description' => 'Employment Status',
	'table' => 'partners_employment_status',
	'column' => 'employment_status',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['partners_employment_status.active'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Active',
	'description' => 'employment status type',
	'table' => 'partners_employment_status',
	'column' => 'active',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
