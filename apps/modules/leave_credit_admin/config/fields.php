<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][2]['time_form_balance.current'] = array(
	'f_id' => 5,
	'fg_id' => 2,
	'label' => 'Current Credit',
	'description' => 'Current Credit',
	'table' => 'time_form_balance',
	'column' => 'current',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['time_form_balance.previous'] = array(
	'f_id' => 4,
	'fg_id' => 2,
	'label' => 'Previous Credit',
	'description' => 'Previous Credit',
	'table' => 'time_form_balance',
	'column' => 'previous',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['time_form_balance.form_id'] = array(
	'f_id' => 3,
	'fg_id' => 2,
	'label' => 'Leave Type',
	'description' => 'Leave Type',
	'table' => 'time_form_balance',
	'column' => 'form_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '2',
		'table' => 'SELECT * FROM ww_time_form WHERE is_leave = 1',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'form',
		'value' => 'form_id',
		'textual_value_column' => ''
	)
);
$config['fields'][2]['time_form_balance.user_id'] = array(
	'f_id' => 2,
	'fg_id' => 2,
	'label' => 'Partner',
	'description' => 'Partner',
	'table' => 'time_form_balance',
	'column' => 'user_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'users',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'display_name',
		'value' => 'user_id',
		'textual_value_column' => ''
	)
);
$config['fields'][2]['time_form_balance.year'] = array(
	'f_id' => 1,
	'fg_id' => 2,
	'label' => 'Year',
	'description' => 'Year',
	'table' => 'time_form_balance',
	'column' => 'year',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][2]['time_form_balance.period_extension'] = array(
	'f_id' => 6,
	'fg_id' => 2,
	'label' => 'Expiration Date',
	'description' => 'Expiration Date',
	'table' => 'time_form_balance',
	'column' => 'period_extension',
	'uitype_id' => 6,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 6,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
