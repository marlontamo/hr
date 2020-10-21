<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][2]['time_shift_weekly.calendar'] = array(
	'f_id' => 1,
	'fg_id' => 2,
	'label' => 'Shift Name',
	'description' => '',
	'table' => 'time_shift_weekly',
	'column' => 'calendar',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['time_shift_weekly.default'] = array(
	'f_id' => 2,
	'fg_id' => 2,
	'label' => 'Default',
	'description' => '',
	'table' => 'time_shift_weekly',
	'column' => 'default',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);