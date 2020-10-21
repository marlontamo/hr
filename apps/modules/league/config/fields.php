<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['play_league.description'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => '',
	'table' => 'play_league',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['play_league.league'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Name',
	'description' => '',
	'table' => 'play_league',
	'column' => 'league',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['play_league.league_code'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Code',
	'description' => '',
	'table' => 'play_league',
	'column' => 'league_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
