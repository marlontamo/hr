<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['partners_offense_sanction.offense_level_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Level',
	'description' => '',
	'table' => 'partners_offense_sanction',
	'column' => 'offense_level_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'partners_offense_level',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'offense_level',
		'value' => 'offense_level_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['partners_offense_sanction.sanction_category_id'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Category',
	'description' => '',
	'table' => 'partners_offense_sanction',
	'column' => 'sanction_category_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'partners_offense_sanction_category',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'offense_sanction_category',
		'value' => 'offense_sanction_category_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['partners_offense_sanction.sanction'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Sanction',
	'description' => '',
	'table' => 'partners_offense_sanction',
	'column' => 'sanction',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
