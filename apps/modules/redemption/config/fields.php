<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['play_redeemable.image_path'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Image',
	'description' => '',
	'table' => 'play_redeemable',
	'column' => 'image_path',
	'uitype_id' => 8,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['play_redeemable.description'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => '',
	'table' => 'play_redeemable',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['play_redeemable.points'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Points',
	'description' => '',
	'table' => 'play_redeemable',
	'column' => 'points',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['play_redeemable.item'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Item',
	'description' => '',
	'table' => 'play_redeemable',
	'column' => 'item',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
