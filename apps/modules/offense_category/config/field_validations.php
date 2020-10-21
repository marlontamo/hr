<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['partners_offense_category.description'][] = array(
	'field'   => 'partners_offense_category[description]',
	'label'   => 'Description',
	'rules'   => 'V'
);
$config['field_validations']['partners_offense_category.offense_category'][] = array(
	'field'   => 'partners_offense_category[offense_category]',
	'label'   => 'Offense Category',
	'rules'   => 'required'
);
