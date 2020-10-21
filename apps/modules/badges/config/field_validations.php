<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['play_badges.image_path'][] = array(
	'field'   => 'play_badges[image_path]',
	'label'   => 'Image/Icon',
	'rules'   => 'required'
);
$config['field_validations']['play_badges.points'][] = array(
	'field'   => 'play_badges[points]',
	'label'   => 'Points',
	'rules'   => 'required'
);
$config['field_validations']['play_badges.badge'][] = array(
	'field'   => 'play_badges[badge]',
	'label'   => 'Name',
	'rules'   => 'required'
);
$config['field_validations']['play_badges.badge_code'][] = array(
	'field'   => 'play_badges[badge_code]',
	'label'   => 'Code',
	'rules'   => 'required'
);
