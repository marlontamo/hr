<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['partners_offense_level.offense_level'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Offense Level',
	'description' => '',
	'table' => 'partners_offense_level',
	'column' => 'offense_level',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['partners_offense_level.description'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => '',
	'table' => 'partners_offense_level',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['partners_offense_level.offense_level_id'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Offense Level',
	'description' => '',
	'table' => 'partners_offense_level',
	'column' => 'offense_level_id',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
