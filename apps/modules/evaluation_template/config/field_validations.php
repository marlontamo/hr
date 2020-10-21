<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['training_evaluation_template.applicable_for'][] = array(
	'field'   => 'training_evaluation_template[applicable_for]',
	'label'   => 'Applicable For',
	'rules'   => 'required'
);
$config['field_validations']['training_evaluation_template.title'][] = array(
	'field'   => 'training_evaluation_template[title]',
	'label'   => 'Evaluation Title',
	'rules'   => 'required'
);
