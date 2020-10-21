<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['performance_competency_level.competency_category_id'][] = array(
	'field'   => 'performance_competency_level[competency_category_id]',
	'label'   => 'Category',
	'rules'   => 'required'
);
$config['field_validations']['performance_competency_level.competency_values_id'][] = array(
	'field'   => 'performance_competency_level[competency_values_id]',
	'label'   => 'Value',
	'rules'   => 'required'
);
$config['field_validations']['performance_competency_level.competency_libraries_id'][] = array(
	'field'   => 'performance_competency_level[competency_libraries_id]',
	'label'   => 'Competency',
	'rules'   => 'required'
);
$config['field_validations']['performance_competency_level.competency_level'][] = array(
	'field'   => 'performance_competency_level[competency_level]',
	'label'   => 'Level',
	'rules'   => 'required'
);
$config['field_validations']['performance_competency_level.description'][] = array(
	'field'   => 'performance_competency_level[description]',
	'label'   => 'Description',
	'rules'   => 'required'
);
