<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['partners_offense.sanction_id'][] = array(
	'field'   => 'partners_offense[sanction_id]',
	'label'   => 'Offense Level',
	'rules'   => 'required'
);
$config['field_validations']['partners_offense.offense_category_id'][] = array(
	'field'   => 'partners_offense[offense_category_id]',
	'label'   => 'Offense Category',
	'rules'   => 'required'
);
$config['field_validations']['partners_offense.offense'][] = array(
	'field'   => 'partners_offense[offense]',
	'label'   => 'Offense',
	'rules'   => 'required'
);
