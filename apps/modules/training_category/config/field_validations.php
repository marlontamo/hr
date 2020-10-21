<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['training_category.description'][] = array(
	'field'   => 'training_category[description]',
	'label'   => 'Description',
	'rules'   => 'required'
);
$config['field_validations']['training_category.category_code'][] = array(
	'field'   => 'training_category[category_code]',
	'label'   => 'Category Code',
	'rules'   => 'required'
);
$config['field_validations']['training_category.category'][] = array(
	'field'   => 'training_category[category]',
	'label'   => 'Category',
	'rules'   => 'required'
);
