<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['report_generator.roles'][] = array(
	'field'   => 'report_generator[roles]',
	'label'   => 'Accessed By',
	'rules'   => 'required'
);
$config['field_validations']['report_generator.profile'][] = array(
	'field'   => 'report_generator[profile]',
	'label'   => 'Accessed By',
	'rules'   => 'required'
);
$config['field_validations']['report_generator.category_id'][] = array(
	'field'   => 'report_generator[category_id]',
	'label'   => 'Category',
	'rules'   => 'required'
);
$config['field_validations']['report_generator.report_name'][] = array(
	'field'   => 'report_generator[report_name]',
	'label'   => 'Report Title',
	'rules'   => 'required'
);
$config['field_validations']['report_generator.report_code'][] = array(
	'field'   => 'report_generator[report_code]',
	'label'   => 'Report Code',
	'rules'   => 'required'
);
