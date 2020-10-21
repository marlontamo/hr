<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['training_type.description'][] = array(
	'field'   => 'training_type[description]',
	'label'   => 'Description',
	'rules'   => 'required'
);
$config['field_validations']['training_type.training_type'][] = array(
	'field'   => 'training_type[training_type]',
	'label'   => 'Type',
	'rules'   => 'required'
);
$config['field_validations']['training_type.training_type_code'][] = array(
	'field'   => 'training_type[training_type_code]',
	'label'   => 'Code',
	'rules'   => 'required'
);
