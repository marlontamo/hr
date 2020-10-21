<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['play_badges.image_path'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'Image/Icon',
	'description' => '',
	'table' => 'play_badges',
	'column' => 'image_path',
	'uitype_id' => 8,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['play_badges.description'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => '',
	'table' => 'play_badges',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['play_badges.points'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Points',
	'description' => '',
	'table' => 'play_badges',
	'column' => 'points',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['play_badges.badge'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Name',
	'description' => '',
	'table' => 'play_badges',
	'column' => 'badge',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['play_badges.badge_code'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Code',
	'description' => '',
	'table' => 'play_badges',
	'column' => 'badge_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
