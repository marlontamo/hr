<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][4]['time_holiday.locations'] = array(
	'f_id' => 10,
	'fg_id' => 4,
	'label' => 'Location',
	'description' => '',
	'table' => 'time_holiday',
	'column' => 'locations',
	'uitype_id' => 10,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'users_location',
		'multiple' => 1,
		'group_by' => '',
		'label' => 'location',
		'value' => 'location_id',
		'textual_value_column' => ''
	)
);
$config['fields'][4]['time_holiday_location.location_id'] = array(
	'f_id' => 10,
	'fg_id' => 4,
	'label' => 'Location',
	'description' => '',
	'table' => 'time_holiday_location',
	'column' => 'location_id',
	'uitype_id' => 10,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'users_location',
		'multiple' => 1,
		'group_by' => '',
		'label' => 'location',
		'value' => 'location_id',
		'textual_value_column' => ''
	)
);
$config['fields'][3]['time_holiday.legal'] = array(
	'f_id' => 9,
	'fg_id' => 3,
	'label' => 'Type',
	'description' => '',
	'table' => 'time_holiday',
	'column' => 'legal',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][3]['time_holiday.holiday_date'] = array(
	'f_id' => 8,
	'fg_id' => 3,
	'label' => 'Date',
	'description' => '',
	'table' => 'time_holiday',
	'column' => 'holiday_date',
	'uitype_id' => 6,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][3]['time_holiday.holiday'] = array(
	'f_id' => 7,
	'fg_id' => 3,
	'label' => 'Holiday',
	'description' => '',
	'table' => 'time_holiday',
	'column' => 'holiday',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
