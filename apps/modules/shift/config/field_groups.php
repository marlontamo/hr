<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Shift Information',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'time_shift.shift',
		'time_shift.time_start',
		'time_shift.time_end',
		'time_shift.color',
		'time_shift.default_calendar',
		'time_shift.use_tag'
	)
);
