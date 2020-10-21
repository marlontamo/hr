<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['performance_competency_category.description'][] = array(
	'field'   => 'performance_competency_category[description]',
	'label'   => 'Description',
	'rules'   => 'required'
);
$config['field_validations']['performance_competency_category.competency_category'][] = array(
	'field'   => 'performance_competency_category[competency_category]',
	'label'   => 'Category',
	'rules'   => 'required'
);
