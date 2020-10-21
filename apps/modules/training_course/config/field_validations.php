<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['training_course.provider_id'][] = array(
	'field'   => 'training_course[provider_id]',
	'label'   => 'Provider',
	'rules'   => 'required'
);
$config['field_validations']['training_course.type_id'][] = array(
	'field'   => 'training_course[type_id]',
	'label'   => 'Type',
	'rules'   => 'required'
);
$config['field_validations']['training_course.category_id'][] = array(
	'field'   => 'training_course[category_id]',
	'label'   => 'Category',
	'rules'   => 'required'
);
$config['field_validations']['training_course.course'][] = array(
	'field'   => 'training_course[course]',
	'label'   => 'Course',
	'rules'   => 'required'
);
