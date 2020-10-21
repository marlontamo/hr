<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['modules.short_name'][] = array(
	'field'   => 'modules[short_name]',
	'label'   => 'Module Name',
	'rules'   => 'required'
);
