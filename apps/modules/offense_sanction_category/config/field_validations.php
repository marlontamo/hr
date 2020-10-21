<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['partners_offense_sanction_category.description'][] = array(
	'field'   => 'partners_offense_sanction_category[description]',
	'label'   => 'Description',
	'rules'   => 'V'
);
$config['field_validations']['partners_offense_sanction_category.offense_sanction_category'][] = array(
	'field'   => 'partners_offense_sanction_category[offense_sanction_category]',
	'label'   => 'Offense Sanction Category',
	'rules'   => 'required'
);
