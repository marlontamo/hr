<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['partners_offense_sanction.offense_level_id'][] = array(
	'field'   => 'partners_offense_sanction[offense_level_id]',
	'label'   => 'Level',
	'rules'   => 'required'
);
$config['field_validations']['partners_offense_sanction.sanction_category_id'][] = array(
	'field'   => 'partners_offense_sanction[sanction_category_id]',
	'label'   => 'Category',
	'rules'   => 'required'
);
$config['field_validations']['partners_offense_sanction.sanction'][] = array(
	'field'   => 'partners_offense_sanction[sanction]',
	'label'   => 'Sanction',
	'rules'   => 'required'
);
