<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['play_redeemable.image_path'][] = array(
	'field'   => 'play_redeemable[image_path]',
	'label'   => 'Image',
	'rules'   => 'required'
);
$config['field_validations']['play_redeemable.points'][] = array(
	'field'   => 'play_redeemable[points]',
	'label'   => 'Points',
	'rules'   => 'required'
);
$config['field_validations']['play_redeemable.item'][] = array(
	'field'   => 'play_redeemable[item]',
	'label'   => 'Item',
	'rules'   => 'required'
);
