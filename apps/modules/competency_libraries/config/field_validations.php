<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['performance_competency_libraries.competency_category_id'][] = array(
	'field'   => 'performance_competency_libraries[competency_category_id]',
	'label'   => 'Category',
	'rules'   => 'required'
);
$config['field_validations']['performance_competency_libraries.competency_values_id'][] = array(
	'field'   => 'performance_competency_libraries[competency_values_id]',
	'label'   => 'Value',
	'rules'   => 'required'
);
$config['field_validations']['performance_competency_libraries.competency_libraries'][] = array(
	'field'   => 'performance_competency_libraries[competency_libraries]',
	'label'   => 'Library',
	'rules'   => 'required'
);
$config['field_validations']['performance_competency_libraries.description'][] = array(
	'field'   => 'performance_competency_libraries[description]',
	'label'   => 'Description',
	'rules'   => 'required'
);
