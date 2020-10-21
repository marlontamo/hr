<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['play_level.description'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => '',
	'table' => 'play_level',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['play_level.points_to'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Points To',
	'description' => '',
	'table' => 'play_level',
	'column' => 'points_to',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['play_level.points_fr'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Points From',
	'description' => '',
	'table' => 'play_level',
	'column' => 'points_fr',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['play_level.league_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'League',
	'description' => '',
	'table' => 'play_level',
	'column' => 'league_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'play_league',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'league',
		'value' => 'league_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['play_level.level'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Level',
	'description' => '',
	'table' => 'play_level',
	'column' => 'level',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
