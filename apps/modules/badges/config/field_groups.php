<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Badges',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'play_badges.badge_code',
		'play_badges.badge',
		'play_badges.points',
		'play_badges.description',
		'play_badges.image_path'
	)
);
