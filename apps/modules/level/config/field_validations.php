<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['play_level.points_to'][] = array(
	'field'   => 'play_level[points_to]',
	'label'   => 'Points To',
	'rules'   => 'required'
);
$config['field_validations']['play_level.points_fr'][] = array(
	'field'   => 'play_level[points_fr]',
	'label'   => 'Points From',
	'rules'   => 'required'
);
$config['field_validations']['play_level.league_id'][] = array(
	'field'   => 'play_level[league_id]',
	'label'   => 'League',
	'rules'   => 'required'
);
$config['field_validations']['play_level.level'][] = array(
	'field'   => 'play_level[level]',
	'label'   => 'Level',
	'rules'   => 'required'
);
