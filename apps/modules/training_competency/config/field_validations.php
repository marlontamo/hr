<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['training_competency.description'][] = array(
	'field'   => 'training_competency[description]',
	'label'   => 'Description',
	'rules'   => 'required'
);
$config['field_validations']['training_competency.competency_code'][] = array(
	'field'   => 'training_competency[competency_code]',
	'label'   => 'Code',
	'rules'   => 'required'
);
$config['field_validations']['training_competency.competency'][] = array(
	'field'   => 'training_competency[competency]',
	'label'   => 'Competency',
	'rules'   => 'required'
);
