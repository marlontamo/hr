<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['partners_offense_category.description'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => '',
	'table' => 'partners_offense_category',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['partners_offense_category.offense_category'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Offense Category',
	'description' => '',
	'table' => 'partners_offense_category',
	'column' => 'offense_category',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'V',
	'active' => '1',
	'encrypt' => 0
);
