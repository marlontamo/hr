<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['training_provider.description'][] = array(
	'field'   => 'training_provider[description]',
	'label'   => 'Description',
	'rules'   => 'required'
);
$config['field_validations']['training_provider.provider_code'][] = array(
	'field'   => 'training_provider[provider_code]',
	'label'   => 'Code',
	'rules'   => 'required'
);
$config['field_validations']['training_provider.provider'][] = array(
	'field'   => 'training_provider[provider]',
	'label'   => 'Provider',
	'rules'   => 'required'
);
