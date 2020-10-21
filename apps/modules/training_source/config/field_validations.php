<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['training_source.description'][] = array(
	'field'   => 'training_source[description]',
	'label'   => 'Description',
	'rules'   => 'required'
);
$config['field_validations']['training_source.source'][] = array(
	'field'   => 'training_source[source]',
	'label'   => 'Source',
	'rules'   => 'required'
);
$config['field_validations']['training_source.source_code'][] = array(
	'field'   => 'training_source[source_code]',
	'label'   => 'Code',
	'rules'   => 'required'
);
