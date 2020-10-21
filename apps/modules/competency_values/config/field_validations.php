<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['performance_competency_values.competency_category_id'][] = array(
	'field'   => 'performance_competency_values[competency_category_id]',
	'label'   => 'Category',
	'rules'   => 'required'
);
$config['field_validations']['performance_competency_values.competency_values'][] = array(
	'field'   => 'performance_competency_values[competency_values]',
	'label'   => 'Competency Value',
	'rules'   => 'required'
);
$config['field_validations']['performance_competency_values.description'][] = array(
	'field'   => 'performance_competency_values[description]',
	'label'   => 'Description',
	'rules'   => 'required'
);
