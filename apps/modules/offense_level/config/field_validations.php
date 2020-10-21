<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['partners_offense_level.offense_level'][] = array(
	'field'   => 'partners_offense_level[offense_level]',
	'label'   => 'Offense Level',
	'rules'   => 'required'
);
$config['field_validations']['partners_offense_level.description'][] = array(
	'field'   => 'partners_offense_level[description]',
	'label'   => 'Description',
	'rules'   => 'V'
);
$config['field_validations']['partners_offense_level.offense_level_id'][] = array(
	'field'   => 'partners_offense_level[offense_level_id]',
	'label'   => 'Offense Level',
	'rules'   => 'required'
);
