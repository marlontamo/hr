<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][3] = array(
	'fg_id' => 3,
	'label' => 'Holiday Information',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'time_holiday.holiday',
		'time_holiday.holiday_date',
		'time_holiday.legal'
	)
);
$config['fieldgroups'][4] = array(
	'fg_id' => 4,
	'label' => 'For Special Holiday',
	'description' => '',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(
		'time_holiday_location.location_id'
	)
);
