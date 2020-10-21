<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['partners_offense.sanction_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Offense Level',
	'description' => '',
	'table' => 'partners_offense',
	'column' => 'sanction_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'partners_offense_sanction',
		'multiple' => 1,
		'group_by' => '',
		'label' => 'sanction',
		'value' => 'sanction_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['partners_offense.offense_category_id'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Offense Category',
	'description' => '',
	'table' => 'partners_offense',
	'column' => 'offense_category_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'partners_offense_category',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'offense_category',
		'value' => 'offense_category_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['partners_offense.offense'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Offense',
	'description' => '',
	'table' => 'partners_offense',
	'column' => 'offense',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
